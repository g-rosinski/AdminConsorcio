<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once './../../config/db.php';
include_once './../../entities/consorcio.php';

echo json_encode(crearConsorcio());

function crearConsorcio()
{
    $db = new DB();
    $consorcio = new Consorcio($db);
    $data = $_POST;

    return $consorcio->crearConsorcio(
        $data['nombre'],
        $data['cuit'],
        $data['calle'],
        $data['altura'],
        $data['superficie'],
        $data['id_barrio'],
        $data['telefono'],
        $data['coordenadaLatitud'],
        $data['coordenadaLongitud']
    );

}
