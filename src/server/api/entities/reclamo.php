<?php

require_once './../../utils/autoload.php';
class Reclamo
{
    private $connection;
    private $validator;    
    private $query;
    private $tabla = "reclamo";
    /* Campos de la tabla */
    private $id_reclamo;
    private $nro_reclamo = 1;
    private $titulo;
    private $mensaje;
    private $fecha;
    private $hora;
    private $id_propietario;
    private $id_motivo_reclamo;


    public function __construct($connection)
    {
        $this->connection = $connection;
        try{ $this->validator = new Validator; }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
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
    
    public function nuevoReclamo($id_propietario,$titulo,$mensaje, $motivo=1){
        $this->setIdPropietario($id_propietario);
        $this->setNroReclamo($this->nuevoNumeroDeReclamo());
        $this->setTitulo($titulo);
        $this->setMensaje($mensaje);
        $this->setIdMotivoReclamo($motivo);
        $this->setDateTime();
        return $this->insertReclamo();
    }
    public function traerReclamos($consorcio){    }
    public function consultarEstadoDeReclamo($consorcio){    }
   
    private function insertReclamo(){
        $this->query = "INSERT INTO ".$this->tabla. "(nro_reclamo,titulo,mensaje,fecha,hora,user, id_motivo_reclamo) VALUES( ?,?,?,?,?,?,? )";
        $arrType = array("i","s","s","s","s","s","i");
        $arrParam= array(
            $this->nro_reclamo,
            $this->titulo,
            $this->mensaje,
            $this->fecha,
            $this->hora,
            $this->id_propietario,
            $this->id_motivo_reclamo
        );
        return $this->executeQuery($arrType,$arrParam);
    }
/*     private function consultarUnidadesOcupadasPorConsorcio(){
        $this->query =     "SELECT p.id_unidad 
                            FROM propietariounidad p
                            INNER JOIN unidad u on p.id_unidad = u.id_unidad 
                            WHERE  p.inquilino_de IS NOT NULL
                            AND u.id_consorcio = ?";
        $arrType = array ("i");
        $arrParam = array(
            $this->id_consorcio
        );
        return $this->executeQuery($arrType,$arrParam);
    } */
    
    private function setDateTime(){
        date_default_timezone_get('America/Argentina/Buenos_Aires');
        $this->setFecha(date("Y-m-d"));
        $this->setHora(date("Y-m-d G:i:s"));
    }
    // Por ahora que el numero de Reclamo funcione asi
    private function nuevoNumeroDeReclamo(){
        $this->query = "select MAX(nro_reclamo) nroReclamo from reclamo LIMIT 1";
        $ultReclamo = $this->executeQuery()->fetch_assoc();
        return ++$ultReclamo['nroReclamo'];
    }
    private function setIdReclamo($id_reclamo)
    {
        try { $this->id_reclamo = $this->validator->validarVariableNumerica($id_reclamo);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setNroReclamo($nro_reclamo)
    {
        try { $this->nro_reclamo = $this->validator->validarVariableNumerica($nro_reclamo);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    } 
    private function setTitulo($titulo)
    {
        try { $this->titulo = $this->validator->validarVariableString($titulo);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setMensaje($mensaje)
    {
        try { $this->mensaje = $this->validator->validarVariableString($mensaje);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setFecha($fecha)
    {
        $this->fecha=$fecha;
    }
    private function setHora($hora)
    {
        $this->hora=$hora;
    }
    private function setIdPropietario($id_propietario)
    {
        try { $this->id_propietario = $this->validator->validarVariableString($id_propietario);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setIdMotivoReclamo($id_motivo_reclamo)
    {
        try { $this->id_motivo_reclamo = $this->validator->validarVariableNumerica($id_motivo_reclamo);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    

}
