<?php
    header("Content-Type: application/json; charset=UTF-8");
    include_once './../config/db.php';
    include_once './../entities/usuario.php';

    $db = new DB();
    $unidad = new Unidad($db);

    echo traerUnidadesParaPropietarios();

    public function traerUnidadesParaPropietarios(){
        $unidadesEncontradas = $this->unidad->UnidadesSinPropietarioAsignado();
        $arrayUnidades = array();
        while ($obj = $unidadesEncontradas->fetch_object()) {
            $arrayUnidades[] = $obj;
        }
        echo "<pre>".print_r($arrayUnidades,true)."</pre>";die:
        return json_encode($arrayUnidades);
    }
?>