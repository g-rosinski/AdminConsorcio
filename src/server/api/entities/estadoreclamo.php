<?php
require_once './../../utils/autoload.php';

class EstadoReclamo {
    private $id_estado_reclamo;
    private $descripcion;
    private $connection;
    private $query;
    private $validator;

    public function __construct($connection)
    {
        $this->connection = $connection;
        try{ $this->validator = new Validator; }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
    }

    public function traerEstadosDeReclamo(){
    	return $this->consultaEstadoReclamo();
    }
    public function agregarEstadoReclamo($descripcion){
    	$this->setDescripcion($descripcion);
    	return $this->insertEstadoReclamo();
    }
    private function consultaEstadoReclamo(){
    	$this->query = "SELECT id_estado_reclamo, descripcion FROM estadoreclamo";
        return $this->executeQuery();
    }
    private function insertEstadoReclamo(){
    	$this->query = "INSERT INTO estadoreclamo (descripcion) VALUES (?)";
        $arrType = array("s");
        $arrParam = array(
            $this->descripcion
        );
        return $this->executeQuery($arrType,$arrParam);
    }


    // executeQuery ejecuta la consulta, utiliza la query del atributo, recibe como parametro 2 arrays que se utilizarán para bindear a la query
    // $arrType = array [ 0 => "<string>"] El string que debe ir es la letra del tipo de dato que se pasará por parametro
    // Letras según tipo de dato i = int ; s = string ; d = double
    // $arrParam = array [ 0 => "<string>", 1 => "<string>", n => "<string>"] El string será valor que bindeara a la query
    // Ejemplo: Si en mi query necesito pasarle el valor 14, "Calle Falsa", "432"
    // $arrType = array("i","s","s") /* int string string */
    // $arrParam = array(14,"Calle Falsa","432");
    private function executeQuery($arrType = null, $arrParam = null)
    {   
        try{ $q = new Query($this->connection); }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
        
        return $q->execute(array($this->query),$arrType,$arrParam);
    }

	private function setIdEstadoReclamo($id_estado_reclamo)
    {
        try { $this->id_estado_reclamo = $this->validator->validarVariableNumerica($id_estado_reclamo);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    private function setDescripcion($descripcion)
    {
        try { $this->descripcion = $this->validator->validarVariableString($descripcion);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }

}
?>