<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Rol.php");
    $rol = new rol();

    /* opciones del controlador */
    switch($_GET["op"]){
         /*  para poder guardar y editar el registro */
         case "guardaryeditar":
            if(empty($_POST["rol_id"])){
                $rol->insert_rol($_POST["rol_nom"],$_POST["rol_color"]);
            }
            else {
                $rol->update_rol($_POST["rol_id"],$_POST["rol_nom"],$_POST["rol_color"]);
            }
            break;
        /* manejo de json para poder listar en el datatable, formato de json segun documentacion */
        case "listar":
            $datos=$rol->get_rol($_POST["sis_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["rol_nom"];
                $sub_array[] = $row["rol_color"];

                $sub_array[] = '<button type="button" onClick="editar('.$row["rol_id"].');"  id="'.$row["rol_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["rol_id"].');"  id="'.$row["rol_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
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
            $rol->delete_rol($_POST["rol_id"]);
            break;
        /* se arma json segun el resultado del id enviado */
        case "mostrar";
            $datos=$rol->get_rol_x_id($_POST["rol_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["rol_id"] = $row["rol_id"];
                    $output["rol_nom"] = $row["rol_nom"];
                    $output["rol_color"] = $row["rol_color"];
                }
                echo json_encode($output);
            }
            break;
        /* generacion de combo */
        case "combo":
            $datos = $rol->get_rol($_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['rol_id']."'>".$row['rol_nom']."</option>";
                }
                echo $html;
            }
            break;
    }
?>