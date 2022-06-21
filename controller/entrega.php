<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Entrega.php");
    $entrega = new Entrega();

    /* opciones del controlador */
    switch($_GET["op"]){

        /* generacion de combo */
        case "combo":
            $datos = $entrega->get_entrega($_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['ent_id']."'>".$row['ent_nom']."</option>";
                }
                echo $html;
            }
            break;

    }
?>