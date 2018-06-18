<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../config/db.php';
include_once './../../entities/unidad.php';

echo traerUnidadesParaInquilinos();

function traerUnidadesParaInquilinos()
{

    $db = new DB();
    $unidad = new Unidad($db);
    $data = $_GET;
    $unidadesEncontradas = $unidad->UnidadesConPropietarioAsignado($data['id_consorcio']);
    $arrayUnidades = array();
    while ($obj = $unidadesEncontradas->fetch_object()) {
        $arrayUnidades[] = $obj;
    }
    return json_encode($arrayUnidades);
}
