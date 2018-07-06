<?php
require_once './../../utils/autoload.php';
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

echo listarGastosPorConsorcio();

function listarGastosPorConsorcio()
{

    try {
        $db = new DB();
        $gasto = new Gasto($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    $data = $_GET;
    $gastosEncontrados = $gasto->traerGastosPorUnConsorcio($data['id_consorcio']);

    $arrayGastos = array();
    while ($obj = $gastosEncontrados->fetch_object()) {
        $arrayGastos[] = $obj;
    }

     return json_encode($arrayGastos);
}
