<?php
include_once './../../config/db.php';
include_once './../../entities/consorcio.php';
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

echo obtenerConsorciosConGastos();

function obtenerConsorciosConGastos()
{
    $db = new DB();
    $consorcio = new Consorcio($db);

    $resultados = $consorcio->listarConsorciosConGastos();
    $consorcios = array();

    while ($obj = $resultados->fetch_object()) {
        $consorcios[] = $obj;
    }

    return json_encode($consorcios);
}
