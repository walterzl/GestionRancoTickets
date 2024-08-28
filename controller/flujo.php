<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Flujo.php");
    $flujo = new Flujo();

    /* opciones del controlador */
    switch($_GET["op"]){
        /* manejo de json para poder listar en el datatable, formato de json  */
        case "listar":
            $sis_id = isset($_POST["sis_id"]) ? intval($_POST["sis_id"]) : 0;
            $usu_id = isset($_POST["usu_id"]) ? intval($_POST["usu_id"]) : 0;
            
            $datos = $flujo->get_flujo_x_usu($sis_id, $usu_id);

            $data = Array();
            foreach($datos as $row){
                $data[] = array(
                    "id" => $row["id"],
                    "itemCompra" => $row["itemCompra"],
                    "nombreSolicitante" => $row["nombreSolicitante"],
                    "correoSolicitante" => $row["correoSolicitante"],
                    "nombreJefatura" => $row["nombreJefatura"],
                    "correoJefatura" => $row["correoJefatura"],
                    "FechaRespuesta" => $row["FechaRespuesta"],
                    "EstadoRespuesta" => $row["EstadoRespuesta"],
                    "usu_id" => $row["usu_id"]
                );
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data
            );
            
            echo json_encode($results);
        break;

    }
?>