<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once './../../config/db.php';
include_once './../../entities/usuario.php';
include_once './../../entities/persona.php';
include_once './../../entities/unidad.php';

$db = new DB();
echo registrar($db);

function registrar(&$db)
{
    $errores = validar($db);
    if (empty($errores)) {
        agregarPersona($db);
        // OBTENGO EL ID la persona que acabo de generar.
        $idPersona = $db->obtenerUltimoInsertId();
        agregarUsuario($db, $idPersona);
        agregarRelacionUnidadPersona($db);
    }

    return json_encode($errores);
}

function agregarUsuario($db, $idPersona)
{
    $usuario = new Usuario($db);
    $data = $_POST;

    $usuario->user = $data['user'];
    $usuario->pass = md5($data['pass']);
    $usuario->id_persona = $idPersona;
    $usuario->estado = 'INACTIVO';

    return $usuario->agregarUsuario();
}

function agregarPersona(&$conexion)
{
    $persona = new Persona($conexion);
    $data = $_POST;

    $persona->apellido = $data['lastName'];
    $persona->nombre = $data['name'];
    $persona->dni = $data['dni'];
    $persona->email = $data['email'];

    return $persona->agregar();
}

function agregarRelacionUnidadPersona($db)
{
    $unidad = new Unidad($db);
    $unidad->AgregarRelacionPersonaUnidad($_POST['user'], $_POST['rol'], $_POST['unit']);
}

function validarSiElUsuarioExiste($db)
{
    $user = $_POST['user'];
    $query = "SELECT user FROM usuario WHERE (user) = ('$user')";
    $listaUsers = $db->ejecutar($query)->fetch_assoc();

    return !empty($listaUsers['user']);
}

function validar($db)
{
    $campos = array('user', 'pass', 'repass', 'email', 'name', 'lastName', 'dni', 'consorcio', 'unit');

    foreach ($campos as &$valor) {
        if (empty(($_POST[$valor]))) {
            return 'Por favor complete todos los campos';
        }
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        return 'Por favor ingrese un email valido';
    }

    if (validarSiElUsuarioExiste($db)) {
        return 'Nombre de usuario ya existe. Por favor elija otro';
    }

    if (strlen($_POST['pass']) < 6) {
        return 'La contraseña debe tener al menos 6 caracteres';
    }

    if ($_POST['pass'] != $_POST['repass']) {
        return 'Las contraseñas no coinciden';
    }

    return;
}
