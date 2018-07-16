<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo verEstadoDeReclamosPorUsuario();

function verEstadoDeReclamosPorUsuario()
{

    try {
        $db = new DB();
        $expensa = new Expensa($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    $data = $_GET;
    $detalleExpensa = $expensa->traerDetalleDeExpensa($data['idExpensa']);
    $arrayExpensa = array();
    while ($obj = $detalleExpensa->fetch_object()) {
        $arrayExpensa[] = $obj;
    }
    return json_encode($arrayExpensa);
}
