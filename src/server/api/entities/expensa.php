<?php
require_once './../../utils/autoload.php';

class Expensa
{
    private $connection;
    private $validator;    
    private $query;
    private $tabla = "expensa";
    /* Campos de la tabla */
    private $cuotaExtraordinaria; // $this->setCuotaExtraordinaria($cuotaExtraordinaria)
    private $idExpensa; // $this->setIdExpensa($idExpensa)
    private $cuotaExpensa; // $this->setCuotaExpensa($cuotaExpensa)
    private $cuotaMora; // $this->setCuotaMora($cuotaMora)
    private $cuotaMes; // $this->setCuotaMes($cuotaMes)
    private $cuotaVencimiento; // $this->setCuotaVencimiento($cuotaVencimiento)
    private $cuotaEstado; // $this->setCuotaEstado($cuotaEstado)
    private $id_ctacte; // $this->setIdCtaCte($id_ctacte)
    private $id_gasto_mensual; // $this->setIdGastoMensual($id_gasto_mensual)

    public function __construct($connection)
    {
        $this->connection = $connection;
        try{ $this->validator = new Validator; }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
    }


    /**************************** */
    /*     FUNCIONES PUBLICAS     */
    /**************************** */
    public function traerDetalleDeExpensa($idExpensa){
        return $this->consultarDetalleExpensaPorId($idExpensa);
    }
    public function listarExpensasPorCtaCte($idCtaCte){
        return $this->consultarExpensasPorIDCtaCte($idCtaCte);
    }
    public function liquidarExpensas($idGastoMensual,$cuentasALiquidar,$totalDelMes,$vencimiento)
    {      
        $this->setCuotaMes($this->obtenerNumeroDeCuotaAnual($idGastoMensual));
        $this->setCuotaEstado(1); // Por ahora el 1 sera 'Sin imputar', 2 'Sin vencer', 3'Vencido, 4 'Pago'
        $this->setCuotaVencimiento($vencimiento);
        $this->setIdGastoMensual($idGastoMensual);
        $arrExpensasCalculadas = $this->calcularExpensas($cuentasALiquidar,$totalDelMes);
        foreach($arrExpensasCalculadas as $idCtaCte => $importeExpensa){
            $this->setCuotaExtraordinaria($importeExpensa); // Sera expensa sin contar la mora
            $this->setCuotaMora(0); // Aun falta hacer el calculo de la mora
            $this->setIdCtaCte($idCtaCte);
            $this->setCuotaExpensa($this->cuotaExtraordinaria + $this->cuotaMora);
            
            $this->ingresarExpensaDelMes();
        }
    }
    public function controlarExpensasImpagas($arrCuentasConSaldo)// $arrCuentasConSaldo = array( id => saldo);
    {
        foreach ($arrCuentasConSaldo as $idCtaCte => $saldoCtaCte) {
            $arrExpensasImpagas = $this->consultarExpensasImpagas($idCtaCte);
            $arrExpensasVencidas= array();
            if($saldoCtaCte==0){
                $this->pagarExpensasArray($arrExpensasImpagas);
            }elseif($saldoCtaCte>0){
                $arrExpensasVencidas = $this->filtrarArrayExpensasVencidas($arrExpensasImpagas);
                if(!empty($arrExpensasVencidas)){
                    $this->actualizarEstadoDeExpensas($arrExpensasVencidas,$saldoCtaCte);
                }
            }            
        }
        return true;
    }
    
    /**************************** */
    /*     FUNCIONES PRIVADAS     */
    /**************************** */
    private function consultarExpensasPorIDCtaCte($id_ctacte){
        $this->setIdCtaCte($id_ctacte);
        $this->query = "SELECT e.id_expensa idExpensa, e.cuota_expensa total, e.cuota_mes cuotaAnual, est.descripcion estado"
                        ." FROM ". $this->tabla . " e "
                        ." INNER JOIN expensaestado est on e.cuota_estado = est.id_expensaEstado"
                        ." WHERE e.id_ctacte = ?";
        $arrType = array ("i");
        $arrParam = array($this->id_ctacte);
        return $this->executeQuery($arrType,$arrParam);
    }
    private function consultarDetalleExpensaPorId($idExpensa){
        $this->setIdExpensa($idExpensa);
        $this->query = "SELECT cuota_expensa total, cuota_extraordinaria impteExtraordinaria, cuota_mora mora,"
        ." cuota_mes cuotaAnual, cuota_vencimiento vencimiento, id_gasto_mensual idGastoMensual"
        ." FROM ". $this->tabla
        ." WHERE id_expensa = ?";
        $arrType = array ("i");
        $arrParam = array($this->idExpensa);
        return $this->executeQuery($arrType,$arrParam);
    }
    // $arrExpensas debe tener el formato = array('idExpensa' => idExpensa)
    private function pagarExpensasArray($arrExpensas = array())
    {
        foreach ($arrExpensas as $expensa) {
            $this->expensaPagada($expensa['idExpensa']);
        }
    }
    private function actualizarEstadoDeExpensas($arrExpensas = array(), $saldoCtaCte)
    {
        $totalExpensa = $this->sumarExpensas($arrExpensas);
        $totalPagado = $totalExpensa - $saldoCtaCte;
        $this->actualizarExpensasPagas($arrExpensas, $totalPagado);
    }
    // $arrExpensas debe tener el formato = array('importe' => importe)
    private function sumarExpensas($arrExpensas){
        $totalExpensa=0;
        foreach ($arrExpensas as $expensa) {
            $totalExpensa += $expensa['importe'];
        }
        return $totalExpensa;
    }
    private function actualizarExpensasPagas($arrExpensas = array(), $totalPagado){
        foreach ($arrExpensas as $expensa) {
            if($totalPagado >= $expensa['importe'])
            {
                $this->expensaPagada($expensa['idExpensa']);
                $totalPagado -=  $expensa['importe'];          
            }else
            {
                $this->expensaVencida($expensa['idExpensa']);
            }
        }
    }
    private function filtrarArrayExpensasVencidas($arrExpensas = array())
    {
        $arrExpensasVencidas=array();
        foreach ($arrExpensas as $reg => $expensa) {
            if(!$this->verificarVencimientoExpensa($expensa['fechaVencimiento']))
            {
                $arrExpensasVencidas[$reg] = $expensa;           
            }
        }
        return $arrExpensasVencidas;
    }
    // Verifica que no esté vencida
    private function verificarVencimientoExpensa($fechaVencimiento){
        date_default_timezone_get('America/Argentina/Buenos_Aires');
        $fechaActual = strtotime(date("Y-m-d"));
        $fechaVencimiento = strtotime($fechaVencimiento); 
        if($fechaVencimiento>=$fechaActual)
        {
            return true; // La expensa no esta vencida
        }else{
            return false; // La expensa esta vencida
        }      
        
    }
    private function expensaPagada($idExpensa)
    {
        return $this->cambiarEstadoExpensa($idExpensa,4);
    }
    private function expensaVencida($idExpensa)
    {
        return $this->cambiarEstadoExpensa($idExpensa,3);
    }
    private function cambiarEstadoExpensa($idExpensa,$estado){
        $this->setCuotaEstado($estado);
        $this->query = "UPDATE ".$this->tabla." SET cuota_estado = ? WHERE id_expensa = ?";
        $arrType = array("i","i");
        $arrParam= array(
            $this->cuotaEstado,
            $idExpensa
        );
        return $this->executeQuery($arrType,$arrParam);
    }
    private function consultarExpensasImpagas($id_ctacte)
    {
        $this->setIdCtaCte($id_ctacte);
        $this->query = "SELECT e.id_expensa idExpensa, e.cuota_expensa importe, e.cuota_vencimiento fechaVencimiento"
        ." FROM ". $this->tabla ." e"
        ." WHERE e.id_ctacte = ?"
        ." AND e.cuota_estado != 4";
        $arrType = array ("i");
        $arrParam = array ($this->id_ctacte);
        $expensasImpagas=array();
        $resultado=$this->executeQuery($arrType,$arrParam);
        while ($reg = $resultado->fetch_assoc())
        {
            $expensasImpagas[] = array(
                                        'idExpensa' => $reg['idExpensa'],
                                        'importe' => $reg['importe'],
                                        'fechaVencimiento' => $reg['fechaVencimiento']);
        }
        if(!empty($expensasImpagas)){
            return $expensasImpagas;
        }else {
            return false;
        }
    }
    private function calcularExpensas($arrCtaCtes, $total){
        foreach($arrCtaCtes as $idCtaCte => $prcParticipacion){
            $expPorUnidad[$idCtaCte] = round(($total / 100)*$prcParticipacion,2);
        }
        return $expPorUnidad;
    }
    private function ingresarExpensaDelMes()
    {
        $this->query = "INSERT INTO ".$this->tabla." ( cuota_expensa, cuota_extraordinaria,"
                                ." cuota_mora, cuota_mes, cuota_vencimiento, cuota_estado, id_ctacte,"
                                ." id_gasto_mensual)"
                                ." VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $arrType = array("d","d","d","i","s","s","i","i");
        $arrParam= array(
            $this->cuotaExpensa,
            $this->cuotaExtraordinaria,
            $this->cuotaMora,
            $this->cuotaMes,
            $this->cuotaVencimiento,
            $this->cuotaEstado,
            $this->id_ctacte,
            $this->id_gasto_mensual
        );
        return $this->executeQuery($arrType,$arrParam);
    }
    private function obtenerNumeroDeCuotaAnual($id_gasto_mensual){
        $this->query = "SELECT periodo numero FROM gastomensual"
                       ." WHERE id_gasto_mensual = ?";
        $arrType = array("i");
        $arrParam = array($id_gasto_mensual);
        $periodo = $this->executeQuery($arrType,$arrParam)->fetch_assoc();// '2018 - 06'
        $numeroPeriodo = explode("-",trim($periodo['numero'])); // '06'
        return (int)$numeroPeriodo[1];
    }

    private function setIdExpensa($idExpensa){
        try { $this->idExpensa = $this->validator->validarVariableNumerica($idExpensa);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setCuotaExpensa($cuotaExpensa){
        try { $this->cuotaExpensa = $this->validator->validarVariableNumerica($cuotaExpensa);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setCuotaExtraordinaria($cuotaExtraordinaria){
        try { $this->cuotaExtraordinaria = $this->validator->validarVariableNumerica($cuotaExtraordinaria);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setCuotaMora($cuotaMora){
        $this->cuotaMora = $cuotaMora;
    }
    private function setCuotaMes($cuotaMes){
        try { $this->cuotaMes = $this->validator->validarVariableNumerica($cuotaMes);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setCuotaVencimiento($cuotaVencimiento){
        try { $this->cuotaVencimiento = $this->validator->validarVariableString($cuotaVencimiento);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setCuotaEstado($cuotaEstado){
        try { $this->cuotaEstado = $this->validator->validarVariableNumerica($cuotaEstado);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setIdCtaCte($id_ctacte){
        try { $this->id_ctacte = $this->validator->validarVariableNumerica($id_ctacte);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setIdGastoMensual($id_gasto_mensual){
        try { $this->id_gasto_mensual = $this->validator->validarVariableNumerica($id_gasto_mensual);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    
    
    // Ejemplo: Si en mi query necesito pasarle el valor 14, "Calle Falsa", "432"
    // $arrType = array("i","s","s") /* int string string */
    // $arrParam = array(14,"Calle Falsa","432");
    private function executeQuery($arrType = null, $arrParam = null)
    {   
        try{ $q = new Query($this->connection); }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
        
        return $q->execute(array($this->query),$arrType,$arrParam);
    }
}
?>