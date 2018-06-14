<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once './../config/db.php';

echo ejecutarSeeders();

// http://localhost/server/api/actions/seeders.php
function ejecutarSeeders()
{
    $db = new DB();

    return $db->ejecutarSeeders();
}
