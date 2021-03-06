<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo json_encode(agregarReclamo());

function agregarReclamo()
{

    try {
        $db = new DB();
        $reclamo = new Reclamo($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    $data = $_POST;

    return $reclamo->nuevoReclamo(
        $data['id_unidad'],
        $data['titulo'],
        $data['mensaje']
    );

}
