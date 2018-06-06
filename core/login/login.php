<?php 
    session_start();
    if (isset($_POST['user']) && $_POST['user'] != null && isset($_POST['pass']) && $_POST['pass'] != null){
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $pass = md5($pass);
  
        $conexion = mysqli_connect("127.0.0.1","root","","prograweb") or die ("Error en la conexion");
        $sql = "SELECT id,user,pass FROM cliente WHERE user = '$user' AND pass='$pass'";
        $resultado = mysqli_query($conexion, $sql);
        $registro = mysqli_fetch_assoc($resultado);
        if ($registro['user'] == $user && $registro['pass'] == $pass ){
            setcookie("user",$user, time() + 3600);
            setcookie("pass",$pass, time() + 3600);
            header('refresh: 0; url=./home.php');
        } else {
            echo "Error al iniciar sesion: Usuario o contrase&ntilde;a incorrecta.";
            header('refresh: 1; url=./index.php');
        }
    } else {
        echo "Error al iniciar sesion: Usuario o contrase&ntilde;a incorrecta.";
        header('refresh: 1; url=./index.php');
    }

?>