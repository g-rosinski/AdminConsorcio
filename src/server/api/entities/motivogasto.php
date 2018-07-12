<?php
require_once './../../utils/autoload.php';

class MotivoGasto
{

    private $connection;
    private $validator;
    private $query;
    private $tabla = "motivogasto";

    private $id_motivo_gasto;
    private $descripcion;
    private $id_rubro_gasto;

    public function __construct($connection)
    {
        $this->connection = $connection;
        try { $this->validator = new Validator;} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }

    public function obtenerTodosLosMotivoGasto()
    {
        $this->query = "SELECT id_motivo_gasto,descripcion FROM ". $this->tabla;
        return $this->executeQuery();
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
