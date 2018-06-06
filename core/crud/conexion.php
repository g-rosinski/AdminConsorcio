<?php

$pepe = "hola";
Class Conexion{
    static $host="127.0.0.1";
    static $port="3306";
    static $user="root";
    static $pass="";
    static $db="iani";
    static $conexion;


    static function openConnection(){
        
        $conexion = mysqli_connect(Conexion::$host,Conexion::$user,Conexion::$pass,Conexion::$db) or die ("Error en la conexion");
        $q = mysqli_query($conexion,"INSERT INTO persona (nombre,apellido,dni,email) VALUES (('gonza'),('peredo'),('3243534535'),('gonza@prueba.com'))");
        var_dump($q);die;
        if (mysqli_num_rows($q) == 0) {
            echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
            exit;
        }
        while ($fila = mysqli_fetch_assoc($q)) {
            echo "<pre>".print_r($fila,true)."</pre>";
        }
        if ($conexion) {
            echo "conecto";
        }else {
            echo "no funca";
        }
    }

    static function closeConnection(){
        mysqli_close($this->conexion);
    }
    static function getHost(){
        echo $host;
    }
}
?>
