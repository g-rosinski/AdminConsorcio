<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo agregarEstadoReclamo();

function agregarEstadoReclamo()
{

    try{
    	$db = new DB();
    	$motivo = new EstadoReclamo($db);
    }catch(Exception $e){echo "Msj:".$e->getMessage();}
    
    $data = $_POST;

    $motivo->agregarEstadoReclamo($data['descripcion']);
    
}

?>