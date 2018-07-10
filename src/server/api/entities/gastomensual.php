<?php
require_once './../../utils/autoload.php';

class GastoMensual
{
	private $connection;
    private $validator;    
    private $query;
    private $tabla = "gastomensual";
    /* Campos de la tabla */
    private $idGastoMensual;
    private $periodo;
    private $fechaInicio;
    private $fechaLiquidacion;
    private $total;
    private $id_consorcio;
	
	public function __construct($connection)
    {
        $this->connection = $connection;
        try{ $this->validator = new Validator; }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
    }


    /**************************** */
    /*     FUNCIONES PUBLICAS     */
    /**************************** */
    public function traerIdGastoMensual($consorcio)
    {
    	$this->setIdConsorcio($consorcio);
    	return $this->obtenerIdGastoMensualEnCurso();
    }
    public function actualizarTotalGastoMensual($idGastoMensual, $importe)
    {
        $this->setIdGastoMensual($idGastoMensual);
        $total = $this->obtenerTotal($this->idGastoMensual) + $importe;
        $this->setTotal($total);
        return $this->actualizarTotal();
    }
    public function liquidarGastoMensualPorConsorcio($consorcios = array()){
        $this->setFechaInicio($this->setDate());
        $this->setFechaLiquidacion($this->setDate());
        $this->setPeriodo($this->obtenerPeriodo());
        $this->setTotal(0);
        foreach($consorcios as $id_consorcio){
            $this->setIdConsorcio($id_consorcio);
            $this->setIdGastoMensual($this->obtenerIdGastoMensualEnCurso());
            $this->liquidarPeriodoPorConsorcio();
            $this->nuevoPeriodoPorConsorcio();
        }
    }
    public function obtenerTotalDelMes($id_consorcio){
        $this->setIdConsorcio($id_consorcio);
        $this->setIdGastoMensual($this->obtenerIdGastoMensualEnCurso()); 
        return $this->obtenerTotal($this->idGastoMensual);
    }
    /**************************** */
    /*     FUNCIONES PRIVADAS     */
    /**************************** */
    private function obtenerIdGastoMensualEnCurso()
    {
        $this->query = "SELECT MAX(id_gasto_mensual) id FROM ".$this->tabla
                       ." WHERE id_consorcio = ?";
        $arrType = array ("i");
        $arrParam = array ($this->id_consorcio);
        $gastomensual = $this->executeQuery($arrType,$arrParam)->fetch_assoc();
        return $gastomensual['id'];
    }
    private function actualizarTotal()
    {
        $this->query = "UPDATE ".$this->tabla." SET total = ?  WHERE id_gasto_mensual = ?";
        $arrType = array("i","i");
        $arrParam= array(
            $this->total,
            $this->idGastoMensual
        );
        return $this->executeQuery($arrType,$arrParam);
    }
    private function obtenerTotal($idGastoMensual){
        $this->query = "SELECT total FROM ". $this->tabla
                       ." WHERE id_gasto_mensual = ?";
        $arrType = array ("i");
        $arrParam = array ($idGastoMensual);
        $gastomensual = $this->executeQuery($arrType,$arrParam)->fetch_assoc();
        return $gastomensual['total'];
    }
    private function liquidarPeriodoPorConsorcio(){
        $this->query = "UPDATE ".$this->tabla." SET fechaLiquidacion = ?  WHERE id_consorcio = ?"
                        ." AND fechaLiquidacion IS NULL";
        $arrType = array("s","i");
        $arrParam= array(
            $this->fechaLiquidacion,
            $this->id_consorcio
        );
        return $this->executeQuery($arrType,$arrParam);
    }
    private function nuevoPeriodoPorConsorcio(){
        $this->query = "INSERT INTO ".$this->tabla." (periodo,fechaInicio,total,id_consorcio)"
                        ." VALUES (?, ?, ?, ?)";
        $arrType = array("s","s","i","i");
        $arrParam= array(
            $this->periodo,
            $this->fechaInicio,
            $this->total,
            $this->id_consorcio
        );
        return $this->executeQuery($arrType,$arrParam);
    }

    private function obtenerPeriodo(){
        date_default_timezone_get('America/Argentina/Buenos_Aires');
        return date("Y - m");
    }
    private function setDate()
    {
        date_default_timezone_get('America/Argentina/Buenos_Aires');
        return date("Y-m-d");        
    }

    private function setIdGastoMensual($idGastoMensual)
    {
        try { $this->idGastoMensual = $this->validator->validarVariableNumerica($idGastoMensual);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}

    }
    private function setPeriodo($periodo)
    {
        try { $this->periodo = $this->validator->validarVariableString($periodo);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    } 
    private function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio=$fechaInicio;
    }
    private function setFechaLiquidacion($fechaLiquidacion)
    {
        $this->fechaLiquidacion=$fechaLiquidacion;
    }
    private function setTotal($total)
    {
        try { $this->total = $this->validator->validarVariableNumerica($total);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }    
    private function setIdConsorcio($id_consorcio)
    {
        try { $this->id_consorcio = $this->validator->validarVariableNumerica($id_consorcio);} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }
    
    // Ejemplo: Si en mi query necesito pasarle el valor 14, "Calle Falsa", "432"
    // $arrType = array("i","s","s") /* int string string */
    // $arrParam = array(14,"Calle Falsa","432");
    private function executeQuery($arrType = null, $arrParam = null)
    {   
        try{ $q = new Query($this->connection); }
        catch(Exception $e){echo "Msj:".$e->getMessage();}
        
        return $q->execute(array($this->query),$arrType,$arrParam);
    }
}
