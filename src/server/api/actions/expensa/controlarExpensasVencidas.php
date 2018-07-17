<?php
require_once './../../utils/autoload.php';
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

echo controlarExpensasVencidas();

function controlarExpensasVencidas()
{

    try {
        $db = new DB();
        $exp = new Expensa($db);
        $cc = new Cuentacorriente($db);
        $uni = new Unidad($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    $data = $_POST;

    // Lista de consorcios a liquidar
    $arrConsorcios = $data['consorcio'];

    $response = true; 
    $avisoMsj = '';
    foreach ($arrConsorcios as $idConsorcio) {
        
        $arrUnidades = $uni->traerUnidadesPorConsorcio($idConsorcio);
        $arrayCtaCteConSaldo = $cc->traerArrayCtaCteConSaldo($arrUnidades);
        $msj = $exp->controlarExpensasImpagas($arrayCtaCteConSaldo);
        (!is_string($msj))? $msj: $avisoMsj.= $idConsorcio." - " ;
    }
    ($avisoMsj=='')? $response : $response="consorcios: ".$avisoMsj." no poseen expensas impagas";

    return json_encode($response);
}