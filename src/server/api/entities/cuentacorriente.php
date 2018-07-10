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
        $this->setIdCtaCte($unidad);
        return $this->obtenerCtaCte();
    }

    /**************************** */
    /*     FUNCIONES PRIVADAS     */
    /**************************** */
    private function obtenerCtaCte(){
        $this->query = "SELECT id_cta_cte id FROM ". $this->tabla
                       ." WHERE id_unidad = ?";
        $arrType = array ("i");
        $arrParam = array ($this->id_unidad);
        $ctacte = $this->executeQuery($arrType,$arrParam)->fetch_assoc();
        return $ctacte['id'];
    }
    private function setIdCtaCte($id_ctacte){
        try { $this->id_ctacte = $this->validator->validarVariableNumerica($id_ctacte);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setSaldo($saldo){
        try { $this->saldo = $this->validator->validarVariableNumerica($saldo);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setSaldoAFavor($saldo_favor){
        try { $this->saldo_favor = $this->validator->validarVariableNumerica($saldo_favor);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
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
