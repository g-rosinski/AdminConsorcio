<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once './../../config/db.php';
include_once './../../entities/usuario.php';

echo json_encode(loguear()); 

function loguear()
{
    $db = new DB();
    $persona = new Usuario($db);
    $error = 'Usuario o Contraseña no son validos';
    $data = $_POST;

    if (empty($_POST['user'])) {
        return $error;
    }

    $userDB = $persona->obtenerPorUser($_POST['user'])->fetch_assoc();
    if (!empty($userDB['user']) && md5($data['pass']) == $userDB['pass']) {
        if ($userDB['estado'] == 'INACTIVO') {
            return 'Su Usuario no ha sido activado. Consulte con el administrador';
        }

        $_SESSION['user'] = $userDB;
        return;
    } else {
        return $error;
    }
}
