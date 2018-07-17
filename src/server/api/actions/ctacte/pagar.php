<?php
require_once './../../utils/autoload.php';
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

echo pagar();

function pagar()
{

    try {
        $db = new DB();
        $cc = new Cuentacorriente($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    $response = true;
    $data = $_POST;
    $idCtaCte = $cc->traerCtaCtePorUnidad($data['idUnidad']);
    $cc->realizarPago($data['user'], $idCtaCte);

    return json_encode($response);
}
