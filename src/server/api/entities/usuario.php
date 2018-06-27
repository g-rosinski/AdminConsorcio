<?php
class Usuario
{
    private $connection;
    private $tabla = "usuario";

    public $user;
    public $pass;
    public $estado;
    public $id_persona;
    public $id_rol;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function marcarComoActivo()
    {
        $query = "UPDATE usuario set estado = 'ACTIVO' WHERE (user) = ('$this->id')";
        return $this->connection->ejecutar($query);
    }

    // TODO: Esta funcion no me devuelve el nombre, apellido, etc, NI SIQUIERA EL CONSORCIO!!!
    public function obtenerTodosLosUsuariosInactivos()
    {
        $query = "SELECT * FROM " . $this->tabla . " WHERE (estado) = ('INACTIVO')";
        return $this->connection->ejecutar($query);
    }

    public function agregarUsuario()
    {
        $query = "INSERT INTO usuario (user, pass, estado) VALUES (('$this->user'),('$this->pass'),('$this->estado'))";
        $this->connection->ejecutar($query);
        $this->agregarRelacionRolUsuario();
    }

    public function agregarRelacionRolUsuario()
    {
        $query = "INSERT INTO rolusuario (id_rol, user) VALUES (('$this->id_rol'),('$this->user'))";
        return $this->connection->ejecutar($query);
    }

    public function obtenerPorUser($user)
    {
        $query = "SELECT * FROM usuario WHERE (user) = ('$user')";
        return $this->connection->ejecutar($query);
    }

    public function obtenerUsuarioTotalPorEstado()
    {
        $query = $this->obtenerBaseQuerySelectFullUsuario();
        $query = $query . " WHERE U.estado = ('$this->estado')";
        return $this->connection->ejecutar($query);
    }

    public function obtenerFullUsuario()
    {
        $query = $this->obtenerBaseQuerySelectFullUsuario();
        $query = $query . " WHERE U.user = ('$this->user')";
        return $this->connection->ejecutar($query);
    }

    private function obtenerBaseQuerySelectFullUsuario()
    {
        $query = "
        SELECT
            U.user,
            CONCAT(UN.piso, UN.departamento) AS unidad,
            R.descripcion AS rol,
            R.id_rol as id_rol,
            C.nombre AS consorcio,
            CONCAT(PE.nombre, ' ', PE.apellido) AS persona
        FROM
            usuario AS U
        LEFT JOIN propietariounidad AS PU
        ON
            U.user = PU.user
        LEFT JOIN unidad AS UN
        ON
            PU.id_unidad = UN.id_unidad
        LEFT JOIN consorcio AS C
        ON
            C.id_consorcio = UN.id_consorcio
        LEFT JOIN persona AS PE
        ON
            PE.user = U.user
        INNER JOIN rolusuario AS RU
        ON
            RU.user = U.user
        INNER JOIN rol AS R
        ON
            R.id_rol = RU.id_rol
        ";
        return $query;
    }
}
