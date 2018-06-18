<?php
    header("Content-Type: application/json; charset=UTF-8");
    require_once './../../config/db.php';
    

    include_once './../../entities/unidad.php';

    echo traerUnidadesParaInquilinos();

    function traerUnidadesParaInquilinos(){

        $db = new DB();
        $unidad = new Unidad($db);
        $data = $_GET;

        $unidadesEncontradas = $unidad->unidadesConPropietarioAsignado($data['id_consorcio']);
        
        $arrayUnidades = array();
        while ($obj = $unidadesEncontradas->fetch_object()) {
            $arrayUnidades[] = $obj;
        }

        return json_encode($arrayUnidades);
    }
?>