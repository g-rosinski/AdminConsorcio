<?php
header("Content-Type: application/json; charset=UTF-8");
include_once './../../config/db.php';
include_once './../../entities/usuario.php';
include_once './../../utils/parseArrayToObject.php';

echo obtenerTodosLosUsuariosInactivos();

function obtenerTodosLosUsuariosInactivos()
{
    $db = new DB();
    $usuario = new Usuario($db);

    $resultados = $usuario->obtenerTodosLosUsuariosInactivos();
    $usuarios = array();

    while ($obj = $resultados->fetch_object()) {
        $usuarios[] = $obj;
    }
    return json_encode($usuarios);
}
