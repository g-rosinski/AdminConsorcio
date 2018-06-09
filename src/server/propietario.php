<?php
require_once('conexion.php');
header("Access-Control-Allow-Origin: *");

$propietario = new stdClass();
$propietario->name = 'Julian';
$propietario->consorcio = 'IANI!';

echo json_encode($propietario);
?>