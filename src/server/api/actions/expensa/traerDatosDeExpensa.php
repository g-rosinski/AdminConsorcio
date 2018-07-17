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
        $gastos = new Gasto($db);
    } catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    // Solo necesita el Id de la expensa
    $data = $_GET;          
    
    $expensaEncontrada = $expensa->traerDetalleDeExpensa($data['idExpensa']);
    $detalleExpensa = $expensaEncontrada->fetch_assoc();
    $detalleGastos = $gastos->listarGastosPorIdGastoMensual($detalleExpensa['idGastoMensual']);

    $arrayDetalleCompleto = Array(
        "expensa" => $detalleExpensa,
        "gastos" => $detalleGastos
    );

    return json_encode($arrayDetalleCompleto);
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
            '<nombreRubro>' => Array(
                0 => Array(
                    '<motivo>'=>nombre
                    'totalGasto'=> total gastado en esto
                    'detalle'=> Array(
                        0 => Array(
                            'proveedor' => nombre de proveedor
                            'importe' => importe del gasto
                            'descripcion' => mensaje del gasto
                        )
                    )
                )
            )
        )
    )
)
 */