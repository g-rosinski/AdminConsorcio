<?php

require_once './../../utils/autoload.php';
class Expensa
{
    private $connection;
    private $tabla = "expensa";

    public $id_expensa;
    public $cuota_expensa;
    public $cuoata_extraordinaria;
    public $cuota_mora;
    public $cuota_mes;
    public $cuota_vencimiento;
    public $cuota_estado;
    public $id_ctacte;
    public $id_gasto_mensual;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

}
?>