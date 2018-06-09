<?php
require_once 'conexion.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (empty(validarCampos())) {
    registrarUsuario();
} else {
    echo json_encode(validarCampos());
}

function validarCampos()
{
    $errores = array();
    $campos = array('user', 'pass', 'repass', 'email', 'name', 'lastName', 'dni');
    $esValido = true;

    foreach ($campos as &$valor) {
        if (empty(($_POST[$valor]))) {
            $esValido = false;
        }
    }

    if (!$esValido) {
        $errores[] = 'Por favor complete todos los campos';
    } elseif ($_POST['pass'] != $_POST['repass']) {
        $esValido = false;
        $errores[] = 'Las contraseñas no coinciden';
    }

    return $errores;
}

function registrarUsuario()
{
    $user = $_POST['user'];
    $pass = md5($_POST['pass']);
    $name = $_POST['name'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $dni = $_POST['dni'];
    $estado = 'INACTIVO';

    $uQueryPersona = "INSERT INTO persona (apellido, nombre, dni, email) VALUES (('$lastName'),('$name'),('$dni'),('$email'))";
    $id = ejecutarInsertYObtenerId($uQueryPersona);

    $uQueryUsuario = "INSERT INTO usuario (user, pass, id_persona, estado) VALUES (('$user'),('$pass'),($id),('$estado'))";
    ejecutarInsertYObtenerId($uQueryUsuario);
}
