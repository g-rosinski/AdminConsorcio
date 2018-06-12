<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once './../config/db.php';
include_once './../entities/consorcio.php';

echo crearConsorcio();

function crearConsorcio()
{
    $db = new DB();
    $consorcio = new Consorcio($db);
    $data = $_POST;

    $consorcio->crearConsorcio(
        $data['nombre'],
        $data['cuit'],
        $data['calle'],
        $data['altura'],
        $data['superficie'],
        $data['barrio'],
        $data['telefono']
    );
    
    return $consorcio->crearConsorcio();
}