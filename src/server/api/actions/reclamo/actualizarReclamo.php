<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo actualizarReclamo();

function actualizarReclamo()
{

    try{
    	$db = new DB();
    	$reclamo = new Reclamo($db);
    }catch(Exception $e){echo "Msj:".$e->getMessage();}
    
    $data = $_POST;

    $reclamo->cambiarEstadoReclamo(
        $data['id_reclamo'],
        $data['id_estado']
    );
    
}

?>