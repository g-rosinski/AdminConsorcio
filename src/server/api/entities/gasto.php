<?php
require_once './../../utils/autoload.php';

class Gasto
{
    private $connection;
    private $validator;    
    private $query;
    private $tabla = "gasto";
    /* Campos de la tabla */
    private $id_gasto;
    private $nro_comprobante;
    private $fecha;
    private $descripcion;
    private $importe;
    private $id_motivo_gasto;
    private $id_proveedor;
    private $id_gasto_mensual;
    private $id_reclamo;
    private $id_operador;

    public function __construct($connection)
    {
        $this->connection = $connection;
        try{ $this->validator = new Validator; }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
    }


    /**************************** */
    /*     FUNCIONES PUBLICAS     */
    /**************************** */
    public function procesarGasto($id_reclamo, $descripcion, $id_operador){

    }

    /**************************** */
    /*     FUNCIONES PRIVADAS     */
    /**************************** */
    private function obtenerGastoMensualEnCurso()
    private function 
    private function setDateTime(){
        date_default_timezone_get('America/Argentina/Buenos_Aires');
        return date("Y-m-d G:i:s");        
    }
    private function setIdGasto($id_gasto)
    {
        try { $this->id_gasto = $this->validator->validarVariableNumerica($id_gasto);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    }
    private function setNroComprobante($nro_comprobante)
    {
        try { $this->nro_comprobante = $this->validator->validarVariableNumerica($nro_comprobante);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    } 
    private function setFecha($fecha)
    {
        $this->fecha=$fecha;
    }
    private function setDescripcion($descripcion)
    {
        try { $this->descripcion = $this->validator->validarVariableString($descripcion);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setImporte($importe)
    {
        try { $this->importe = $this->validator->validarVariableNumerica($importe);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }    
    private function setIdMotivoGasto($id_motivo_gasto)
    {
        try { $this->id_motivo_gasto = $this->validator->validarVariableString($id_motivo_gasto);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setIdProveedor($id_proveedor)
    {
        try { $this->id_proveedor = $this->validator->validarVariableNumerica($id_proveedor);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setIdGastoMensual($id_gasto_mensual)
    {
        try { $this->id_gasto_mensual = $this->validator->validarVariableNumerica($id_gasto_mensual);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setIdReclamo($id_reclamo)
    {
        try { $this->id_reclamo = $this->validator->validarVariableNumerica($id_reclamo);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setIdOperador($id_operador)
    {
        try { $this->id_operador = $this->validator->validarVariableString($id_operador);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
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
