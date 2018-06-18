<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

echo obtenerSession();

function obtenerSession()
{
    $session = isset($_SESSION['user']) ? $_SESSION['user'] : null;
    return json_encode($session);
}
