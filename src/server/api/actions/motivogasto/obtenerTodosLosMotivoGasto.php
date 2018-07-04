<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo obtenerTodosLosMotivoGasto();

function obtenerTodosLosMotivoGasto()
{
    $db = new DB();
    $motivoGasto = new MotivoGasto($db);
 
    $resultados = $motivoGasto->obtenerTodosLosMotivoGasto();
    $motivos = array();


    while ($obj = $resultados->fetch_object()) {
        $motivos[] = $obj;
    }
    return json_encode($motivos);
}
