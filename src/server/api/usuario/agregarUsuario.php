<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once './../config/db.php';
include_once './../entities/usuario.php';

echo agregarUsuario();

function agregarUsuario()
{
    $db = new DB();
    $usuario = new Usuario($db->getConnection());
    $data = $_POST;

    $usuario->user = $data.user;
    $usuario->pass = md5($data.pass);
    // $usuario->id_persona =  ACA QUE HACEMO ?
    $usuario->estado = 'INACTIVO';
    
    return $usuario->agregarUsuario();
}
