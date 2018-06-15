<?php
    header("Content-Type: application/json; charset=UTF-8");
    include_once './../../config/db.php';
    include_once './../../entities/unidad.php';

    echo traerUnidadesParaPropietarios();

    function traerUnidadesParaPropietarios(){

        $db = new DB();
        $unidad = new Unidad($db);
        $data = $_GET;
        $unidadesEncontradas = $unidad->UnidadesSinPropietarioAsignado($data['id_consorcio']);
        $arrayUnidades = array();
        while ($obj = $unidadesEncontradas->fetch_object()) {
            $arrayUnidades[] = $obj;
        }
        // echo "<pre>".print_r($arrayUnidades,true)."</pre>";die:
        return json_encode($arrayUnidades);
    }
?>