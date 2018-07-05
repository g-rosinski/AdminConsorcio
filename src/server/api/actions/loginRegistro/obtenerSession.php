<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

echo obtenerSession();

function obtenerSession()
{
    $session = isset($_SESSION['user']) ? $_SESSION['user'] : null;

    if (isset($_SESSION['user']) && ($_SESSION['expire'] > time())) {
        return json_encode($_SESSION['user']);
    } else 
    {
        session_destroy();
    }

    return json_encode(null);
}
