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
    private $nro_reclamo;
    private $titulo;
    private $mensaje;
    private $fechaCreacion;
    private $fechaMovimiento;
    private $id_unidad;
    private $id_estado_reclamo;


    public function __construct($connection)
    {
        $this->connection = $connection;
        try{ $this->validator = new Validator; }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
    }


    /**************************** */
    /*     FUNCIONES PUBLICAS     */
    /**************************** */
    public function nuevoReclamo($id_unidad,$titulo,$mensaje){
        $this->setIdUnidad($id_unidad);
        $this->setNroReclamo($this->nuevoNumeroDeReclamo());
        $this->setTitulo($titulo);
        $this->setMensaje($mensaje);
        $this->setIdEstadoReclamo($this->getIdEstado('NUEVO'));
        $this->setFechaCreacion($this->setDateTime());
        $this->setFechaMovimiento($this->setDateTime());
        return $this->insertReclamo();
    }
    public function procesarReclamo($id_reclamo){
        return $this->cambiarEstadoReclamo($id_reclamo,$this->getIdEstado('EN CURSO'));
    }
    public function cerrarReclamo($id_reclamo){
        return $this->cambiarEstadoReclamo($id_reclamo,$this->getIdEstado('FINALIZADO'));
    }
    public function cambiarEstadoReclamo($idReclamo,$idEstado){
        $this->setIdReclamo($idReclamo);
        $this->setIdEstadoReclamo($idEstado);
        $this->setFechaMovimiento($this->setDateTime());
        return $this->insertMovimiento();
    }
    public function traerEstadoDeReclamoPorUsuario($user){  
        return $this->consultarEstadoDeReclamoPorUsuario($user);
    }
    public function traerEstadoDeReclamoPorConsorcio($consorcio){ 
        return $this->consultarEstadoDeReclamoPorConsorcio($consorcio);
    }
    /**************************** */
    /*     FUNCIONES PRIVADAS     */
    /**************************** */
    private function insertMovimiento(){
        $this->query = "UPDATE ".$this->tabla." SET id_estado_reclamo = ? , fechaMovimiento = ? WHERE id_reclamo = ?";
        $arrType = array("i","s","i");
        $arrParam= array(
            $this->id_estado_reclamo,
            $this->fechaMovimiento,
            $this->id_reclamo
        );
        return $this->executeQuery($arrType,$arrParam);
    }
    private function insertReclamo(){
        $this->query = "INSERT INTO ".$this->tabla." (nro_reclamo,titulo,mensaje,fechaCreacion,fechaMovimiento,id_unidad, id_estado_reclamo) VALUES( ?,?,?,?,?,?,? )";
        $arrType = array("i","s","s","s","s","s","i");
        $arrParam= array(
            $this->nro_reclamo,
            $this->titulo,
            $this->mensaje,
            $this->fechaCreacion,
            $this->fechaMovimiento,
            $this->id_unidad,
            $this->id_estado_reclamo
        );
        return $this->executeQuery($arrType,$arrParam);
    }
    private function consultarEstadoDeReclamoPorUsuario($user){        
        $this->query = "SELECT r.id_reclamo id, r.nro_reclamo nroReclamo, r.titulo titulo, r.mensaje mensaje, er.descripcion estado, r.fechaMovimiento fecha
                        FROM propietariounidad pu
                        INNER JOIN reclamo r ON r.id_unidad = pu.id_unidad
                        INNER JOIN estadoreclamo er ON r.id_estado_reclamo = er.id_estado_reclamo
                        WHERE pu.user LIKE ?";
        $arrType = array ("s");
        $arrParam = array( $user);
        return $this->executeQuery($arrType,$arrParam);
    }
    public function consultarEstadoDeReclamoPorConsorcio($consorcio){
        $this->query = "SELECT r.id_reclamo id, r.nro_reclamo nroReclamo, r.titulo titulo, r.mensaje mensaje, er.descripcion estado, r.fechaMovimiento fecha, u.piso piso, u.departamento, u.id_consorcio consorcio
                        FROM unidad u
                        INNER JOIN reclamo r ON r.id_unidad = u.id_unidad
                        INNER JOIN estadoreclamo er ON r.id_estado_reclamo = er.id_estado_reclamo
                        WHERE u.id_consorcio = ?";
        $arrType = array ("i");
        $arrParam = array(
            $consorcio            
        );
        
        return $this->executeQuery($arrType,$arrParam);
    }
    
    private function setDateTime(){
        date_default_timezone_get('America/Argentina/Buenos_Aires');
        return date("Y-m-d G:i:s");        
    }
    private function formatearFecha($fecha){
        
    }
    // Por ahora que el numero de Reclamo funcione asi
    private function nuevoNumeroDeReclamo(){
        $this->query = "SELECT MAX(nro_reclamo) as nroReclamo FROM reclamo LIMIT 1";
        $ultReclamo = $this->executeQuery()->fetch_assoc();
        ($ultReclamo['nroReclamo']==null) ? $ultReclamo['nroReclamo']=1 : $ultReclamo['nroReclamo']++; 
        return $ultReclamo['nroReclamo'];
    }
    private function getIdEstado($estadoBuscado){
        $this->query = "SELECT id_estado_reclamo as id FROM estadoreclamo WHERE descripcion like ?";
        $arrType = array("s");
        $arrParam= array($estadoBuscado);
        $estado = $this->executeQuery($arrType,$arrParam)->fetch_assoc();
        return $estado['id'];
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
    private function setFechaCreacion($fecha)
    {
        $this->fechaCreacion=$fecha;
    }
    private function setFechaMovimiento($fecha)
    {
        $this->fechaMovimiento=$fecha;
    }
    private function setIdUnidad($id_unidad)
    {
        try { $this->id_unidad = $this->validator->validarVariableString($id_unidad);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setIdEstadoReclamo($id_estado_reclamo)
    {
        try { $this->id_estado_reclamo = $this->validator->validarVariableNumerica($id_estado_reclamo);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
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
