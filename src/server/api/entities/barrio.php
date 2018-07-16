<?php

require_once './../../utils/autoload.php';
class Barrio
{
    private $connection;
    private $validator;
    private $query;
    private $tabla = "barrio";

    private $id_barrio;
    private $id_comuna;
    private $codigo_postal;
    private $descripcion;

    public function __construct($connection)
    {
        $this->connection = $connection;
        try { $this->validator = new Validator;} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }

    public function traerTodosLosBarrios()
    {
        $this->query = "SELECT * FROM $this->tabla";
        
        $arrType = array("i");
        return $this->executeQuery($arrType);
    }

    private function executeQuery($arrType = null, $arrParam = null)
    {
        try { $q = new Query($this->connection);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}

        return $q->execute(array($this->query), $arrType, $arrParam);
    }
}
