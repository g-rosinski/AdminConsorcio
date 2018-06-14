<?php

class Unidad {

    private $connection;
    private $tabla = "unidad";
    /* Campos de la tabla */
    private $idUnidad; 
    private $prcParticipacion;  //setPrcParticipacion
    private $piso;              //setPiso
    private $departamento;      //setDepartamento
    private $nro_unidad;        //setNro_unidad
    private $superficie;        //setSuperficie
    private $id_consorcio;      //setIdConsorcio

    
    public function __construct($connection)
    {
        $this->connection = $connection;
    }
    
    public function UnidadesConPropietarioAsignado($consorcio){
        $this->setIdConsorcio($consorcio);
        return $this->consultarUnidadesConPropietario();
    }
    public function UnidadesSinPropietarioAsignado($consorcio){
        $this->setIdConsorcio($consorcio);
        return $this->consultarUnidadesSinPropietario();        
    }
    
    private function consultarUnidadesSinPropietario(){
        $query = $this->connection->prepare("
        SELECT u.id_unidad AS id, u.piso AS piso , u.departamento AS deptounidad
        FROM unidad u left join propietariounidad p on p.id_unidad = u.id_unidad
        WHERE u.id_consorcio = ? 
        AND p.user is null");
        $query->bind_param("i",$this->id_consorcio);
        $query->execute();
        $reg = $query->get_result();
        return $reg;
    }
    private function consultarUnidadesConPropietario(){
        $query = $this->connection->prepare("
        SELECT u.id_unidad AS id , u.piso AS piso , u.departamento AS depto
        FROM unidad u left join propietariounidad p on p.id_unidad = u.id_unidad
        WHERE u.id_consorcio = ? 
        AND p.user is not null
        AND p.inquilino_de is null");
        $query->bind_param("i",$this->id_consorcio);
        $query->execute();
        $reg = $query->get_result();
        return $reg;
    }

    private function setPrcParticipacion($prcParticipacion){ 
        try{$this->prcParticipacion = $this->validarVariableNumerica($prcParticipacion);}
        catch(Exception $e){ echo "Msj:" . $e->getMessage(); }
    }
    private function setPiso($piso){ 
        try{$this->piso = $this->validarVariableNumerica($piso);}
        catch(Exception $e){ echo "Msj:" . $e->getMessage(); }
    }
    private function setDepartamento($departamento){ 
        try{$this->departamento = $this->validarVariableString($departamento);}
        catch(Exception $e){ echo "Msj:" . $e->getMessage(); }
    }
    private function setNro_unidad($nro_unidad){ 
        try{$this->nro_unidad = $this->validarVariableNumerica($nro_unidad);}
        catch(Exception $e){ echo "Msj:" . $e->getMessage(); }
    }
    private function setSuperficie($superficie){ 
        try{$this->superficie = $this->validarVariableNumerica($superficie);}
        catch(Exception $e){ echo "Msj:" . $e->getMessage(); }
    }
    private function setIdConsorcio($id_consorcio){ 
        try{$this->id_consorcio = $this->validarVariableNumerica($id_consorcio);}
        catch(Exception $e){ echo "Msj:" . $e->getMessage(); }
    }

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

?>