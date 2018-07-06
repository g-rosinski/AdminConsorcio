<?php
require_once './../../utils/autoload.php';

class Gasto
{
    private $connection;
    private $validator;    
    private $query;
    private $tabla = "gasto";
    /* Campos de la tabla */
    private $id_gasto; //Integer
    private $nro_comprobante; //Integer
    private $fecha; //String
    private $descripcion; //String
    private $importe; //Integer
    private $id_motivo_gasto; //Integer
    private $id_proveedor; //Integer
    private $id_gasto_mensual; //Integer
    private $id_reclamo; //Integer
    private $id_operador; //String

    public function __construct($connection)
    {
        $this->connection = $connection;
        try{ $this->validator = new Validator; }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
    }


    /**************************** */
    /*     FUNCIONES PUBLICAS     */
    /**************************** */
    public function procesarGasto($descripcion, $importe, $id_motivo_gasto, $id_proveedor, $id_gasto_mensual, $id_reclamo, $id_operador){
        $this->setNroComprobante($this->nuevoNumeroDeComprobante());
        $this->setFecha($this->setDate());
        $this->setDescripcion($descripcion);
        $this->setImporte($importe);
        $this->setIdMotivoGasto($id_motivo_gasto);
        $this->setIdProveedor($id_proveedor);
        $this->setIdGastoMensual($id_gasto_mensual);
        $this->setIdReclamo($id_reclamo);
        $this->setIdOperador($id_operador);

        return $this->insertGasto();
    }

    public function traerGastosPorUnConsorcio($consorcio){
        return $this->consultarGastosPorConsorcio($consorcio);
    }

    /**************************** */
    /*     FUNCIONES PRIVADAS     */
    /**************************** */
    private function consultarGastosPorConsorcio($consorcio){
        $this->query = "SELECT g.id_gasto idGasto, g.nro_comprobante nroComprobante, g.fecha, g.descripcion, g.importe FROM ".$this->tabla." as g
                        INNER JOIN gastomensual gm on gm.id_gasto_mensual = g.id_gasto_mensual
                        WHERE gm.id_consorcio = ?";
        $arrType = array ("i");
        $arrParam = array($consorcio);
        return $this->executeQuery($arrType,$arrParam);
    }
    private function insertGasto(){
        $this->query = "INSERT INTO ".$this->tabla." (nro_comprobante, fecha, descripcion, importe, id_motivo_gasto, id_proveedor, id_gasto_mensual, id_reclamo, id_operador) VALUES( ?,?,?,?,?,?,?,?,? )";
        $arrType = array("i","s","s","i","i","i","i","i","s");
        $arrParam= array(
            $this->nro_comprobante,
            $this->fecha,
            $this->descripcion,
            $this->importe,
            $this->id_motivo_gasto,
            $this->id_proveedor,
            $this->id_gasto_mensual,
            $this->id_reclamo,
            $this->id_operador
        );
        return $this->executeQuery($arrType,$arrParam);
    }

    private function nuevoNumeroDeComprobante(){
        $this->query = "SELECT MAX(nro_comprobante) as nroComprobante FROM ".$this->tabla." LIMIT 1";
        $ultGasto = $this->executeQuery()->fetch_assoc();
        ($ultGasto['nroComprobante']==null) ? $ultGasto['nroComprobante']=1 : $ultGasto['nroComprobante']++; 
        return $ultGasto['nroComprobante'];
    }
    private function setDate(){
        date_default_timezone_get('America/Argentina/Buenos_Aires');
        return date("Y-m-d");        
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
