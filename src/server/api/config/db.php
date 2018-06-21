<?php
class DB
{
    public $host;
    public $username;
    public $password;
    public $database;
    private $connection;

    public function __construct()
    {
        $this->host = "127.0.0.1";
        $this->username = "root";
        $this->password = "";
        $this->database = "iani";

        $this->getConnection();
    }

    public function getConnection()
    {
        $this->connection = null;

        try {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
            if ($this->connection->connect_error) {
                throw new Exception($this->connection->connect_error);
            }
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }

        return $this->connection;
    }

    public function ejecutar($query)
    {
        try {
            $respuesta = $this->connection->query($query);
            if ($this->connection->error) {
                throw new Exception($this->connection->error);
            }
            return $respuesta;
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo "<br>".json_encode(array("success" => false, "message" => $e->getMessage()));
            throw $e;
        }
    }

    public function obtenerUltimoInsertId()
    {
        return $this->connection->insert_id;
    }

    public function ejecutarSeeders()
    {
        $directorio = './../scripts/';
        try {
            foreach (scandir($directorio) as $file) {
                if (strpos($file, '.sql') !== false) {
                    $stataments = file_get_contents($directorio . $file);
                    $stataments = explode(";", $stataments);
                    $stataments = preg_replace("/\s/", ' ', $stataments);
                    echo "Ejecutando  ".$file;
                    foreach ($stataments as $query) {
                        if (trim($query) != '') {
                            $this->ejecutar($query);
                        }
                    }
                    echo "   ....Ok<br>";
                }
            }
        } catch (Exception $e) {
            return 'Hubo un error en alguno de los scripts';
        }

        return 'Todos los archivos se ejecutaron corrctamente';
    }
}
