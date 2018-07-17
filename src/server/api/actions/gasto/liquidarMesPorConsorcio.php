<?php
require_once './../../utils/autoload.php';
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

echo liquidarMesPorConsorcio();

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
    // Liquida el mes
    $mensajes = array();
    $arrIdGastoMensualLiquidado = array();
    foreach ($arrConsorcios as $idConsorcio) {
        $error = new stdClass();

        $totalDelMes = $gastoMensual->obtenerTotalDelMes($idConsorcio);
        if ($totalDelMes <= 0) {
            $error->id_consorcio = $idConsorcio;
            $error->mensaje = 'El consorcio ' . $idConsorcio . ' no posee movimientos a liquidar';
            $mensajes[] = $error;
            continue;
        }
        if (!$gastoMensual->verificarPeriodoLiquidable($idConsorcio)) {
            $error->id_consorcio = $idConsorcio;
            $error->mensaje = 'El consorcio ' . $idConsorcio . ' aun no se puede liquidar';
            $mensajes[] = $error;
            continue;
        }
        $idGastoMensual = $gastoMensual->traerIdGastoMensual($idConsorcio);
        $unidadesALiquidar = $consorcio->traerParticipacionDelConsorcio($idConsorcio);
        $cuentasALiquidar = array();
        foreach ($unidadesALiquidar as $id_unidad => $participacion) {
            $idCtaCte = $ctaCte->traerCtaCtePorUnidad($id_unidad);
            $cuentasALiquidar[$idCtaCte] = $participacion;
        }
        $expensa->liquidarExpensas($idGastoMensual, $cuentasALiquidar, $totalDelMes, $vencimiento);
        $ctaCte->actualizarSaldoCtacte($cuentasALiquidar);
        $arrIdGastoMensualLiquidado[$idConsorcio] = $idGastoMensual;
    }

    // SI TENGO ERROR. NO DEBO LIQUIDAR GASTOS
    if (count($mensajes) === 0) {
        $gastoMensual->liquidarGastoMensualPorConsorcio($arrConsorcios);

        foreach ($arrIdGastoMensualLiquidado as $idConsorcio => $idGastoMensualLiquidado) {
            $gastosImpagos = $gastoMensual->traerGastosImpagos($idGastoMensualLiquidado);
            if ($gastosImpagos) {
                $gastoMensual->trasladarGastosAMesCorriente($idConsorcio, $gastosImpagos);
            }
        }
    }

    return json_encode($mensajes);
}
