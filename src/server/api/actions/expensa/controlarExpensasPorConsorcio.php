<?php
require_once './../../utils/autoload.php';
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

echo json_encode(controlarExpensasPorConsorcio());
         
function controlarExpensasPorConsorcio()
{

    try {
        $db = new DB();
        $unidad = new Unidad($db);
        $expensa = new Expensa($db);
        $ctaCte = new Cuentacorriente($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    $data = $_POST;
    // Lista de consorcios a consultar
    $arrConsorcios = $data['id_consorcio']; 

    // Verificar estado de cuenta para determinar el estado de las expensas
    foreach($arrConsorcios as $idConsorcio){
        $arrUnidadesDelConsorcio = $unidad->traerUnidadesPorConsorcio($idConsorcio);
        $arrCtaCteConSaldo=array();
        foreach ($arrUnidadesDelConsorcio as $idUnidad) {
            $idCtacte = $ctaCte->traerCtaCtePorUnidad($idUnidad);
            $saldoCtacte = $ctaCte->traerSaldoCtaCte($idCtacte);
            $arrCtaCteConSaldo[$idCtacte] = $saldoCtacte;
        }
        $expensa->controlarExpensasImpagas($arrCtaCteConSaldo);
    }  
    return true;   
}