<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Opcionescotizacion.php");
    $opcionescotizacion = new Opcionescotizacion();

    /* opciones del controlador */
    switch($_GET["op"]){

        /* generacion de combo */
        case "combo":
            $datos = $opcionescotizacion->get_opcioncotizacion($_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['OpcionesCotizacion_id']."'>".$row['OpcionesCotizacion_nom']."</option>";
                }
                echo $html;
            }
            break;

        case "combo_select":
            $datos = $opcionescotizacion->get_opcioncotizacion($_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    if($row['cntcon_id']==$_POST["TiempoEsperado_id"]){
                        $html.= "<option value='".$row['OpcionesCotizacion_id']."' selected>".$row['OpcionesCotizacion_nom']."</option>";
                    }else{
                        $html.= "<option value='".$row['OpcionesCotizacion_id']."'>".$row['OpcionesCotizacion_nom']."</option>";
                    }
                }
                echo $html;
            }
            break;

    }
?>