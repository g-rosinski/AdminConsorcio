<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
include_once './../../config/db.php';
include_once './../../entities/usuario.php';

echo obtenerUsuarioFull();

function obtenerUsuarioFull()
{
    $db = new DB();
    $usuario = new Usuario($db);
    $usuario->user = $_GET['user'];
    $resultados = $usuario->obtenerFullUsuario();

    return json_encode($resultados->fetch_object());
}
