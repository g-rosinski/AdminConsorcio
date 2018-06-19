<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';
include_once './../../entities/unidad.php';

echo agregarUnidad();

function agregarUnidad()
{

    try{$db = new DB();}catch(Exception $e){echo "Msj:".$e->getMessage();}
    $unidad = new Unidad($db);
    $data = $_POST;

    $unidad->agregarRelacionPersonaUnidad($data['user'], $data['rol'], $data['unit']);
    
}

?>