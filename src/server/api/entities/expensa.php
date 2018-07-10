<?php

require_once './../../utils/autoload.php';
class Expensa
{
    private $connection;
    private $validator;    
    private $query;
    private $tabla = "expensa";
    /* Campos de la tabla */
    private $idExpensa; // $this->setIdExpensa($idExpensa)
    private $cuotaExpensa; // $this->setCuotaExpensa($cuotaExpensa)
    private $cuotaExtraordinaria; // $this->setCuotaExtraordinaria($cuotaExtraordinaria)
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
    public function liquidarExpensas($idGastoMensual,$cuentasALiquidar,$totalDelMes,$vencimiento)
    {
        $this->setCuotaExtraordinaria(0); // Sera expensa sin contar la mora
        $this->setCuotaMora(0); // Aun falta hacer el calculo de la mora
        $this->setCuotaMes($this->obtenerNumeroDeCuotaAnual($idGastoMensual));
        $this->setCuotaEstado(1); // Por ahora el 1 sera 'Sin imputar', 2 'Sin vencer', 3'Vencido, 4 'Pago'
        $this->setCuotaVencimiento($cuotaVencimiento);
        $this->setIdGastoMensual($idGastoMensual);
        $arrExpensasCalculadas = $this->calcularExpensas($cuentasALiquidar,$totalDelMes);
        foreach($arrExpensasCalculadas as $idCtaCte => $importeExpensa){
            $this->setIdCtaCte($id_ctacte);
            $this->setCuotaExpensa($cuotaExpensa);
        }
    }

    /**************************** */
    /*     FUNCIONES PRIVADAS     */
    /**************************** */
    private function calcularExpensas($arrCtaCtes, $total){
        foreach($arrCtaCtes as $idCtaCte => $prcParticipacion){
            $expPorUnidad[$idCtaCte] = ($total / 100)*$prcParticipacion;
        }
        return $expPorUnidad;
    }
    private function ingresarNuevasExpensas(){
        $this->query = "INSERT INTO ".$this->tabla." ( cuota_expensa, cuota_extraordinaria,"
                        ." cuota_mora, cuota_mes, cuota_vencimiento, cuota_estado, id_ctacte,"
                        ." id_gasto_mensual)"
                        ." VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $arrType = array("i","i","i","i","s","s","i","i");
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
        $this->query = "SELECT periodo numero FROM ".$this->tabla
                       ." WHERE id_gasto_mensual = ?";
        $arrType = array ("i");
        $arrParam = array ($id_gasto_mensual);
        $periodo = $this->executeQuery($arrType,$arrParam)->fetch_assoc();
        $numeroPeriodo = explode("-",trim($periodo['numero'])); // '2018 - 06'
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
        try { $this->cuotaMora = $this->validator->validarVariableNumerica($cuotaMora);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setCuotaMes($cuotaMes){
        try { $this->cuotaMes = $this->validator->validarVariableNumerica($cuotaMes);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setCuotaVencimiento($cuotaVencimiento){
        $this->cuotaVencimiento=$cuotaVencimiento;
    }
    private function setCuotaEstado($cuotaEstado){
        try { $this->cuotaEstado = $this->validator->validarVariableString($cuotaEstado);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setIdCtaCte($id_ctacte){
        try { $this->id_ctacte = $this->validator->validarVariableNumerica($total);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
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