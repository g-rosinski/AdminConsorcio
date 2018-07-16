<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo traerDatosDeExpensa();

function traerDatosDeExpensa()
{

    try {
        $db = new DB();
        $expensa = new Expensa($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    $data = $_GET;
    
    $detalleExpensa = $expensa->traerDetalleDeExpensa($data['idExpensa']);

    $arrayDetalleExpensa = array();
    while ($obj = $detalleExpensa->fetch_object()) {  
        $arrayDetalleExpensa[] = $obj;
    }


    return json_encode($arrayDetalleExpensa);
}
