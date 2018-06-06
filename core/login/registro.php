<?php 
    session_start();
    if (isset($_POST['user']) && $_POST['user'] != null && 
        isset($_POST['pass']) && $_POST['pass'] != null &&
        isset($_POST['pass2']) && $_POST['pass2'] != null &&
        $_POST['pass'] == $_POST['pass2']){
        
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $pass = md5($pass);
        
        $conexion = mysqli_connect("127.0.0.1","root","","prograweb") or die ("Error en la conexion");
        $sql = "SELECT id FROM cliente WHERE user = '$user'";
        $resultado = mysqli_query($conexion, $sql);
        
        if(mysqli_num_rows($resultado) == 0){
            $sql = "INSERT INTO cliente (user,pass) VALUES ('$user','$pass')";
            $resultado = mysqli_query($conexion, $sql);
            echo "Usuario creado con &eacute;xito<br>Espere y ser&aacute; redirigido...";
            header('refresh: 1; url=./login.php');
        } else {
        echo "Error al crear usuario <br>Espere y ser&aacute; redirigido...";
        header('refresh: 1; url=./signup.php');
        }
    }
?>