<?php
function parseArrayToObject($array)
{
    $aux = array();

    while ($obj = $array->fetch_object()) {
        $aux[] = $obj;
    }

    return $aux;
}
