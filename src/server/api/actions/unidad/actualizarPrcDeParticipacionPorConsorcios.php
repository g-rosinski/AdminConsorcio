<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo json_encode(actualizarPrcDeParticipacionPorConsorcios());

function actualizarPrcDeParticipacionPorConsorcios()
{

    try {
        $db = new DB();
        $unidad = new Unidad($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    $data = $_POST;

    $unidad->calcularPrcParticipacionPorConsorcios(
        $data['consorcios']
    );
    return true;
}