<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo agregarMotivoReclamo();

function agregarMotivoReclamo()
{

    try{
    	$db = new DB();
    	$motivo = new MotivoReclamo($db);
    }catch(Exception $e){echo "Msj:".$e->getMessage();}
    
    $data = $_POST;

    $motivo->agregarMotivoReclamo($data['descripcion']);
    
}

?>