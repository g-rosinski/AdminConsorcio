<?php
require_once 'conexion.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

echo json_encode(obtenerTodosLosConsorcios());

function obtenerTodosLosConsorcios()
{
    $consorcios = array();
    $query = "SELECT * FROM consorcio";
    $resultados = ejecutarSQL($query);

    while ($obj = mysqli_fetch_object($resultados)) {
        $consorcios[] = $obj;
    }

    return $consorcios;
}
