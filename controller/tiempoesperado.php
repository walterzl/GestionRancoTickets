<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Tiempoesperado.php");
    $tiempoesperado = new Tiempoesperado();

    /* opciones del controlador */
    switch($_GET["op"]){

        case "guardaryeditar":
            if (empty($_POST["TiempoEsperado_id"])) {
                $tiempoesperado->insert_tiempo_esperado($_POST["TiempoEsperado_nom"]);
            } else {
                $tiempoesperado->update_tiempo_esperado($_POST["TiempoEsperado_id"], $_POST["TiempoEsperado_nom"]);
            }
            break;
    
        case "listar":
            $datos = $tiempoesperado->get_tiempo_esperado($_POST["sis_id"]);
            $data = array();
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["TiempoEsperado_id"];
                $sub_array[] = $row["TiempoEsperado_nom"];
                $sub_array[] = '<button type="button" onClick="editar(' . $row["TiempoEsperado_id"] . ');" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar(' . $row["TiempoEsperado_id"] . ');" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
                $data[] = $sub_array;
            }
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($results);
            break;
    
        case "eliminar":
            $tiempoesperado->delete_tiempo_esperado($_POST["tiempoesperado_id"]);
            break;
    
        case "mostrar":
            $datos = $tiempoesperado->get_tiempo_esperado_by_id($_POST["tiempoesperado_id"]);
            if (is_array($datos) == true && count($datos) > 0) {
                foreach ($datos as $row) 
                {
                    $output["TiempoEsperado_id"] = $row["TiempoEsperado_id"];
                    
                    $output["TiempoEsperado_nom"] = $row["TiempoEsperado_nom"];
                    
                }
                echo json_encode($output);
            }
           
            
            break;

        /* generacion de combo */
        case "combo":
            $datos = $tiempoesperado->get_tiempoesperado($_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['TiempoEsperado_id']."'>".$row['TiempoEsperado_nom']."</option>";
                }
                echo $html;
            }
            break;

        case "combo_select":
            $datos = $plancontable->get_tiempoesperado($_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                $html="";
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    if($row['cntcon_id']==$_POST["TiempoEsperado_id"]){
                        $html.= "<option value='".$row['TiempoEsperado_id']."' selected>".$row['TiempoEsperado_nom']."-".$row['TiempoEsperado_nom2']."</option>";
                    }else{
                        $html.= "<option value='".$row['TiempoEsperado_id']."'>".$row['TiempoEsperado_nom']."-".$row['TiempoEsperado_nom2']."</option>";
                    }
                }
                echo $html;
            }
            break;

    }
?>