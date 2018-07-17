<?php
require_once './../../utils/autoload.php';
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

echo listarGastosHistoricosPorConsorcio();

function listarGastosHistoricosPorConsorcio()
{

    try {
        $db = new DB();
        $gasto = new Gasto($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    // Solo requiere el Id del mes, traera todos los gastos de un consorcio
    $data = $_GET;
    $gastosEncontrados = $gasto->traerGastosHistoricosPorUnConsorcio($data['idGastoMensual']);

    $arrayGastos = array();
    while ($obj = $gastosEncontrados->fetch_object()) {
        $arrayGastos[] = $obj;
    }

     return json_encode($arrayGastos);
}
