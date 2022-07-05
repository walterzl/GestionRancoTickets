<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/SubArea.php");
    $subarea = new SubArea();
    /* opciones del controlador */
    switch($_GET["op"]){
        /*  para poder guardar y editar el registro */
        case "guardaryeditar":
            if(empty($_POST["suba_id"])){
                $subarea->insert_subarea($_POST["area_id"],$_POST["suba_nom"]);
            }
            else {
                $subarea->update_subarea($_POST["suba_id"],$_POST["area_id"],$_POST["suba_nom"]);
            }
        break;
        /* manejo de json para poder listar en el datatable, formato de json segun documentacion */
        case "listar":
            $datos=$subarea->get_subarea($_POST["sis_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["area_nom"];
                $sub_array[] = $row["suba_nom"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["suba_id"].');"  id="'.$row["suba_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["suba_id"].');"  id="'.$row["suba_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;
        /* eliminar un registro */
        case "eliminar":
            $subarea->delete_subarea($_POST["suba_id"]);
        break;
        /* se arma json segun el resultado del id enviado */
        case "mostrar";
            $datos=$subarea->get_subarea_x_id($_POST["suba_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["suba_id"] = $row["suba_id"];
                    $output["area_nom"] = $row["area_nom"];
                    $output["area_id"] = $row["area_id"];
                    $output["suba_nom"] = $row["suba_nom"];
                }
                echo json_encode($output);
            }
        break;
        /* generacion de combo */
        case "combo":
            $datos = $subarea->get_subarea_x_area($_POST["area_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['suba_id']."'>".$row['suba_nom']."</option>";
                }
                echo $html;
            }
        break;
        /* generacion de combo marcado con la opcion que viene de la BD */
        case "combo_select":
            $datos = $subarea->get_subarea_x_area($_POST["area_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    if($row['suba_id']==$_POST["suba_id"]){
                        $html.= "<option value='".$row['suba_id']."' selected>".$row['suba_nom']."</option>";
                    }else{
                        $html.= "<option value='".$row['suba_id']."'>".$row['suba_nom']."</option>";
                    }
                }
                echo $html;
            }
        break;
    }
?>