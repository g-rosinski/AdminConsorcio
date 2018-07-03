<?php
require_once './../../utils/autoload.php';

class Proveedor
{
    private $connection;
    private $validator;
    private $query;
    private $tabla = "proveedor";
    /* Campos de la tabla */
    private $id_proveedor;
    private $razon_social;
    private $telefono;
    private $email;
    private $calle;
    private $altura;
    private $id_barrio;
    private $id_rubro_proveedor;

    public function __construct($connection)
    {
        $this->connection = $connection;
        try { $this->validator = new Validator;} catch (Exception $e) {echo "Msj:" . $e->getMessage();}
    }

    public function obtenerTodosLosProveedores(){
        return $this->consultarTodosLosProveedores();
    }

    private function consultarTodosLosProveedores(){
        
        $this->query = "SELECT * FROM $this->tabla";
        return $this->executeQuery();
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

    public function getId_proveedor()
    {
        return $this->id_proveedor;
    }

    public function setId_proveedor($id_proveedor)
    {
        $this->id_proveedor = $id_proveedor;

        return $this;
    }

    public function getRazon_social()
    {
        return $this->razon_social;
    }

    public function setRazon_social($razon_social)
    {
        $this->razon_social = $razon_social;

        return $this;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getCalle()
    {
        return $this->calle;
    }

    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    public function getAltura()
    {
        return $this->altura;
    }

    public function setAltura($altura)
    {
        $this->altura = $altura;

        return $this;
    }

    public function getId_barrio()
    {
        return $this->id_barrio;
    }

    public function setId_barrio($id_barrio)
    {
        $this->id_barrio = $id_barrio;

        return $this;
    }

    public function getId_rubro_proveedor()
    {
        return $this->id_rubro_proveedor;
    }

    public function setId_rubro_proveedor($id_rubro_proveedor)
    {
        $this->id_rubro_proveedor = $id_rubro_proveedor;

        return $this;
    }
}
