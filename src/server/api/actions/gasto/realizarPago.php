<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo json_encode(realizarPago());

function realizarPago()
{

    try {
        $db = new DB();
        $gasto = new Gasto($db);
        $pagoGasto = new PagoGasto($db);
        $reclamo = new Reclamo($db);
        $gastoMensual = new GastoMensual($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    $data = $_POST;
    // Requiere una numero de factura(tipo numerico), y el id del gasto que se paga
    // Agregará el pago, cerrará el reclamo y agregará el total del gasto al gasto mensual del consorcio
    $pagoGasto->procesarPagoGasto(
        $data['nro_orden_pago'],
        $data['id_gasto']
    ); 
    $gastoPagado = $gasto->traerDetalleGasto($data['id_gasto'])->fetch_assoc();
    $reclamo->cerrarReclamo(
        $gastoPagado['idReclamo']
    ); 
    $gastoMensual->actualizarTotalGastoMensual(
        $gastoPagado['idGastoMensual'],
        $gastoPagado['importe']
    );

    return true;
}