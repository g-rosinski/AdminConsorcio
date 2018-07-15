<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once './../utils/autoload.php';

try{ $db = new DB(); }
catch(Exception $e){ echo $e->getMessage();}

echo json_encode(ejecutarSeeders($db));
echo actualizarPrcDeParticipacionPorConsorcios($db);


// http://localhost/server/api/actions/seeders.php
function ejecutarSeeders($db)
{
    return $db->ejecutarSeeders();
}

function actualizarPrcDeParticipacionPorConsorcios($db){
    try{
        $unidad = new Unidad($db);
    }catch(Exception $e){ echo $e->getMessage();}

    $data['consorcios'] = array(1,2,3,4,5,6,7,8,9,10);
    $unidad->calcularPrcParticipacionPorConsorcios(
        $data['consorcios']
    );
    return 'Porcentajes de participacion calculados';
}
