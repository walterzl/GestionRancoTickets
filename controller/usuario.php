<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Usuario.php");
    $usuario = new Usuario();
    /* opciones del controlador */
    switch($_GET["op"]){
        /* generacion de login y sessiones necesarias */
        case "login":
            $datos = $usuario->login($_POST["usu_correo"],$_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $_SESSION["usu_id"]=$row["usu_id"];
                    $_SESSION["usu_nom"]=$row["usu_nom"];
                    $_SESSION["usu_ape"]=$row["usu_ape"];
                    $_SESSION["rol_id"]=$row["rol_id"];
                    $_SESSION["grupo_id"]=$row["grupo_id"];
                    $_SESSION["area_id"]=$row["area_id"];
                    $_SESSION["suba_id"]=$row["suba_id"];
                    $_SESSION["sis_id"]=$row["sis_id"];
                    $_SESSION["sis_nom"]=$row["sis_nom"];

                }
            }
            break;
        /*  para poder guardar y editar el registro */
        case "guardaryeditar":
            $datos = $usuario->get_usuario_x_correo($_POST["usu_correo"]);
            if(empty($_POST["usu_id"])){
                if(is_array($datos)==true and count($datos)==0){
                    $usuario->insert_usuario($_POST["usu_nom"],$_POST["usu_ape"],$_POST["usu_correo"],$_POST["usu_pass"],$_POST["rol_id"],$_POST["grupo_id"],$_POST["area_id"],$_POST["suba_id"]);
                    echo "OK";
                }else{
                    echo "EXISTE";
                }
            } else {
                $usuario->update_usuario($_POST["usu_id"],$_POST["usu_nom"],$_POST["usu_ape"],$_POST["usu_correo"],$_POST["usu_pass"],$_POST["rol_id"],$_POST["grupo_id"],$_POST["area_id"],$_POST["suba_id"]);
                echo "OK";
            }
            break;
        /* manejo de json para poder listar en el datatable, formato de json segun documentacion */
        case "listar":
            $datos=$usuario->get_usuario($_POST["sis_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["usu_nom"];
                $sub_array[] = $row["usu_ape"];
                $sub_array[] = $row["usu_correo"];
                $sub_array[] = '<span class="label label-pill label-'.$row["rol_color"].'">'.$row["rol_nom"].'</span>';
                $sub_array[] = $row["grupo_nom"];
                $sub_array[] = $row["area_nom"];
                $sub_array[] = $row["suba_nom"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["usu_id"].');"  id="'.$row["usu_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["usu_id"].');"  id="'.$row["usu_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
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
            $usuario->delete_usuario($_POST["usu_id"]);
            break;
        /* se arma json segun el resultado del id enviado */
        case "mostrar";
            $datos=$usuario->get_usuario_x_id($_POST["usu_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["usu_id"] = $row["usu_id"];
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_ape"] = $row["usu_ape"];
                    $output["usu_correo"] = $row["usu_correo"];
                    $output["usu_pass"] = $row["usu_pass"];
                    $output["rol_id"] = $row["rol_id"];
                    $output["grupo_id"] = $row["grupo_id"];
                    $output["grupo_nom"] = $row["grupo_nom"];
                    $output["area_id"] = $row["area_id"];
                    $output["area_nom"] = $row["area_nom"];
                    $output["suba_id"] = $row["suba_id"];
                    $output["suba_nom"] = $row["suba_nom"];
                }
                echo json_encode($output);
            }
            break;
        /*  generacion de json usuarios por correo electronico */
        case "mostrar_x_correo";
            $datos=$usuario->get_usuario_x_correo($_POST["usu_correo"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["usu_id"] = $row["usu_id"];
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_ape"] = $row["usu_ape"];
                    $output["usu_correo"] = $row["usu_correo"];
                    $output["usu_pass"] = $row["usu_pass"];
                    $output["rol_id"] = $row["rol_id"];
                    $output["grupo_id"] = $row["grupo_id"];
                    $output["grupo_nom"] = $row["grupo_nom"];
                    $output["area_id"] = $row["area_id"];
                    $output["area_nom"] = $row["area_nom"];
                    $output["suba_id"] = $row["suba_id"];
                    $output["suba_nom"] = $row["suba_nom"];
                }
                echo json_encode($output);
            }
            break;

        /* json por el total de ticket por usuario */
        case "total";
            if ($_SESSION["sis_id"]==3){
                $datos=$usuario->get_usuario_oc_total_x_id($_POST["usu_id"]);  
            }else{
                $datos=$usuario->get_usuario_total_x_id($_POST["usu_id"]);  
            }
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;
        /* total en formato de ticket abiertos */
        case "totalabierto";
            if ($_SESSION["sis_id"]==3){
                $datos=$usuario->get_usuario_oc_totalabierto_x_id($_POST["usu_id"]);
            }else{
                $datos=$usuario->get_usuario_totalabierto_x_id($_POST["usu_id"]);  
            }
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;
        /* total en formato json de ticket cerrados */
        case "totalcerrado";
            if ($_SESSION["sis_id"]==3){
                $datos=$usuario->get_usuario_oc_totalcerrado_x_id($_POST["usu_id"]);  
            }else{
                $datos=$usuario->get_usuario_totalcerrado_x_id($_POST["usu_id"]);  
            }
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        case "totalsinasignar";
            if ($_SESSION["sis_id"]==3){
                $datos=$usuario->get_usuario_oc_totalsinasignar_x_id($_POST["usu_id"]);  
            }else{
                $datos=$usuario->get_usuario_totalsinasignar_x_id($_POST["usu_id"]);  
            }
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;
        /* total en formato usarios por categoria de ticket generada */
        case "grafico";
        if ($_SESSION["sis_id"]==3){
            $datos=$usuario->get_usuario_oc_grafico($_POST["usu_id"]);  
        }else{
            $datos=$usuario->get_usuario_grafico($_POST["usu_id"]);  
        }
            
            echo json_encode($datos);
            break;

        /* generacion de combo */
        case "combo":
            $datos = $usuario->get_usuario_x_rol($_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['usu_id']."'>".$row['usu_nom']."</option>";
                }
                echo $html;
            }
            break;
    }
?>