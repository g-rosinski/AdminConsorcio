<?php 
	class Validator{

		public function validarVariableString($var)
	    {
	        if (!empty($var) && is_string($var)) {
	            return $var;
	        } else {
	            throw new Exception("El valor ".$var." es null o no es de tipo String");
	        }
	    }
	    public function validarVariableNumerica($var)
	    {
	        if (!empty($var) && is_numeric($var)) {
	            return $var;
	        } else {
	            throw new Exception("El valor ".$var." es null o no es de tipo Numerico");
	        }
	    }
	    public function validarCampoEmail($email){
	    	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	        	return 'Por favor ingrese un email valido';
	    	}
	    }
	    public function validarCampoPassword($pass){
	    	if (strlen($pass) < 6) {
		        return 'La contraseña debe tener al menos 6 caracteres';
		    }
	    }

	    public function validarCamposVacios($arrCampos){
	    	foreach ($arrCampos as $campo) {
		        if (empty($campo)) {
		            return 'Por favor complete todos los campos';
		        }
		    }
		}		
		public function validarArray($arr){
        if(count($arr)==0 || !is_array($arr)){throw new Exception("es un array vacio o no es un array");}
    	}
	}
?>