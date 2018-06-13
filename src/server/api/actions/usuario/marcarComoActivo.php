<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once './../../config/db.php';
include_once './../../entities/usuario.php';

echo marcarComoActivo($_POST['id']);

function marcarComoActivo($id)
{
    $db = new DB();
    $usuario = new Usuario($db);
    $usuario->id = $id;

    return $usuario->marcarComoActivo();
}
