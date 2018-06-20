<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo agregarReclamo();

function agregarReclamo()
{

    try{
    	$db = new DB();
    	$motivo = new Reclamo($db);
    }catch(Exception $e){echo "Msj:".$e->getMessage();}
    
    $data = $_POST;

    $motivo->nuevoReclamo(
        $data['id_propietario'],
        $data['titulo'],
        $data['mensaje']
        /* $data['id_motivo_reclamo'] */
    );
    
}

?>