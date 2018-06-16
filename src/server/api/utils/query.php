<?php


class Query{

    private $connection;
    private $query;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function prepare($query){
        $this->query = $this->connection->prepare($query);
    }
    public function execute($query, $type, $param){
        
        if ($this->query = call_user_func_array(array($this->connection->getConnection(),'prepare'),$query )   ) {

            call_user_func_array(array($this->query,'bind_param'),$this->bindTypeAndParams($type, $param) );
            $this->query->execute();        
            return $result = $this->query->get_result();
        }
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

/*    public function execute(){
        return $this->connection->ejecutar($query);
    }*/
    public function selectAll($tabla)
    {
        $this->query .= "SELECT * FROM " . $tabla;
    }

    public function where($campo,$valor){
        $this->query .= "WHERE ". $campo ." = " . $valor;
    }
    public function whereIn($campo, $valores){
        foreach($valores as $valor){
            (!empty($valoresBuscados)) ? $valoresBuscados .= ",". $valor : $valoresBuscados =  $valor ." " ;
        }
        $this->query .= "WHERE ". $campo ." in ( " . $valoresBuscados . ")";
    }
}