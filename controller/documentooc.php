<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/documentooc.php");
    $documentooc = new Documentooc();

    /* opciones del controlador */
    switch($_GET["op"]){
        /* manejo de json para poder listar en el datatable, formato de json segun documentacion */
        case "listar":
            $datos=$documentooc->get_documentooc_x_ticket($_POST["tickoc_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = '<a href="../../public/documentosoc/'.$_POST["tickoc_id"].'/'.$row["dococ_nom"].'" target="_blank">'.$row["dococ_nom"].'</a>';
                $sub_array[] = '<a type="button" href="../../public/documentosoc/'.$_POST["tickoc_id"].'/'.$row["dococ_nom"].'" target="_blank" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></a>';
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
            $documentooc->delete_documentooc($_POST["dococ_id"]);
        break;

    }
?>