<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo json_encode(liquidarMesPorConsorcio());

function liquidarMesPorConsorcio()
{

    try {
        $db = new DB();
        $gastoMensual = new GastoMensual($db);
        $consorcio = new Consorcio($db);
        $expensa = new Expensa($db);
        $ctaCte = new
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    $data = $_POST;
    $idConsorcio = $data['id_consorcio'];
    $totalDelMes = $gastoMensual->obtenerTotalDelMes($idConsorcio);
    $unidadesALiquidar = $consorcio->traerParticipacionDelConsorcio($idConsorcio);
    $idCtaCte = $ctaCte->traerCtaCtePorUnidad($id_unidad);
    $expensa->calcularExpensas($unidadesALiquidar,$totalDelMes);
    

}
