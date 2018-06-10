<?php
class Usuario
{
    private $connection;
    private $tabla = "usuario";

    public $user;
    public $pass;
    public $estado;
    public $id_persona;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    // TODO: Esta funcion no me devuelve el nombre, apellido, etc, NI SIQUIERA EL CONSORCIO!!!
    public function obtenerTodosLosUsuariosInactivos()
    {
        $query = "SELECT * FROM " . $this->tabla . " WHERE (estado) = ('INACTIVO')";
        return $this->connection->ejecutar($query);
    }

    public function agregarUsuario()
    {
        $query = "INSERT INTO usuario (user, pass, id_persona, estado) VALUES (('$this->user'),('$this->pass'),($this->id),('$this->estado'))";
        return $this->connection->ejecutar($query);
    }
}
