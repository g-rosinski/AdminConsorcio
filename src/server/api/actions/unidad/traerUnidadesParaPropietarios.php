<?php
    header("Content-Type: application/json; charset=UTF-8");
    require_once './../../config/db.php';
    

    include_once './../../entities/unidad.php';

    echo traerUnidadesParaPropietarios();

    function traerUnidadesParaPropietarios(){

        $db = new DB();
        $unidad = new Unidad($db);
        $n = (int)$_GET['id_consorcio'];
        echo $n;        

        $h = $unidad->UnidadesSinPropietarioAsignado($n);
        while ($obj = $h->fetch_assoc()) {
                    echo "<pre>" . print_r($obj,true) . "</pre>";
                    /*var_dump($obj);*/
                }
/*        die;
/*
        if ($a = call_user_func_array(array($db->getConnection(),'prepare'),$query )   ) {
            
            $b = call_user_func_array(array($a,'bind_param'),array("i", array($n)) );
            $a->execute();
            $h = $a->get_result();
            //echo "<pre>" . print_r($a,true) . "</pre>";
            //                op1
        while ($obj = $h->fetch_assoc()) {
                    echo "<pre>" . print_r($obj,true) . "</pre>";
                    //var_dump($obj);
                }

                die;
                //                      op2
        while ($obj = $unidadesEncontradas->fetch_object()) {
            $arrayUnidades[] = $obj;
            echo "<pre>" . print_r($oarrayUnidadesbj,true) . "</pre>";
        }



            echo "tiene prepare ";
        }else{ echo "no tiene prepare"; }die;


        $unidad = new Unidad($db);
        $data = $_GET;
        $unidadesEncontradas = $unidad->UnidadesSinPropietarioAsignado($data['id_consorcio']);
        $arrayUnidades = array();
        while ($obj = $unidadesEncontradas->fetch_object()) {
            $arrayUnidades[] = $obj;
        }
        // echo "<pre>".print_r($arrayUnidades,true)."</pre>";die:
        return json_encode($arrayUnidades);
        */
    }
?>