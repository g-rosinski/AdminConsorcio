<?php
// require_once('./../utils/autoload.php');
session_start();
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
echo json_encode($_SESSION['expire']);

// echo 'ssañlkjsdl';