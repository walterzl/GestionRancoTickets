<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/area.php");
    $area = new area();

    /* opciones del controlador */
    switch($_GET["op"]){
        
        /* generacion de combo */
        case "combo":
            $datos = $area->get_area($_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccione'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['area_id']."'>".$row['area_nom']."</option>";
                }
                echo $html;
            }
            break;
        /* generacion de combo marcado con la opcion que viene de la BD */
        case "combo_select":
            $datos = $area->get_area($_POST["sis_id"],$_POST["area_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccione'></option>";
                foreach($datos as $row)
                {
                    if($row['area_id']==$_POST["area_id"]){
                        $html.= "<option value='".$row['area_id']."' selected>".$row['area_nom']."</option>";
                    }else{
                        $html.= "<option value='".$row['area_id']."'>".$row['area_nom']."</option>";
                    }
                }
                echo $html;
            }
            break;
    }
?>