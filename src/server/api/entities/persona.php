<?php
class Persona
{
    private $connection;
    private $tabla = "persona";

    public $user;
    public $id_persona;
    public $nombre;
    public $apellido;
    public $dni;
    public $email;
    public $cuil;
    public $razon_social;
    public $inquilino_de;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function agregar()
    {
        $query = "INSERT INTO persona (apellido, nombre, dni, email) VALUES (('$this->apellido'),('$this->nombre'),('$this->dni'),('$this->email'))";
        return $this->connection->ejecutar($query);
    }
}
