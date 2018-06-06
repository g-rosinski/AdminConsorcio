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
    <script src="./js/funciones.js"></script>
</head>
<body>
<main>
<div class="container">
    <div class="row">
        <div class="card col-lg-12">
            <article class="card-body">
            <h1 style="text-align:center">Login</h1>
            <h5>Inicie sesion para continuar: </h5>
            <br>
            <form id="logForm" class="form-group" action="login.php" method="POST" enctype="application/x-www-form-urlencoded">
                <input class="form-control" id="user" name="user" type="text" placeholder="Nombre">
                <br>
                <input class="form-control" id="pass" name="pass" type="password"  placeholder="Contrase&ntilde;a">
                <br>
                <div class="text-center">
                    <button class="btn btn-primary" id="btnSubmit">Iniciar Sesion</button>
                </div>
                <div class="text-center">
                    <br>
                    <a href="./signup.php" class="btn btn-danger">Registrarte</a>
                </div>
            </form>
            </article>
        </div>
    </div>
    </div>
</body>
</html>

