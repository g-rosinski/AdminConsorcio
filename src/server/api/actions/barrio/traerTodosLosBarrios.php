<?php
require_once './../../utils/autoload.php';
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

echo traerTodosLosBarrios();

function traerTodosLosBarrios()
{

    try {
        $db = new DB();
        $barrio = new Barrio($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    $barrios = $barrio->traerTodosLosBarrios();

    $arrayBarrios = array();
    while ($obj = $barrios->fetch_object()) {
        $arrayBarrios[] = $obj;
    }

    return json_encode($arrayBarrios);
}
