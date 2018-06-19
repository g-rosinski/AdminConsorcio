<?php


class Query{

    private $connection;
    private $query;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function prepare($query){
        $this->query = call_user_func_array(array($this->connection->getConnection(),'prepare'),$query);
    } 
    public function sendData($type,$param){
        if (!empty($type) && !empty($param)) {
            call_user_func_array(array($this->query,'bind_param'),$this->bindTypeAndParams($type, $param) );
        }
        $this->query->execute();        
        $result = $this->query->get_result();
        $this->query->close();
        return $result;
    }
    public function execute($query, $type, $param){
        $this->prepare($query);                
        $result = $this->sendData($type,$param);
        return $result;
    }

    private function bindTypeAndParams($type , $param){
        $arrParam = array();
        $paramType = '';
        $numOfParam = count($type);
        for($i=0 ; $i<$numOfParam; $i++){
            $paramType .= $type[$i];
        }
        $arrParam[] = & $paramType;
        for($i=0 ; $i<$numOfParam; $i++){
            $arrParam[] = & $param[$i];
        }

        return $arrParam;
    }

    public function select($campos){
        $q= "SELECT ";
        if(count($campos)==0){
            $q .= "*";
        }else{
            foreach($campos as $key => $campo){
                ($key == 0) ? $q .= $campo : $q .= " , " .$campo;                
            }
        }
        $this->query = $q;
    }
    public function from($tabla)
    {
        $this->query .= " " . $tabla;
    }

    public function where($campo, $op){
        $this->query .= "WHERE ". $campo ." ". $op ." ?";
    }
    
    public function condAnd($campo, $op){
        $this->query .= " AND ". $campo ." ". $op ." ?";
    }
    public function condOr($campo, $op){
        $this->query .= " OR ". $campo ." ". $op ." ?";
    }
    public function whereIn($campo, $valores){
        foreach($valores as $valor){
            (!empty($valoresBuscados)) ? $valoresBuscados .= ",". $valor : $valoresBuscados =  $valor ." " ;
        }
        $this->query .= "WHERE ". $campo ." in ( " . $valoresBuscados . ")";
    }
}