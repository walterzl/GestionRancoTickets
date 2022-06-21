<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Grupo.php");
    $grupo = new Grupo();
    /* opciones del controlador */  
    switch($_GET["op"]){
        /*  para poder guardar y editar el registro */
        case "guardaryeditar":
            if(empty($_POST["grupo_id"])){
                $grupo->insert_grupo($_POST["grupo_nom"]);
            }
            else {
                $grupo->update_grupo($_POST["grupo_id"],$_POST["grupo_nom"]);
            }
        break;
        /* manejo de json para poder listar en el datatable, formato de json segun documentacion */
        case "listar":
            $datos=$grupo->get_grupo($_POST["sis_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["grupo_nom"];

                $sub_array[] = '<button type="button" onClick="editar('.$row["grupo_id"].');"  id="'.$row["grupo_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["grupo_id"].');"  id="'.$row["grupo_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
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
            $grupo->delete_grupo($_POST["grupo_id"]);
        break;
        /* se arma json segun el resultado del id enviado */
        case "mostrar";
            $datos=$grupo->get_grupo_x_id($_POST["grupo_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["grupo_id"] = $row["grupo_id"];
                    $output["grupo_nom"] = $row["grupo_nom"];
                }
                echo json_encode($output);
            }
        break;
        /* generacion de combo */
        case "combo":
            $datos = $grupo->get_grupo($_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['grupo_id']."'>".$row['grupo_nom']."</option>";
                }
                echo $html;
            }
            break;

        /* generacion de combo marcado con la opcion que viene de la BD */
        case "combo_select":
            $datos = $grupo->get_grupo($_POST["sis_id"],$_POST["grupo_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    if($row['grupo_id']==$_POST["grupo_id"]){
                        $html.= "<option value='".$row['grupo_id']."' selected>".$row['grupo_nom']."</option>";
                    }else{
                        $html.= "<option value='".$row['grupo_id']."'>".$row['grupo_nom']."</option>";
                    }
                }
                echo $html;
            }
        break;
    }
?>