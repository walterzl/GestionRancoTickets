<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Plancontable.php");
    $plancontable = new Plancontable();

    /* opciones del controlador */
    switch($_GET["op"]){

        /* generacion de combo */
        case "combo":
            $datos = $plancontable->get_plancontable($_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['cntcon_id']."'>".$row['cntcon_nom']."-".$row['cntcon_nom2']."</option>";
                }
                echo $html;
            }
            break;

    }
?>