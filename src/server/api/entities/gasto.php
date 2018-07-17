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
        try{
            $this->setNroComprobante($this->nuevoNumeroDeComprobante());
            $this->setFecha($this->setDate());
            $this->setDescripcion($descripcion);
            $this->setImporte($importe);
            $this->setIdMotivoGasto($id_motivo_gasto);
            $this->setIdProveedor($id_proveedor);
            $this->setIdGastoMensual($id_gasto_mensual);
            $this->setIdReclamo($id_reclamo);
            $this->setIdOperador($id_operador);
            $this->insertGasto();
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
        return true;
    }
    public function listarGastosPorIdGastoMensual($idGastoMensual){        
        $gastosEncontrados = $this->traerReporteDeGastosPorMes($idGastoMensual);
        $listadoDeGatosFormateados = $this->formatearGastosPorMesParaPDF($gastosEncontrados);
        return $listadoDeGatosFormateados;
    }
    public function traerGastosPorUnConsorcio($consorcio, $idGastoMensualActual){
        $this->setIdGastoMensual($idGastoMensualActual);
        return $this->consultarGastosPorConsorcio($consorcio);
    }
    public function traerGastosHistoricosPorUnMes($idGastoMensual){
        return $this->consultarGastosHistoricosPorMes($idGastoMensual);  
    }
    public function traerDetalleGasto($idGasto){
        $this->setIdGasto($idGasto);
        return $this->consultarGasto();
    }
    public function traerIdGastoMensual($id_gasto){
        $this->setIdGasto($id_gasto);
        return $this->obtenerIdGastoMensual();
    }
    /**************************** */
    /*     FUNCIONES PRIVADAS     */
    /**************************** */
    private function formatearGastosPorMesParaPDF($detalleGastos)
    {
        $listaDeRubros  = array();  
        $listaDeMotivos = array();  
        $listaDeGastos = array(); 
        while ($registro = $detalleGastos->fetch_assoc()) { 
            $listaDeRubros = $this->armarListadoDeRubros($listaDeRubros,$registro);
            $listaDeMotivos = $this->armarListaDeMotivosConTotales($listaDeMotivos,$registro);
            $listaDeGastos = $this->armarListaDeGastosAgrupadoPorMotivo($listaDeGastos,$registro);
        }       
          
        $listasDeGastosPorMotivo = $this->asignarAlMotivoDeGastoCorrespondiente($listaDeMotivos,$listaDeGastos);
        $listadoFormateadoPorRubro = $this->asignarAlRubroCorrespondiente($listaDeRubros, $listasDeGastosPorMotivo);            
        return $gastosFormateados['rubros'] = $listadoFormateadoPorRubro ;
    }
    private function armarListadoDeRubros($listaExistente = array(),$gastoConRubroAsignado)
    {
        $listaExistente[$gastoConRubroAsignado['rubro']][]=$gastoConRubroAsignado['motivo'];
        return $listaExistente;
    }
    private function armarListaDeMotivosConTotales($listaDeMotivos=array(), $registro)
    {
        if(empty($listaDeMotivos[$registro['motivo']])){
                $listaDeMotivos[$registro['motivo']] = $registro['importe'];
            }else{
                $listaDeMotivos[$registro['motivo']] = $listaDeMotivos[$registro['motivo']] + $registro['importe'];
            }
        return $listaDeMotivos;
    }
    private function armarListaDeGastosAgrupadoPorMotivo($listaDeGastos,$registro)
    {
        $listaDeGastos[$registro['motivo']][] = Array(
                                                    'proveedor'=> $registro['razon_social'],
                                                    'importe' => $registro['importe'],
                                                    'descripcion' => $registro['detalle']
            );
        return $listaDeGastos;
    }
    private function asignarAlMotivoDeGastoCorrespondiente($listaDeMotivos,$listaDeGastos)
    {
      foreach ($listaDeGastos as $motivo => $arrayGastos) {
            $listasDeGastosPorMotivo[] = Array(
                'motivo' => $motivo,
                'totalGasto' => $listaDeMotivos[$motivo],
                'detalle' => $arrayGastos
            );
        }
        return $listasDeGastosPorMotivo;  
    }
    private function asignarAlRubroCorrespondiente($listaDeRubros, $arrGastosPorMotivo)
    {
        foreach ($arrGastosPorMotivo as $datosMotivo) {
            foreach ($listaDeRubros as $rubro => $listaMotivos) {
                foreach($listaMotivos as $motivo){
                    if($motivo==$datosMotivo['motivo']){
                        $listaDeRubrosCompletos[$rubro][]=$datosMotivo;
                    }
                }
                
            }            
        }
        return $listaDeRubrosCompletos;
    }
    private function traerReporteDeGastosPorMes($idGastoMensual)
    {
        $this->setIdGastoMensual($idGastoMensual);
        $this->query = "SELECT rg.descripcion rubro, mg.descripcion motivo, p.razon_social, g.importe, g.descripcion detalle"
                        ." FROM ".$this->tabla. " g "
                        ." INNER JOIN motivogasto mg on g.id_motivo_gasto = mg.id_motivo_gasto"
                        ." INNER JOIN rubrogasto rg on mg.id_rubro_gasto = rg.id_rubro_gasto"
                        ." INNER JOIN proveedor p on g.id_proveedor = p.id_proveedor"
                        ." WHERE g.id_gasto_mensual = ?";
        $arrType = array ("i");
        $arrParam = array($this->id_gasto_mensual);
        return $this->executeQuery($arrType,$arrParam);
    }
    private function consultarGasto()
    {
        $this->query = "SELECT id_gasto idGasto, nro_comprobante nroComprobante, fecha, descripcion, importe,"
                        ."  id_motivo_gasto idMotivoGasto, id_proveedor idProveedor, id_gasto_mensual idGastoMensual,"
                        ."  id_reclamo idReclamo, id_operador idOperador"
                        ." FROM ".$this->tabla
                        ." WHERE id_gasto = ?";
        $arrType = array ("i");
        $arrParam = array($this->id_gasto);
        return $this->executeQuery($arrType,$arrParam);
    }
    private function consultarGastosPorConsorcio($consorcio)
    {
        $this->query = "SELECT g.id_gasto idGasto, g.nro_comprobante nroComprobante, g.fecha, g.descripcion, g.importe FROM ".$this->tabla." as g"
                        ." INNER JOIN gastomensual gm on gm.id_gasto_mensual = g.id_gasto_mensual"
                        ." WHERE gm.id_consorcio = ?"
                        ." AND g.id_gasto_mensual = ?";
        $arrType = array ("i","i");
        $arrParam = array($consorcio, $this->id_gasto_mensual);
        return $this->executeQuery($arrType,$arrParam);
    }
    private function consultarGastosHistoricosPorMes($idGastoMensual)
    {
        $this->query = "SELECT nro_comprobante nroGasto, mg.descripcion motivo, p.razon_social proveedor, g.importe, g.descripcion titulo, pg.nro_orden_pago nroPago"
                        ." FROM ".$this->tabla." as g"
                        ." INNER JOIN proveedor p on g.id_proveedor = p.id_proveedor"
                        ." INNER JOIN pagogasto pg on g.id_gasto = pg.id_gasto"
                        ." INNER JOIN motivogasto mg on g.id_motivo_gasto = mg.id_motivo_gasto"
                        ." WHERE g.id_gasto_mensual = ?";
        $arrType = array ("i");
        $arrParam = array($idGastoMensual);
        return $this->executeQuery($arrType,$arrParam);
    }
    private function insertGasto()
    {
        $this->query = "INSERT INTO ".$this->tabla." (nro_comprobante, fecha, descripcion, importe, id_motivo_gasto, id_proveedor, id_gasto_mensual, id_reclamo, id_operador) VALUES( ?,?,?,?,?,?,?,?,? )";
        $arrType = array("i","s","s","d","i","i","i","i","s");
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
    private function obtenerIdGastoMensual()
    {
        $this->query = "SELECT id_gasto_mensual id FROM ".$this->tabla.
                       " WHERE id_gasto = ?";
        $arrType = array ("i");
        $arrParam = array ($this->id_gasto);
        $gastomensual = $this->executeQuery($arrType,$arrParam)->fetch_assoc();
        return $gastomensual['id'];
    }
    
    private function nuevoNumeroDeComprobante()
    {
        $this->query = "SELECT MAX(nro_comprobante) as nroComprobante FROM ".$this->tabla." LIMIT 1";
        
        $ultGasto = $this->executeQuery()->fetch_assoc();
        ($ultGasto['nroComprobante']==null) ? $ultGasto['nroComprobante']=1 : $ultGasto['nroComprobante']++; 
        return $ultGasto['nroComprobante'];
    }
    private function setDate()
    {
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
        try { $this->importe = round($this->validator->validarVariableNumerica($importe),3);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
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
