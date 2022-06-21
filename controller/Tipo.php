<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Tipo.php");
    $tipo = new Tipo();

    /* opciones del controlador */
    switch($_GET["op"]){
         /*  para poder guardar y editar el registro */
         case "guardaryeditar":
            if(empty($_POST["tip_id"])){
                $tipo->insert_tipo($_POST["tip_nom"]);
            }
            else {
                $tipo->update_tipo($_POST["tip_id"],$_POST["tip_nom"]);
            }
            break;
        /* manejo de json para poder listar en el datatable, formato de json segun documentacion */
        case "listar":
            $datos=$tipo->get_tipo($_POST["sis_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tip_nom"];

                $sub_array[] = '<button type="button" onClick="editar('.$row["tip_id"].');"  id="'.$row["tip_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["tip_id"].');"  id="'.$row["tip_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
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
            $tipo->delete_tipo($_POST["tip_id"]);
            break;
        /* se arma json segun el resultado del id enviado */
        case "mostrar";
            $datos=$tipo->get_tipo_x_id($_POST["tip_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["tip_id"] = $row["tip_id"];
                    $output["tip_nom"] = $row["tip_nom"];
                }
                echo json_encode($output);
            }
            break;
        /* generacion de combo */
        case "combo":
            $datos = $tipo->get_tipo($_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['tip_id']."'>".$row['tip_nom']."</option>";
                }
                echo $html;
            }
            break;

        case "combo_select":
            $datos = $tipo->get_tipo($_POST["sis_id"],$_POST["tip_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    if($row['tip_id']==$_POST["tip_id"]){
                        $html.= "<option value='".$row['tip_id']."' selected>".$row['tip_nom']."</option>";
                    }else{
                        $html.= "<option value='".$row['tip_id']."'>".$row['tip_nom']."</option>";
                    }
                }
                echo $html;
            }
            break;
    }
?>