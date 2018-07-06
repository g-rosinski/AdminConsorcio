<?php
require_once './../../utils/autoload.php';

class PagoGasto {

	private $connection;
    private $validator;    
    private $query;
    private $tabla = "gasto";
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
}
?>