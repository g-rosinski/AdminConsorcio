<?php
require_once 'conexion.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

echo json_encode(obtenerTodosLosUsuariosInactivos());

// TODO: Esta funcion no me devuelve el nombre, apellido, etc, NI SIQUIERA EL CONSORCIO!!!
function obtenerTodosLosUsuariosInactivos()
{
    $usuarios = array();
    $query = "SELECT * FROM usuario WHERE (estado) = ('INACTIVO')";
    $resultados = ejecutarSQL($query);

    while ($obj = mysqli_fetch_object($resultados)) {
        $usuarios[] = $obj;
    }

    return $usuarios;
}
