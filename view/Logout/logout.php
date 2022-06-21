<?php
    require_once("../../config/conexion.php");

    if ($_SESSION["sis_id"]==1){
        header("Location:".Conectar::ruta()."?s=1");
    }else if ($_SESSION["sis_id"]==2){
        header("Location:".Conectar::ruta()."?s=2");
    }else{
        header("Location:".Conectar::ruta()."?s=3");
    }

    session_start();
    session_unset();
    session_destroy();

    echo '<script type="text/javascript" src="../../Msal/msal.js">','logout();','</script>';
    exit();
?>