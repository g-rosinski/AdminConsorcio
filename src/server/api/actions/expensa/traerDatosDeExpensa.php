<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once './../../utils/autoload.php';

echo traerDatosDeExpensa();

function traerDatosDeExpensa()
{

    try {
        $db = new DB();
        $expensa = new Expensa($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    $data = $_GET;
    
    $detalleExpensa = $expensa->traerDetalleDeExpensa($data['idExpensa']);

    $arrayDetalleExpensa = array();
    while ($obj = $detalleExpensa->fetch_object()) {  
        $arrayDetalleExpensa[] = $obj;
    }


    return json_encode($arrayDetalleExpensa);
}
// Detalle que devuelve:
//
/* Array(
	'expensa' => Array(
			'total'=> Total de la expensa seleccionada
			'impteExtraordinaria'=> Subtotal calculado de los gastos del mes
			'mora' => Importe de mora por expensas vencidas
			'cuotaAnual'=> nro de cuota de la expensa
			'vencimiento'=> fecha de vencimiento yyyy-mm-dd
			'idGastoMensual'=> id de la liquidacion, no va al pdf
	)
	'gastos' => Array(
        'rubros'=> Array(
            0 => Array(
                '<nombreRubro>' => Array(
                    '<motivoDelGasto>'=>nombre
                    'totalGasto'=> total gastado en esto
                    'detalle'=> Array(
                        'proveedor' => nombre de proveedor
                        'importe' => importe del gasto
                        'descripcion' => mensaje del gasto
                    )
                )
            )
        )
    )
)
 */