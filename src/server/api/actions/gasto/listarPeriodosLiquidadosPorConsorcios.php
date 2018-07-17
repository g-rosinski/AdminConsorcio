<?php
require_once './../../utils/autoload.php';
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

echo listarPeriodosLiquidadosPorConsorcios();

function listarPeriodosLiquidadosPorConsorcios()
{

    try {
        $db = new DB();
        $gm = new GastoMensual($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    // Solo requiere el Id del mes, traera todos los gastos de un consorcio
    $data = $_GET;
    $periodosEncontrados = $gm->traerPeriodosLiquidadosPorConsorcio($data['idConsorcio']);

    $arrayPeriodos = array();
    while ($obj = $periodosEncontrados->fetch_object()) {
        $arrayPeriodos[] = $obj;
    }
    
     return json_encode($arrayPeriodos);
}
// Devuelve un json con el siguiente formato
/* 
 * "idGastoMensual": 1,
 * "periodo": "2018 - 06",
 * "fechaLiquidacion": "2018-07-17"
 */