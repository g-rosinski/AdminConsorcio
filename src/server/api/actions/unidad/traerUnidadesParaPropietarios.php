<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo traerUnidadesParaPropietarios();

function traerUnidadesParaPropietarios()
{
		try{$db = new DB();}catch(Exception $e){echo "Msj:".$e->getMessage();}        
        $unidad = new Unidad($db);
        $data = $_GET;

        $unidadesEncontradas = $unidad->unidadesSinPropietarioAsignado($data['id_consorcio']);

        $arrayUnidades = array();
        while ($obj = $unidadesEncontradas->fetch_object()) {
            $arrayUnidades[] = $obj;
        }

        return json_encode($arrayUnidades);

}
