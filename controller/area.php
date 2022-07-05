<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/area.php");
    $area = new area();

    /* opciones del controlador */
    switch($_GET["op"]){
        /*  para poder guardar y editar el registro */
        case "guardaryeditar":
            if(empty($_POST["area_id"])){
                $area->insert_area($_POST["area_nom"]);
            }
            else {
                $area->update_area($_POST["area_id"],$_POST["area_nom"]);
            }
            break;
        /* manejo de json para poder listar en el datatable, formato de json segun documentacion */
        case "listar":
            $datos=$area->get_area($_POST["sis_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["area_nom"];

                $sub_array[] = '<button type="button" onClick="editar('.$row["area_id"].');"  id="'.$row["area_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["area_id"].');"  id="'.$row["area_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
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
            $area->delete_area($_POST["area_id"]);
            break;
        /* se arma json segun el resultado del id enviado */
        case "mostrar";
            $datos=$area->get_area_x_id($_POST["area_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["area_id"] = $row["area_id"];
                    $output["area_nom"] = $row["area_nom"];
                }
                echo json_encode($output);
            }
            break;
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