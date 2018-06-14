<?php

include_once './../config/validador.php';

class reclamo
{
    private $connection,
    private $table = "reclamo";

    private $id_reclamo;
    private $nro_reclamo;
    private $titulo;
    private $mensaje;
    private $fecha;
    private $hora;
    private $user;
    private $id_motivo_reclamo;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function crearReclamo( = null){
        $this->setTitulo;
        $this->setMensaje;
        $this->setMotivoReclamo;

        $this->insertReclamo();
    }


    private funtion insertReclamo(){
        $query = "INSERT INTO " 
        . $this->tabla 
        . " (titulo, mensaje, id_motivoReclamo)"
        . " VALUES (('$this->titulo'),('$this->mensaje'),($this->id_motivo_reclamo))";
        return $this->connection->ejecutar($query);
    }

    private function setTitulo(){



    }


    private function setMensaje(){


        
    }

    private function setMotivoReclamo(){


        
    }

    private function set(){


        
    }

    private function set(){


        
    }






}

















>