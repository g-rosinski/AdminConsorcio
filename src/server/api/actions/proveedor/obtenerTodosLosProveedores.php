<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo obtenerTodosLosProveedores();

function obtenerTodosLosProveedores()
{

    try {
        $db = new DB();
        $proveedor = new Proveedor($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    $data = $_GET;
    $respuesta = $proveedor->obtenerTodosLosProveedores();
    $proveedores = array();

    while ($obj = $respuesta->fetch_object()) {
        $proveedores[] = $obj;
    }

    return json_encode($proveedores);
}
