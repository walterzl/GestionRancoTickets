<?php
require_once("config/conexion.php");
$cone = new conectar();
?>
<!DOCTYPE html>
<html>

<head lang="es">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Ranco::Acceso</title>

    <link href="img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
    <link href="img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
    <link href="img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
    <link href="img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
    <link href="img/favicon.png" rel="icon" type="image/png">
    <link href="img/favicon.ico" rel="shortcut icon">


    <link rel="stylesheet" href="public/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="public/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/main.css">
</head>

<body>
    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">

                <div class="sign-box" id="login_form">


                    <?php
                    if (isset($_GET["s"])) { //si salta el msg de error M
                        switch ($_GET["s"]) {
                            case "1"; //Login TI
                    ?>
                                <div class="site-logo text-center">
                                    <img src="public/logoweb.png" alt="Logo Ranco" id="logoranco">
                                </div>
                                </br>

                                <input type="hidden" id="rol_id" name="rol_id" value="1">
                                <input type="hidden" id="txtruta" name="txtruta" value="<?php echo $varruta = $cone->ruta(); ?>">

                                <div class="sign-avatar">
                                    <img src="public/it_4.png" alt="" id="imgtipo">
                                </div>
                                </br>

                                <header class="sign-title" HtmlEncode="false"><b>Acceso Usuarios</b> </br> Solicitudes TI</header>
                                <input type="hidden" id="sis_id" name="sis_id" value="1">
                            <?php
                                break;

                            case "2";  //Login MANTENCION
                            ?>
                                <div class="site-logo text-center">
                                    <img src="public/logoweb.png" alt="" id="logoranco">
                                </div>
                                </br>

                                <input type="hidden" id="rol_id" name="rol_id" value="1">
                                <input type="hidden" id="txtruta" name="txtruta" value="<?php echo $varruta = $cone->ruta(); ?>">

                                <div class="sign-avatar">
                                    <img src="public/1995450.png" alt="" id="imgtipo">
                                </div>
                                </br>

                                <header class="sign-title" HtmlEncode="false"><b>Acceso Usuarios</b> </br> Solicitudes Mantención</header>
                                <input type="hidden" id="sis_id" name="sis_id" value="2">
                            <?php
                                break;

                            case "3";  //Login OrdenCOMPRA
                            ?>
                                <div class="site-logo text-center">
                                    <img src="public/logoweb.png" alt="" id="logoranco">
                                </div>
                                </br>

                                <input type="hidden" id="rol_id" name="rol_id" value="1">
                                <input type="hidden" id="txtruta" name="txtruta" value="<?php echo $varruta = $cone->ruta(); ?>">

                                <div class="sign-avatar">
                                    <img src="public/orden-compra.png" alt="" id="imgtipo">
                                </div>
                                </br>

                                <header class="sign-title" HtmlEncode="false"><b>Acceso Usuarios</b> </br> Solicitudes Orden Compra</header>

                                <input type="hidden" id="sis_id" name="sis_id" value="3">
                            <?php
                                break;

                            default: //SI no es 1,2 o 3 entonces envia 404-login error
                                header("Location:" . Conectar::ruta() . "404-login.php");
                                break;
                        }
                    }
                    ?>

                    <?php
                    if (isset($_GET["m"])) { //si salta el msg de error M
                        switch ($_GET["m"]) {
                            case "1"; //si es m=1 los datos son incorrectos
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

                            case "2";  //si m=2 los campos estan vacios o no llenados por el usuario
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

                            case "3";  //si m=3 los campos estan vacios o no llenados por el usuario
                            ?>
                                <header class="sign-title">Acceso Usuarios - Solicitudes de Compra</header>
                                <input type="hidden" id="sis_id" name="sis_id" value="3">
                    <?php
                                break;
                        }
                    }
                    ?>

                    <input type="hidden" name="enviar" class="form-control" value="si"> <!-- nombre del boton acceder que toma la funcion login -->
                    <button type="submit" class="btn btn-rounded" onclick="login()">Acceder</button>
                    </form>

                </div>

            </div>


            <div class="footer-copyright text-center py-3">
                <br />
                <br /><br />
                <br />
                <style>
                    ul.navega li {
                        display: inline;
                    }
                </style>

                <!--  Hrefs PRoduccion 
                <ul class="navega">
                    <li><a href="https://ticket.ranco.cl/GestionRanco/?s=2">Solicitudes Mantencion</a></li>
                    <li>/</li>
                    <li><a href="https://ticket.ranco.cl/GestionRanco/?s=1">Solicitudes TI</a></li>
                    <li>/</li>
                    <li><a href="https://ticket.ranco.cl/GestionRanco/?s=3">Solicitudes Orden de Compra</a></li>

                </ul> 
                 -->


                <!-- Hrefs Testing -->
                <ul class="navega">
                    <li><a href="https://testing.ticket.ranco.cl/GestionRanco/?s=2">Solicitudes Mantencion</a></li>
                    <li>/</li>
                    <li><a href="https://testing.ticket.ranco.cl/GestionRanco/?s=1">Solicitudes TI</a></li>
                    <li>/</li>
                    <li><a href="https://testing.ticket.ranco.cl/GestionRanco/?s=3">Solicitudes Orden de Compra</a></li>

                </ul>

                

                <br />
                <br />
                <strong>SISOR 🍒 </strong> by
                <a href=https://ranco.cl> Ranco Desarrollos © </a>

                <br />
                Para más información enviar email a
                <a href=mailto:DesarrolloTI@rancocherries.cl?Subject=SISOR%20Ranco>
                    DesarrolloTI@rancocherries.cl
                </a>



            </div>
        </div>



        <script src="public/js/lib/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="https://alcdn.msauth.net/lib/1.4.0/js/msal.js"></script>
        <script type="text/javascript">
            if (typeof Msal === "undefined")
                document.write(
                    unescape(
                        "%3Cscript src='https://alcdn.msftauth.net/lib/1.4.0/js/msal.js' type='text/javascript' %3E%3C/script%3E"
                    )
                );
        </script>
        <script src="public/Msal/msal.js" type="text/javascript"></script>
        <script src="public/js/lib/tether/tether.min.js"></script>
        <script src="public/js/lib/bootstrap/bootstrap.min.js"></script>
        <script src="public/js/plugins.js"></script>
        <script src="public/js/lib/match-height/jquery.matchHeight.min.js" type="text/javascript"></script>
        <script>
            $(function() {
                $('.page-center').matchHeight({
                    target: $('html')
                });

                $(window).resize(function() {
                    setTimeout(function() {
                        $('.page-center').matchHeight({
                            remove: true
                        });
                        $('.page-center').matchHeight({
                            target: $('html')
                        });
                    }, 100);
                });
            });
        </script>
        <script src="public/js/app.js"></script>

        <script type="text/javascript" src="index.js"></script>



</body>



</html>