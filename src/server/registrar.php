<?php
require_once 'conexion.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (empty(validar())) {
    registrarUsuario();
} else {
    echo json_encode(validar());
}

// TODO: Tenemos que validar que el formato del user?
// Por ejemplo: solo letras, sin espacio.
function validar()
{
    $campos = array('user', 'pass', 'repass', 'email', 'name', 'lastName', 'dni');

    foreach ($campos as &$valor) {
        if (empty(($_POST[$valor]))) {
            return 'Por favor complete todos los campos';
        }
    }

    if (validarSiElUsuarioExiste()) {
        return 'Nombre de usuario ya existe. Por favor elija otro';
    }

    if ($_POST['pass'] != $_POST['repass']) {
        return'Las contraseñas no coinciden';
    }

    return;
}

function validarSiElUsuarioExiste()
{
    $user = $_POST['user'];
    $query = "SELECT user FROM usuario WHERE (user) = ('$user')";
    $listaUsers = mysqli_fetch_assoc(ejecutarSQL($query));

    return !empty($listaUsers['user']);
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
