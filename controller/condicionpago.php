<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Condicionpago.php");
    $condicionpago = new Condicionpago();

    /* opciones del controlador */
    switch($_GET["op"]){

        /* generacion de combo */
        case "combo":
            $datos = $condicionpago->get_condicionpago($_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['condp_id']."'>".$row['condp_nom']."</option>";
                }
                echo $html;
            }
            break;

    }
?>