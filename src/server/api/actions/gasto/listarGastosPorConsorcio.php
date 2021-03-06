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
        $gastoMensual = new GastoMensual($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    // Solo requiere el Id de Consorcio, traera los gastos del mes corriente
    $data = $_GET;
    $idGastoMensualActual = $gastoMensual->traerIdGastoMensual($data['id_consorcio']);
    $gastosEncontrados = $gasto->traerGastosPorUnConsorcio($data['id_consorcio'], $idGastoMensualActual);

    $arrayGastos = array();
    while ($obj = $gastosEncontrados->fetch_object()) {
        $arrayGastos[] = $obj;
    }

     return json_encode($arrayGastos);
}
