<?php

require_once './../../utils/autoload.php';
class Barrio
{
    private $connection;
    private $tabla = "barrio";

    private $id_barrio;
    private $id_comuna;
    private $codigo_postal;
    private $descripcion;
    
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

}
?>