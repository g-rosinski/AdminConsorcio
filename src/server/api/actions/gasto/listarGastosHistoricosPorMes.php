<?php
require_once './../../utils/autoload.php';
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

echo listarGastosHistoricosPorMes();

function listarGastosHistoricosPorMes()
{

    try {
        $db = new DB();
        $gasto = new Gasto($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    // Solo requiere el Id del mes, traera todos los gastos de un consorcio
    $data = $_GET;
    $gastosEncontrados = $gasto->traerGastosHistoricosPorUnMes($data['idGastoMensual']);

    $arrayGastos = array();
    while ($obj = $gastosEncontrados->fetch_object()) {
        $arrayGastos[] = $obj;
    }

     return json_encode($arrayGastos);
}
// Devuelve un json con el siguiente formato
/* 
 * [
 *     {
 *         "nroGasto": 1,
 *         "motivo": "Tuberias",
 *         "proveedor": "Brainverse",
 *         "importe": 4650,
 *         "titulo": "En mi departamento se esta inunando por tuberias pinchadas",
 *         "nroPago": 6548362
 *     },
 *     {
 *         "nroGasto": 2,
 *         "motivo": "Portero",
 *         "proveedor": "Zoomdog",
 *         "importe": 658,
 *         "titulo": "El portero no suena cuando apretas el timbre de cualquier departamento",
 *         "nroPago": 684926
 *     }
 * ]
 */