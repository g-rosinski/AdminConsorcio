<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo nuevoGasto();

function nuevoGasto()
{

    try {
        $db = new DB();
        $gasto = new Gasto($db);
        $reclamo = new Reclamo($db);
        $gastoMensual = new GastoMensual($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    $data = $_POST;
    $gasto->procesarGasto(
        $data['descripcion'],
        $data['importe'],
        $data['id_motivo_gasto'],
        $data['id_proveedor'],
        $gastoMensual->traerIdGastoMensual($data['id_consorcio']),        
        $data['id_reclamo'],
        $data['operador']
    );
    $reclamo->procesarReclamo(
        $data['id_reclamo']
    );
    echo "todo ok";

}