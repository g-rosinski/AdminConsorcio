<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo listarEstadoReclamoExistentes();

function listarEstadoReclamoExistentes()
{

    try{
    	$db = new DB();
    	$motivoReclamo = new EstadoReclamo($db);
    }catch(Exception $e){echo "Msj:".$e->getMessage();}
    $data = $_GET;
    $motivosEncontrados = $motivoReclamo->traerEstadosDeReclamo();
    $arrayEstadosReclamo = array();
    while ($obj = $motivosEncontrados->fetch_object()) {
        $arrayEstadosReclamo[] = $obj;
    }
    return json_encode($arrayEstadosReclamo);
}