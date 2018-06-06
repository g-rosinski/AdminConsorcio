<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <script src="./js/jquery-3.3.1.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</head>
<body>
    <main>
        <div class="container">
            <div class="row">
                <div class="card col-lg-12">
                <?php 
                    session_start();
                    if (isset($_COOKIE['user']) && $_COOKIE['user'] != null){
                        echo "<h1>Bienvenido</h1>";
                        echo "<h3 class='text-center'>";
                        echo $_COOKIE['user'];
                        echo "</h3><br>";
                        echo "<form class='form-group' action='logout.php' method='POST' enctype='application/x-www-form-urlencoded'>";
                        echo "<div class='text-center'><button class='btn btn-danger'>Cerrar Sesion</div>";
                    }else{
                        echo "Error, usuario o contraseña incorrecto.";
                        header('refresh: 1; url=./login.php');
                    }
                ?>
                </div>
            </div>
        </div>
    </main>
</body>
