<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo verEstadoDeReclamosPorUsuario();

function verEstadoDeReclamosPorUsuario()
{

    try {
        $db = new DB();
        $reclamo = new Reclamo($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    $data = $_GET;
    $reclamoEncontrados = $reclamo->traerEstadoDeReclamoPorUsuario($data['user']);
    $arrayReclamo = array();
    while ($obj = $reclamoEncontrados->fetch_object()) {
        $arrayReclamo[] = $obj;
    }
    return json_encode($arrayReclamo);
}
