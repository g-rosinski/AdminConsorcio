<?php

class validador
{

    private function validarVariableString($var){
        if(!empty($var) && is_string($var)){
            return $var;
        }else{
            throw new Exception("El valor es null o no es de tipo String");
        }
    }
    private function validarVariableNumerica($var){
        if(!empty($var) && is_numeric($var)){
            return $var;
        }else{
            throw new Exception("El valor es null o no es de tipo Numerico");
        }
    } 

}

>