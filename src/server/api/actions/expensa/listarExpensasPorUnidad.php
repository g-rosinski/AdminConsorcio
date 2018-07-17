<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo listarExpensasPorUnidad();

function listarExpensasPorUnidad()
{

    try {
        $db = new DB();
        $expensa = new Expensa($db);
        $cc = new Cuentacorriente($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    // Solo necesita el Id de la unidad
    $data = $_GET;          
    $ctaCteUnidad = $cc->traerCtaCtePorUnidad($data['idUnidad']);
    $expensasEncontradas = $expensa->listarExpensasPorCtaCte($ctaCteUnidad);

    $arrayExpensas = array();
    while ($obj = $expensasEncontradas->fetch_object()) {
        $arrayExpensas[] = $obj;
    }
    return json_encode($arrayExpensas);
}
// Devuelve un json con el siguiente formato
/* 
 * "idExpensa": 1,
 * "total": 762.65,
 * "cuotaAnual": 6,
 * "estado": "Sin vencer"
 */
