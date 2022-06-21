<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Estado.php");
    $estado = new Estado();

    /* opciones del controlador */
    switch($_GET["op"]){  
        /*  para poder guardar y editar el registro */
        case "guardaryeditar":
            if(empty($_POST["estoc_id"])){
                $estado->insert_estado($_POST["tip_id"],$_POST["estoc_nom1"],$_POST["estoc_nom2"],$_POST["estoc_campo"]);
            } else {
                $estado->update_estado($_POST["estoc_id"],$_POST["tip_id"],$_POST["estoc_nom1"],$_POST["estoc_nom2"],$_POST["estoc_campo"]);
            }
            break;
        /* manejo de json para poder listar en el datatable, formato de json segun documentacion */
        case "listar":
            $datos=$estado->get_estado();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tip_nom"];
                $sub_array[] = $row["estoc_nom1"];
                $sub_array[] = $row["estoc_nom2"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["estoc_id"].');"  id="'.$row["estoc_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["estoc_id"].');"  id="'.$row["estoc_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
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
            $estado->delete_estado($_POST["estoc_id"]);
            break;
        /* se arma json segun el resultado del id enviado */
        case "mostrar";
            $datos=$estado->get_estado_x_id($_POST["estoc_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["tip_id"] = $row["tip_id"];
                    $output["estoc_id"] = $row["estoc_id"];
                    $output["estoc_nom1"] = $row["estoc_nom1"];
                    $output["estoc_nom2"] = $row["estoc_nom2"];
                    $output["estoc_campo"] = $row["estoc_campo"];
                }
                echo json_encode($output);
            }
            break;
        /* generacion de combo */
        case "combo":
            $datos = $estado->get_estado();
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['estoc_id']."'>".$row['estoc_nom1']." - ".$row['estoc_nom2']."</option>";
                }
                echo $html;
            }
            break;

        case "combotipo":
            $datos = $estado->get_estado_x_tipo($_POST["tip_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['estoc_id']."'>".$row['estoc_nom1']." - ".$row['estoc_nom2']."</option>";
                }
                echo $html;
            }
            break;

        case "combo_select":
            $datos = $estado->get_estado_x_tipo($_POST["tip_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    if($row['estoc_id']==$_POST["estoc_id"]){
                        $html.= "<option value='".$row['estoc_id']."' selected>".$row['estoc_nom1']." - ".$row['estoc_nom2']."</option>";
                    }else{
                        $html.= "<option value='".$row['estoc_id']."'>".$row['estoc_nom1']." - ".$row['estoc_nom2']."</option>";
                    }
                }
                echo $html;
            }
            break;

    }
?>