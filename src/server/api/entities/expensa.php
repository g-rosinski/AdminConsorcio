<?php

require_once './../../utils/autoload.php';
class Expensa
{
    private $connection;
    private $tabla = "expensa";

    public $idExpensa;
    public $cuotaExpensa;
    public $cuoataExtraordinaria;
    public $cuotaMora;
    public $cuotaMes;
    public $cuotaVencimiento;
    public $cuotaEstado;
    public $id_ctacte;
    public $id_gasto_mensual;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

}
?>