<?php
    require_once("config/conexion.php");
    if(isset($_POST["enviar"]) and $_POST["enviar"]=="si"){
        require_once("models/Usuario.php");
        $usuario = new Usuario();
        $usuario->login2();
    }
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Ranco::Acceso</title>

	<link href="public/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="public/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="public/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="public/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="public/img/favicon.png" rel="icon" type="image/png">
	<link href="public/img/favicon.ico" rel="shortcut icon">

    <link rel="stylesheet" href="public/css/separate/pages/login.min.css?v=2">
    <link rel="stylesheet" href="public/css/lib/font-awesome/font-awesome.min.css?v=2">
    <link rel="stylesheet" href="public/css/lib/bootstrap/bootstrap.min.css?v=2">
    <link rel="stylesheet" href="public/css/main.css?v=2">
</head>
<body>
    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">

                <form class="sign-box" action="" method="post" id="login_form">
                    <div class="sign-avatar">
                        <img src="public/logo-ranc.png" alt="" id="logoranco">
                    </div>

                    <input type="hidden" id="rol_id" name="rol_id" value="1">

                    <div class="sign-avatar">
                        <img src="public/1.jpg" alt="" id="imgtipo">
                    </div>
                    </br>

                    <?php
                        if (isset($_GET["s"])){ //si salta el msg de error M
                            switch($_GET["s"]){
                                case "1"; //si es m=1 los datos son incorrectos
                                    ?>
                                        <header class="sign-title">Acceso Usuarios - Solicitudes TI - TEST</header>
                                        <input type="hidden" id="sis_id" name="sis_id" value="1">
                                    <?php
                                break;

                                case "2";  //si m=2 los campos estan vacios o no llenados por el usuario
                                    ?>
                                        <header class="sign-title">Acceso Usuarios - Solicitudes Mantencion - TEST</header>
                                        <input type="hidden" id="sis_id" name="sis_id" value="2">
                                    <?php
                                break;

                                case "3";  //si m=3 los campos estan vacios o no llenados por el usuario
                                    ?>
                                        <header class="sign-title">Acceso Usuarios - Solicitudes de Compra - TEST</header>
                                        <input type="hidden" id="sis_id" name="sis_id" value="3">
                                    <?php
                                break;
                            }
                        }
                    ?>

                    <?php
                        if (isset($_GET["m"])){
                            switch($_GET["m"]){
                                case "1";
                                    ?>
                                        <div class="alert alert-warning alert-icon alert-close alert-dismissible fade in" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <i class="font-icon font-icon-warning"></i>
                                            El Usuario y/o Contraseña son incorrectos.
                                        </div>
                                    <?php
                                break;

                                case "2";
                                    ?>
                                        <div class="alert alert-warning alert-icon alert-close alert-dismissible fade in" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <i class="font-icon font-icon-warning"></i>
                                            Los campos estan vacios.
                                        </div>
                                    <?php
                                break;
                            }
                        }
                    ?>

                    <div class="form-group">
                        <input type="text" id="usu_correo" name="usu_correo" class="form-control" placeholder="E-Mail"/>
                    </div>

                    <div class="form-group">
                        <input type="password" id="usu_pass" name="usu_pass" class="form-control" placeholder="Password"/>
                    </div>

                    <input type="hidden" name="enviar" class="form-control" value="si">
                    <button type="submit" class="btn btn-rounded">Acceder</button>
                </form>
            </div>
        </div>
    </div>

<script src="public/js/lib/jquery/jquery.min.js"></script>
<script src="public/js/lib/tether/tether.min.js"></script>
<script src="public/js/lib/bootstrap/bootstrap.min.js"></script>
<script src="public/js/plugins.js"></script>
<script type="text/javascript" src="public/js/lib/match-height/jquery.matchHeight.min.js"></script>
<script>
    $(function() {
        $('.page-center').matchHeight({
            target: $('html')
        });

        $(window).resize(function(){
            setTimeout(function(){
                $('.page-center').matchHeight({ remove: true });
                $('.page-center').matchHeight({
                    target: $('html')
                });
            },100);
        });
    });
</script>
<script src="public/js/app.js"></script>

<script type="text/javascript" src="index.js"></script>

</body>
</html>