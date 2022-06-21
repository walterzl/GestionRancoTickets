<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Duracion.php");
    $duracion = new Duracion();

    /* opciones del controlador */
    switch($_GET["op"]){

        /* generacion de combo */
        case "combo":
            $datos = $duracion->get_duracion($_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['dura_id']."'>".$row['dura_nom']."</option>";
                }
                echo $html;
            }
            break;

    }
?>