<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo consultarMotivoReclamo();

function consultarMotivoReclamo()
{

    try{
    	$db = new DB();
    	$motivoReclamo = new MotivoReclamo($db);
    }catch(Exception $e){echo "Msj:".$e->getMessage();}
    $data = $_GET;
    $motivosEncontrados = $motivoReclamo->traerMotivosDeReclamo();
    $arrayMotivosReclamo = array();
    while ($obj = $motivosEncontrados->fetch_object()) {
        $arrayMotivosReclamo[] = $obj;
    }
    return json_encode($arrayMotivosReclamo);
}