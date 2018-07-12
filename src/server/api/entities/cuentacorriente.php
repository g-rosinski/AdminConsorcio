<?php
require_once './../../utils/autoload.php';

class Cuentacorriente
{
    private $connection;
    private $validator;    
    private $query;
    private $tabla = "cuentacorriente";
    /* Campos de la tabla */
    private $id_ctacte; // $this->setIdCtaCte($id_ctacte)
    private $saldo; // $this->setSaldo($saldo)
    private $saldo_favor; // $this->setSaldoAFavor($saldo_favor)
    private $id_unidad; // $this->setIdUnidad($id_unidad)

    public function __construct($connection)
    {
        $this->connection = $connection;
        try{ $this->validator = new Validator; }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
    }

    /**************************** */
    /*     FUNCIONES PUBLICAS     */
    /**************************** */
    public function traerCtaCtePorUnidad($unidad){
        $this->setIdUnidad($unidad);
        return $this->obtenerCtaCte();
    }
    public function actualizarSaldoCtacte($cuentas = array()){
        foreach($cuentas as $idCtaCte => $participacion){
            $this->setIdCtaCte($idCtaCte);
            //saldoActualizado obtiene el valor del saldo actual de la ctacte + expensas que aun no impactaron en la ctacte (expensas nuevas)
            $saldoActualizado = $this->obtenerSaldo() + $this->consultarExpensasSinImputar(); 
            $saldoAFavor = $this->consultarSaldoAFavorDisponible();
            if($saldoAFavor >0)
            {
                $saldoActualizado = $saldoActualizado - $saldoAFavor;
                $this->descontarSaldoAFavor($saldoAFavor);
            } 
            $this->setSaldo($saldoActualizado);
            $this->cargarSaldoActualizadoCtaCte();
        }
    }
    
    /**************************** */
    /*     FUNCIONES PRIVADAS     */
    /**************************** */
    private function obtenerCtaCte(){
        $this->query = "SELECT id_ctacte id FROM ". $this->tabla
        ." WHERE id_unidad = ?";
        $arrType = array("i");
        $arrParam = array($this->id_unidad);
        $ctacte = $this->executeQuery($arrType,$arrParam)->fetch_assoc();
        return $ctacte['id'];
    }
    private function obtenerSaldo(){
        $this->query = "SELECT saldo FROM ". $this->tabla
                       ." WHERE id_ctacte = ?";
        $arrType = array ("i");
        $arrParam = array ($this->id_ctacte);
        $saldo = $this->executeQuery($arrType,$arrParam)->fetch_assoc();
        return $saldo['saldo'];
    }
    private function consultarSaldoAFavorDisponible(){
        $this->query = "SELECT saldo_favor saldo FROM ". $this->tabla
        ." WHERE id_ctacte = ?";
        $arrType = array ("i");
        $arrParam = array ($this->id_ctacte);
        $saldoAFavor = $this->executeQuery($arrType,$arrParam)->fetch_assoc();
        return $saldoAFavor['saldo'];
    }
    private function descontarSaldoAFavor($saldoADescontar){
        $nuevoSaldoAFavor = round($this->obtenerSaldoAFavor()-$saldoADescontar,3);
        $this->query = "UPDATE ".$this->tabla." SET saldo_favor = ? WHERE id_ctacte = ?";
        $arrType = array("d","i");
        $arrParam= array(
            $nuevoSaldoAFavor,
            $this->id_ctacte
        );
        return $this->executeQuery($arrType,$arrParam);
    }
    private function consultarExpensasSinImputar(){
        $this->query = "SELECT e.id_expensa idExpensa, e.cuota_expensa importe FROM ". $this->tabla ." cc"
        ." INNER JOIN expensa e ON cc.id_ctacte = e.id_ctacte"
        ." WHERE e.id_ctacte = ?"
        ." AND e.cuota_estado = '1'";
        $arrType = array ("i");
        $arrParam = array ($this->id_ctacte);
        $saldoASumar=0;
        $res=$this->executeQuery($arrType,$arrParam);
        while ($expensasSinImputar = $res->fetch_assoc())
        {
            $saldoASumar += $expensasSinImputar['importe'];
            $this->actualizarEstadoExpensa($expensasSinImputar['idExpensa'],'2');
        }
        return $saldoASumar;
    }
    private function actualizarEstadoExpensa($idExpensa, $estado){
        $this->query = "UPDATE expensa SET cuota_estado = ?  WHERE id_expensa = ?";
        $arrType = array("i","s");
        $arrParam= array(
            $estado,
            $idExpensa
        );
        return $this->executeQuery($arrType,$arrParam);
    }
    private function cargarSaldoActualizadoCtaCte(){
        $this->query = "UPDATE ".$this->tabla." SET saldo = ? WHERE id_ctacte = ?";
        $arrType = array("d","i");
        $arrParam= array(
            $this->saldo,
            $this->id_ctacte
        );
        return $this->executeQuery($arrType,$arrParam);
    }
    private function setIdCtaCte($id_ctacte){
        try { $this->id_ctacte = $this->validator->validarVariableNumerica($id_ctacte);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setSaldo($saldo){
        try { $this->saldo = round($this->validator->validarVariableNumerica($saldo),3);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setSaldoAFavor($saldo_favor){
        try { $this->saldo_favor = round($this->validator->validarVariableNumerica($saldo_favor),3);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setIdUnidad($id_unidad){
        try { $this->id_unidad = $this->validator->validarVariableNumerica($id_unidad);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
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
