<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrarse</title>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <script src="./js/jquery-3.3.1.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/registro.js"></script>
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
            <form id="logForm" class="form-group" action="registro.php" method="POST" enctype="application/x-www-form-urlencoded">
                <input class="form-control" id="user" name="user" type="text" placeholder="Nombre">
                <small id="validUser" style="color:red">Debe completar este campo.</small>
                <br>
                <input class="form-control" id="pass" name="pass" type="password"  placeholder="Contrase&ntilde;a">
                <small id="validPass" style="color:red">Debe completar este campo.</small>
                <br>
                <input class="form-control" id="pass2" name="pass2" type="password"  placeholder="Repetir contrase&ntilde;a">
                <small id="validPass2" style="color:red">Las contrase&ntilde;as no coinciden.</small>
                <small id="validPassEqual" style="color:red">Las contrase&ntilde;as no coinciden.</small>
                
                <div class="text-center">
                    <br>
                    <button class="btn" id="btnRegistro">Registrarse</button>
                    <a href="./index.php" class="btn btn-info">Volver</a>
                </div>
                <div class="text-center">
                </div>
            </form>
            </article>
        </div>
    </div>
    </div>
</body>
</html>

