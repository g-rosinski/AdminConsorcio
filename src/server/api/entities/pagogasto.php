<?php
require_once './../../utils/autoload.php';

class PagoGasto {

	private $connection;
    private $validator;    
    private $query;
    private $tabla = "pagogasto";
    /* Campos de la tabla */
    private $id_pago_gasto;
    private $nro_orden_pago;
    private $id_gasto;

    public function __construct($connection)
    {
        $this->connection = $connection;
        try{ $this->validator = new Validator; }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
    }
    /**************************** */
    /*     FUNCIONES PUBLICAS     */
    /**************************** */
    public function procesarPagoGasto($nro_orden_pago, $id_gasto)
    {
        $this->setNroOrdenPago($nro_orden_pago);
        $this->setIdGasto($id_gasto);
        return $this->insertGasto();
    }

    /**************************** */
    /*     FUNCIONES PRIVADAS     */
    /**************************** */
    private function insertGasto(){
        $this->query = "INSERT INTO ". $this->tabla . " (nro_orden_pago, id_gasto)"
                        ." VALUES( ?,? )";
        $arrType = array ("i","i");
        $arrParam = array(
                    $this->nro_orden_pago,
                    $this->id_gasto
                );
        return $this->executeQuery($arrType,$arrParam);                
    }

    private function setIdPagoGasto($id_pago_gasto)
    {
        try { $this->id_pago_gasto = $this->validator->validarVariableNumerica($id_pago_gasto);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    } 
    private function setNroOrdenPago($nro_orden_pago)
    {
        try { $this->nro_orden_pago = $this->validator->validarVariableNumerica($nro_orden_pago);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setIdGasto($id_gasto)
    {
        try { $this->id_gasto = $this->validator->validarVariableNumerica($id_gasto);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}

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