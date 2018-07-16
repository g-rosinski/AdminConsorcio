<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo json_encode(agregarUnidad());

function agregarUnidad()
{

    try { $db = new DB();} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    $unidad = new Unidad($db);
    $data = $_POST;

    $unidad->agregarUnidad(
        $data['piso'],
        $data['depto'],
        $data['nroUnidad'],
        $data['superficie'],
        $data['id_consorcio']
    );


    
    // echo "<pre>" . print_r($data, true) . "</pre>";die;
    return $unidad->calcularPrcParticipacionPorConsorcios(array($data['id_consorcio']));
    
}
