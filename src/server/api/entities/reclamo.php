<?php
class Reclamo
{
	private $connection;
    private $query;
    private $validator;
	private $tabla = "reclamo";
    /* Campos de la tabla */
    public $id_reclamo;
    public $nro_reclamo;
    public $titulo;
    public $mensaje;
    public $fecha;
    public $hora;
    public $id_propietario;
    public $id_motivo_reclamo;

    public function __construct($connection)
    {
        $this->connection = $connection;
        try{ $this->validator = new Validator; }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
    }


    // $arrType = array("i","s","s") /* int string string */
    // $arrParam = array(14,"Calle Falsa","432");
    private function executeQuery($arrType = null, $arrParam = null)
    {   
        try{ $q = new Query($this->connection); }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
        
        return $q->execute(array($this->query),$arrType,$arrParam);
    }

	private function setIdReclamo($id_motivo_reclamo)
    {
        try { $this->id_motivo_reclamo = $this->validator->validarVariableNumerica($id_motivo_reclamo);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
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
        try { $this->fecha = $this->validator->validarVariableString($fecha);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setHora($hora)
    {
        try { $this->hora = $this->validator->validarVariableString($hora);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setIdPropietario($id_propietario)
    {
        try { $this->id_propietario = $this->validator->validarVariableNumerica($id_propietario);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setIdMotivoReclamo($id_motivo_reclamo)
    {
        try { $this->id_motivo_reclamo = $this->validator->validarVariableNumerica($id_motivo_reclamo);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }

}
