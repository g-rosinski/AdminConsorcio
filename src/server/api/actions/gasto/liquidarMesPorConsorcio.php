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
    // Lista de consorcios a liquidar
    $arrConsorcios = $data['id_consorcio']; 
    // yyyy-mm-dd
    $vencimiento = $data['vencimiento']; 
   
    foreach($arrConsorcios as $idConsorcio){
        $totalDelMes = $gastoMensual->obtenerTotalDelMes($idConsorcio);
        $idGastoMensual = $gastoMensual->traerIdGastoMensual($idConsorcio);
        $unidadesALiquidar = $consorcio->traerParticipacionDelConsorcio($idConsorcio);
        foreach($unidadesALiquidar as $id_unidad => $participacion){
            $idCtaCte = $ctaCte->traerCtaCtePorUnidad($id_unidad);
            $cuentasALiquidar[$idCtaCte]=$participacion;
        }
        
        $expensa->liquidarExpensas($idGastoMensual,$cuentasALiquidar,$totalDelMes,$vencimiento);
        $ctaCte->actualizarSaldoCtacte($cuentasALiquidar);
        $arrIdGastoMensualLiquidado[$idConsorcio]=$idGastoMensual;
        echo "<pre>".print_r($arrIdGastoMensualLiquidado,true)."</pre>";
    } 
    $gastoMensual->liquidarGastoMensualPorConsorcio($arrConsorcios);



    foreach ($arrIdGastoMensualLiquidado as $idConsorcio => $idGastoMensualLiquidado) {
        $gastosImpagos = $gastoMensual->traerGastosImpagos($idGastoMensualLiquidado);  
        if($gastosImpagos){
            $gastoMensual->trasladarGastosAMesCorriente($idConsorcio,$gastosImpagos);
        }
    }

}
