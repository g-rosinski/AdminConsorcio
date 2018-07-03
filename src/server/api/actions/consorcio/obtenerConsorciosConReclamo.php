<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
include_once './../../config/db.php';
include_once './../../entities/consorcio.php';

echo obtenerConsorciosConReclamos();

function obtenerConsorciosConReclamos()
{
    $db = new DB();
    $consorcio = new Consorcio($db);
 
    $resultados = $consorcio->listarConsorciosConReclamos();
    $consorcios = array();

    while ($obj = $resultados->fetch_object()) {
        $consorcios[] = $obj;
    }

    return json_encode($consorcios);
}
