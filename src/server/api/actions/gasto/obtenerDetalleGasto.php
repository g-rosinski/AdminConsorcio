<?php
require_once './../../utils/autoload.php';
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

echo obtenerDetalleGasto();

function obtenerDetalleGasto()
{

    try {
        $db = new DB();
        $gasto = new Gasto($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    $data = $_GET;
    $gastosEncontrado = $gasto->traerDetalleGasto($data['id_gasto']);

     return json_encode($gastosEncontrado->fetch_object());
}