<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/mercadopago.php';
require_once './../../config/db.php';
include_once './../../entities/cuentacorriente.php';

// CUENTA DEV
// {
//     "id": 336922943,
//     "nickname": "TESTSX7XJCR8",
//     "password": "qatest2101",
//     "site_status": "active",
//     "email": "test_user_82063853@testuser.com"
// }

// CUENTA COMPRADOR
// {
//     "id": 336924247,
//     "nickname": "TESTKE9NZ3SM",
//     "password": "qatest7240",
//     "site_status": "active",
//     "email": "test_user_9492102@testuser.com"
// }

$mp = new MP('4245217028796417', 'yVBJxXMEkFsBl5VWNoztaupN8zVY9SkK');
$db = new DB();
$cc = new Cuentacorriente($db);

$data = $_GET;
$idCtaCte = $cc->traerCtaCtePorUnidad($data['idUnidad']);
$importe = $cc->traerSaldoCtaCte($idCtaCte);
    
$preference_data = array(
    "items" => array(
        array(
            "id" => $data['id'],
            "title" => "Expensas",
            "currency_id" => "ARS",
            "quantity" => 1,
            "unit_price" => (float)$importe,
        ),
    ),
    "back_urls" => array(
        "success" => $data['success'],
        "failure" => $data['fail'],
        "pending" => $data['pend'],
    ),
);
$preference = $mp->create_preference($preference_data);

$boton = new stdClass();
$boton->url = $preference['response']['init_point'];
echo json_encode($boton);