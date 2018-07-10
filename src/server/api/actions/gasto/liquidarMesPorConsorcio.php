<?php
require_once './../../utils/autoload.php';
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

echo json_encode(liquidarMesPorConsorcio());
         
function liquidarMesPorConsorcio()
{

    try {
        $db = new DB();
        $gastoMensual = new GastoMensual($db);
        $consorcio = new Consorcio($db);
        $expensa = new Expensa($db);
        $ctaCte = new Cuentacorriente($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    $data = $_POST;
    $arrConsorcios = $data['id_consorcio'];
    $vencimiento = $data['vencimiento']; // yyyy-mm-dd
   
    foreach($arrConsorcios as $idConsorcio){
        $totalDelMes = $gastoMensual->obtenerTotalDelMes($idConsorcio);
        $idGastoMensual = $gastoMensual->traerIdGastoMensual($idConsorcio);
        $unidadesALiquidar = $consorcio->traerParticipacionDelConsorcio($idConsorcio);
        var_dump($unidadesALiquidar);die;
        foreach($unidadesALiquidar as $id_unidad => $participacion){
            $idCtaCte = $ctaCte->traerCtaCtePorUnidad($id_unidad);
            $cuentasALiquidar[$idCtaCte]=$participacion;
        }
        $expensa->liquidarExpensas($idGastoMensual,$cuentasALiquidar,$totalDelMes,$vencimiento);
        $ctaCte->actualizarSaldoCtacte($cuentasALiquidar);
    }
    $gastoMensual->liquidarGastoMensualPorConsorcio($arrConsorcios);

}
