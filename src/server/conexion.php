<?php

function conectarBD()
{
    $host = "127.0.0.1";
    $db = "iani";
    $db_user = "root";
    $db_pass = "";

    $conexion = mysqli_connect($host, $db_user, $db_pass, $db);

    if (!$conexion) {
        echo "No se establecio la conexion correctamente";
    } else {
        return $conexion;
    }
}

function ejecutarInsertYObtenerId($query)
{
    $conexion = conectarBD();
    
    try {
        mysqli_query($conexion, $query);
        $id = mysqli_insert_id($conexion);

        if(mysqli_error($conexion)) throw new Exception(mysqli_error($conexion));
        
    } catch(Exception  $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
    }

    mysqli_close($conexion);

    return $id;
}
