<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once './../../config/db.php';
include_once './../../entities/usuario.php';
include_once './../../entities/persona.php';

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

function validarSiElUsuarioExiste($db)
{
    $user = $_POST['user'];
    $query = "SELECT user FROM usuario WHERE (user) = ('$user')";
    $listaUsers =  $db->ejecutar($query)->fetch_assoc();

    return !empty($listaUsers['user']);
}

// TODO: Tenemos que validar que el formato del user?
// Por ejemplo: solo letras, sin espacio.
function validar($db)
{
    $campos = array('user', 'pass', 'repass', 'email', 'name', 'lastName', 'dni');

    foreach ($campos as &$valor) {
        if (empty(($_POST[$valor]))) {
            return 'Por favor complete todos los campos';
        }
    }

    if (validarSiElUsuarioExiste($db)) {
        return 'Nombre de usuario ya existe. Por favor elija otro';
    }

    if ($_POST['pass'] != $_POST['repass']) {
        return 'Las contraseñas no coinciden';
    }

    return;
}
