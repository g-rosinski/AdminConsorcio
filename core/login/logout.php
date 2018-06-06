<?php
    session_start();
    session_cache_expire();
    session_destroy();
    echo "Cerrando sesion...";
    header('refresh: 1; url=./index.php');
?>