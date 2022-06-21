<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Categoria.php");
    $categoria = new Categoria();

    /* opciones del controlador */
    switch($_GET["op"]){  
        /*  para poder guardar y editar el registro */
        case "guardaryeditar":
            if(empty($_POST["cat_id"])){
                $categoria->insert_categoria($_POST["grupo_id"],$_POST["cat_nom"],$_POST["tip_id"]);
            } else {
                $categoria->update_categoria($_POST["cat_id"],$_POST["grupo_id"],$_POST["cat_nom"],$_POST["tip_id"]);
            }
            break;
        /* manejo de json para poder listar en el datatable, formato de json segun documentacion */
        case "listar":
            $datos=$categoria->get_categoria($_POST["sis_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["grupo_nom"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["tip_nom"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["cat_id"].');"  id="'.$row["cat_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["cat_id"].');"  id="'.$row["cat_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
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
            $categoria->delete_categoria($_POST["cat_id"]);
            break;
        /* se arma json segun el resultado del id enviado */
        case "mostrar";
            $datos=$categoria->get_categoria_x_id($_POST["cat_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["cat_id"] = $row["cat_id"];
                    $output["cat_nom"] = $row["cat_nom"];
                    $output["grupo_id"] = $row["grupo_id"];
                    $output["grupo_nom"] = $row["grupo_nom"];
                    $output["tip_id"] = $row["tip_id"];
                }
                echo json_encode($output);
            }
            break;
        /* generacion de combo */
        case "combo":
            $datos = $categoria->get_categoria($_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['cat_id']."'>".$row['cat_nom']."</option>";
                }
                echo $html;
            }
            break;
        /* generacion de combo marcado con la opcion que viene de la BD */
        case "combo_x_tipo":
            $datos = $categoria->get_categoria_x_tipo($_POST["tip_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    if ($row['sis_id']==3){
                        $html.= "<option value='".$row['cat_id']."' selected>".$row['cat_nom']."</option>";
                    }else{
                        $html.= "<option value='".$row['cat_id']."'>".$row['cat_nom']."</option>";
                    }
                }
                echo $html;
            }
            break;
        case "combo_select":
            $datos = $categoria->get_categoria_x_tipo($_POST["tip_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    if($row['cat_id']==$_POST["cat_id"]){
                        $html.= "<option value='".$row['cat_id']."' selected>".$row['cat_nom']."</option>";
                    }else{
                        $html.= "<option value='".$row['cat_id']."'>".$row['cat_nom']."</option>";
                    }
                }
                echo $html;
            }
            break;
    }
?>