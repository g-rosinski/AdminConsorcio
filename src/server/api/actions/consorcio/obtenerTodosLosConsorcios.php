<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once './../../config/db.php';

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
