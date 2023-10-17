<?php
    require_once("../config/conexion.php");
    require_once("../models/Ticket.php");
    $ticket = new Ticket();

    require_once("../models/Ticketoc.php");
    $ticketoc = new Ticketoc();

    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    require_once("../models/Documento.php");
    $documento = new Documento();

    switch($_GET["op"]){

        case "insert":
            $datos=$ticket->insert_ticket($_POST["usu_id"],$_POST["cat_id"],$_POST["tick_titulo"],$_POST["tick_descrip"],$_POST["tick_prio"],$_POST["area_id"],$_POST["suba_id"],$_POST["tip_id"],$_POST["tick_Planta"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["tick_id"] = $row["tick_id"];
                    $output["tick_corre"] = $row["tick_corre"];

                    if ($_FILES['files']['name']==0){

                    }else{
                        $countfiles = count($_FILES['files']['name']);
                        $ruta = '../public/documentos/' . $output["tick_id"] . '/';
                        $files_arr = array();

                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }

                        for ($index = 0; $index < $countfiles; $index++) {
                            $doc1 = $_FILES["files"]['tmp_name'][$index];
                            $destino = $ruta . $_FILES["files"]["name"][$index];

                            $documento->insert_documento($output["tick_id"], $_FILES["files"]["name"][$index]);

                            move_uploaded_file($doc1, $destino);
                        }
                    }

                }
                echo json_encode($output);
            }
            break;

        case "update":
            $ticket->update_ticket($_POST["tick_id"]);
            $ticket->insert_ticketdetalle_cerrar($_POST["tick_id"],$_POST["usu_id"]);
            break;

        case "update_opcion":
            $ticket->update_ticket_opcion($_POST["tick_id"],$_POST["tick_opc"]);
            break;

        case "update_tipo_categoria":
            $ticket->update_ticket_tipo_categoria($_POST["tick_id"],$_POST["tip_id"],$_POST["cat_id"]);
            break;

        case "listar_x_usu":
            if ($_SESSION["sis_id"]==3){
                $datos=$ticketoc->listar_ticketoc_x_usu($_POST["usu_id"]);
                $data= Array();
                foreach($datos as $row){
                    $sub_array = array();
                    $sub_array[] = $row["tickoc_corre"];
                    $sub_array[] = $row["tickoc_orden"];
                    $sub_array[] = $row["tip_nom"];
                    $sub_array[] = $row["cat_nom"];
                    $sub_array[] = $row["area_nom"];
                    $sub_array[] = $row["suba_nom"];
                    $sub_array[] = $row["tickoc_titulo"];
                    $sub_array[] = $row["estoc_nom2"];

                    if ($row["tickoc_estado"]=="Abierto"){
                        $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                    }else{
                        $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }

                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                    if ($row["fech_cierre"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                    }else{
                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
                    }

                    /* if ($row["fech_dig"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                    }else{
                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_dig"]));
                    }

                    if ($row["fech_apro"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                    }else{
                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_apro"]));
                    }

                    if ($row["fech_envprov"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                    }else{
                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_envprov"]));
                    }

                    if ($row["fech_repbode"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                    }else{
                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_repbode"]));
                    } */

                    if ($row["usu_asig"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                    }else{
                        $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                        foreach($datos1 as $row1){
                            $sub_array[] = '<span class="label label-pill label-success">'.$row1["usu_nom"].'</span>';
                        }
                    }

                    $sub_array[] = '<button type="button" onClick="ver('.$row["tickoc_id"].');"  id="'.$row["tickoc_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                    $data[] = $sub_array;
                }

                $results = array(
                    "sEcho"=>1,
                    "iTotalRecords"=>count($data),
                    "iTotalDisplayRecords"=>count($data),
                    "aaData"=>$data);
                echo json_encode($results);
            }else{
                $datos=$ticket->listar_ticket_x_usu($_POST["usu_id"], $_POST["tip_id"],$_POST["area_id"],$_POST["tick_estado"],$_POST["usu_asig_est"],$_POST["sis_id"],$_POST["tick_Planta"]);
                $data= Array();
                foreach($datos as $row){
                    $sub_array = array();
                    $sub_array[] = $row["tick_corre"];
                    $sub_array[] = $row["tip_nom"];
                    $sub_array[] = $row["cat_nom"];
                    $sub_array[] = $row["tick_Planta"];
                    $sub_array[] = $row["area_nom"];
                    $sub_array[] = $row["suba_nom"];
                    $sub_array[] = $row["tick_titulo"];
    
                    if ($row["tick_prio"]=="Baja"){
                        $sub_array[] = '<span class="label label-pill label-default">Baja</span>';
                    }else if ($row["tick_prio"]=="Media"){
                        $sub_array[] = '<span class="label label-pill label-warning">Media</span>';
                    }else if ($row["tick_prio"]=="Alta"){
                        $sub_array[] = '<span class="label label-pill label-danger">Alta</span>';
                    }
    
                    if ($row["tick_estado"]=="Abierto"){
                        $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                    }else{
                        $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }
    
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                    if ($row["fech_cierre"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                    }else{
                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
                    }
    
                    if ($row["usu_asig"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                    }else{
                        $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                        foreach($datos1 as $row1){
                            $sub_array[] = '<span class="label label-pill label-success">'.$row1["usu_nom"].'</span>';
                        }
                    }
    
                    $sub_array[] = '<button type="button" onClick="ver('.$row["tick_id"].');"  id="'.$row["tick_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                    $data[] = $sub_array;
                }

                $results = array(
                    "sEcho"=>1,
                    "iTotalRecords"=>count($data),
                    "iTotalDisplayRecords"=>count($data),
                    "aaData"=>$data);
                echo json_encode($results);
            }
            break;

        case "listar":
            $datos=$ticket->listar_ticket();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tick_id"];
                $sub_array[] = $row["tip_nom"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["tick_Planta"]; 
                $sub_array[] = $row["area_nom"];
                $sub_array[] = $row["suba_nom"];
                $sub_array[] = $row["tick_titulo"];

                if ($row["tick_prio"]=="Baja"){
                    $sub_array[] = '<span class="label label-pill label-default">Baja</span>';
                }else if ($row["tick_prio"]=="Media"){
                    $sub_array[] = '<span class="label label-pill label-warning">Media</span>';
                }else if ($row["tick_prio"]=="Alta"){
                    $sub_array[] = '<span class="label label-pill label-danger">Alta</span>';
                }

                if ($row["tick_estado"]=="Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                }else{
                    $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                if ($row["fech_cierre"]==""){
                    $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
                }

                if ($row["usu_asig"]==""){
                    $sub_array[] = '<a onClick="asignar('.$row["tick_id"].');"  id="'.$row["tick_id"].'"><span class="label label-pill label-default">Sin Asignar</span></a>';
                }else{
                    $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($datos1 as $row1){
                        $sub_array[] = '<a onClick="asignar('.$row["tick_id"].');"  id="'.$row["tick_id"].'"><span class="label label-pill label-success">'.$row1["usu_nom"].'</span></a>';
                    }
                }

                $sub_array[] = '<button type="button" onClick="ver('.$row["tick_id"].');"  id="'.$row["tick_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;

        case "listar_filtro":
            $datos=$ticket->filtro_ticket($_POST["tip_id"],$_POST["area_id"],$_POST["tick_estado"],$_POST["usu_asig_est"],$_POST["sis_id"],$_POST["tick_Planta"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tick_corre"];
                $sub_array[] = $row["tip_nom"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["tick_Planta"]; 
                $sub_array[] = $row["area_nom"];
                $sub_array[] = $row["suba_nom"];
                $sub_array[] = $row["tick_titulo"];

                if ($row["tick_opc"]==""){
                    $sub_array[] = '<span class="label label-pill label-danger">Sin Selección</span>';
                }else{
                    $sub_array[] = $row["tick_opc"];
                }

                if ($row["tick_prio"]=="Baja"){
                    $sub_array[] = '<span class="label label-pill label-default">Baja</span>';
                }else if ($row["tick_prio"]=="Media"){
                    $sub_array[] = '<span class="label label-pill label-warning">Media</span>';
                }else if ($row["tick_prio"]=="Alta"){
                    $sub_array[] = '<span class="label label-pill label-danger">Alta</span>';
                }

                if ($row["tick_estado"]=="Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                }else{
                    $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                if ($row["fech_cierre"]==""){
                    $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
                }

                if ($row["usu_asig"]==""){
                    $sub_array[] = '<a onClick="asignar('.$row["tick_id"].');"  id="'.$row["tick_id"].'"><span class="label label-pill label-default">Sin Asignar</span></a>';
                }else{
                    $sub_array[] = '<a onClick="asignar('.$row["tick_id"].');"  id="'.$row["tick_id"].'"><span class="label label-pill label-default">'.$row["usu_nom_asig"].' '.$row["usu_ape_asig"].'</span></a>';
                }

                $sub_array[] = '<button type="button" onClick="ver('.$row["tick_id"].');"  id="'.$row["tick_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data
            );
            echo json_encode($results);
            break;

        case "listar_filtro_oc":
            $datos=$ticketoc->filtro_ticketoc($_POST["tip_id"],$_POST["area_id"],$_POST["tick_estado"],$_POST["usu_asig_est"],$_POST["sis_id"],$_POST["estoc_id"],$_POST["tickoc_orden"],$_POST["fech_crea"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tickoc_corre"];
                $sub_array[] = $row["tickoc_orden"];
                $sub_array[] = $row["tip_nom"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["area_nom"];
                $sub_array[] = $row["suba_nom"];
                $sub_array[] = $row["tickoc_titulo"];
                $sub_array[] = $row["estoc_nom2"];

                if ($row["tickoc_estado"]=="Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                }else{
                    $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

                if ($row["fech_cierre"]==""){
                    $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
                }

                $sub_array[] = $row["tickoc_geren"];

                $sub_array[] = $row["tickoc_geren2"];

                if ($row["usu_asig"]==""){
                    $sub_array[] = '<a onClick="asignar('.$row["tickoc_id"].');"  id="'.$row["tickoc_id"].'"><span class="label label-pill label-default">Sin Asignar</span></a>';
                }else{
                    $sub_array[] = '<a onClick="asignar('.$row["tickoc_id"].');"  id="'.$row["tickoc_id"].'"><span class="label label-pill label-success">'.$row["usu_nom_asig"].' '.$row["usu_ape_asig"].'</span></a>';
                }

                $sub_array[] = '<button type="button" onClick="ver('.$row["tickoc_id"].');"  id="'.$row["tickoc_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;

        case "listar_x_asig":
            if ($_SESSION["sis_id"]==3){
                $datos=$ticketoc->listar_ticketoc_x_asig($_POST["usu_asig"]);
                $data= Array();
                foreach($datos as $row){
                    $sub_array = array();
                    $sub_array[] = $row["tickoc_corre"];
                    $sub_array[] = $row["tickoc_orden"];
                    $sub_array[] = $row["tip_nom"];
                    $sub_array[] = $row["cat_nom"];
                    $sub_array[] = $row["area_nom"];
                    $sub_array[] = $row["suba_nom"];
                    $sub_array[] = $row["tickoc_titulo"];
                    $sub_array[] = $row["estoc_nom2"];

                    if ($row["tickoc_estado"]=="Abierto"){
                        $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                    }else{
                        $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }

                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                    if ($row["fech_cierre"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                    }else{
                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
                    }

                    /* if ($row["fech_dig"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                    }else{
                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_dig"]));
                    }

                    if ($row["fech_apro"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                    }else{
                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_apro"]));
                    }

                    if ($row["fech_envprov"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                    }else{
                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_envprov"]));
                    }

                    if ($row["fech_repbode"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                    }else{
                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_repbode"]));
                    } */

                    if ($row["usu_asig"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                    }else{
                        $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                        foreach($datos1 as $row1){
                            $sub_array[] = '<span class="label label-pill label-success">'.$row1["usu_nom"].'</span>';
                        }
                    }

                    $sub_array[] = '<button type="button" onClick="ver('.$row["tickoc_id"].');"  id="'.$row["tickoc_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                    $data[] = $sub_array;
                }

                $results = array(
                    "sEcho"=>1,
                    "iTotalRecords"=>count($data),
                    "iTotalDisplayRecords"=>count($data),
                    "aaData"=>$data);
                echo json_encode($results);
            }else{
                $datos=$ticket->listar_ticket_x_asig($_POST["usu_asig"], $_POST["tip_id"],$_POST["area_id"],$_POST["tick_estado"],$_POST["usu_asig_est"],$_POST["sis_id"],$_POST["tick_Planta"]);
                $data= Array();
                foreach($datos as $row){
                    $sub_array = array();
                    $sub_array[] = $row["tick_corre"];
                    $sub_array[] = $row["tip_nom"];
                    $sub_array[] = $row["cat_nom"];
                    $sub_array[] = $row["tick_Planta"]; 
                    $sub_array[] = $row["area_nom"];
                    $sub_array[] = $row["suba_nom"];
                    $sub_array[] = $row["tick_titulo"];

                    if ($row["tick_prio"]=="Baja"){
                        $sub_array[] = '<span class="label label-pill label-default">Baja</span>';
                    }else if ($row["tick_prio"]=="Media"){
                        $sub_array[] = '<span class="label label-pill label-warning">Media</span>';
                    }else if ($row["tick_prio"]=="Alta"){
                        $sub_array[] = '<span class="label label-pill label-danger">Alta</span>';
                    }

                    if ($row["tick_estado"]=="Abierto"){
                        $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                    }else{
                        $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }

                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                    if ($row["fech_cierre"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                    }else{
                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
                    }

                    if ($row["usu_asig"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                    }else{
                        $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                        foreach($datos1 as $row1){
                            $sub_array[] = '<span class="label label-pill label-success">'.$row1["usu_nom"].'</span>';
                        }
                    }

                    $sub_array[] = '<button type="button" onClick="ver('.$row["tick_id"].');"  id="'.$row["tick_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                    $data[] = $sub_array;
                }

                $results = array(
                    "sEcho"=>1,
                    "iTotalRecords"=>count($data),
                    "iTotalDisplayRecords"=>count($data),
                    "aaData"=>$data);
                echo json_encode($results);
            }
            break;

        case "listar_x_grupo":
            if ($_SESSION["sis_id"]==3){
                $datos=$ticketoc->listar_ticketoc_x_grupo($_POST["grupo_id"]);
                $data= Array();
                foreach($datos as $row){
                    $sub_array = array();
                    $sub_array[] = $row["tickoc_corre"];
                    $sub_array[] = $row["tip_nom"];
                    $sub_array[] = $row["cat_nom"];
                    $sub_array[] = $row["area_nom"];
                    $sub_array[] = $row["suba_nom"];
                    $sub_array[] = $row["tickoc_titulo"];

                    if ($row["tickoc_estado"]=="Abierto"){
                        $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                    }else{
                        $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }

                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                    if ($row["fech_cierre"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                    }else{
                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
                    }

                    if ($row["usu_asig"]==""){
                        $sub_array[] = '<a onClick="asignar('.$row["tickoc_id"].');"  id="'.$row["tickoc_id"].'"><span class="label label-pill label-default">Sin Asignar</span></a>';
                    }else{
                        $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                        foreach($datos1 as $row1){
                            $sub_array[] = '<a onClick="asignar('.$row["tickoc_id"].');"  id="'.$row["tickoc_id"].'"><span class="label label-pill label-success">'.$row1["usu_nom"].'</span></a>';
                        }
                    }

                    $sub_array[] = '<button type="button" onClick="ver('.$row["tickoc_id"].');"  id="'.$row["tickoc_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                    $data[] = $sub_array;
                }

                $results = array(
                    "sEcho"=>1,
                    "iTotalRecords"=>count($data),
                    "iTotalDisplayRecords"=>count($data),
                    "aaData"=>$data);
                echo json_encode($results);
            }else{
                $datos=$ticket->listar_ticket_x_grupo($_POST["grupo_id"], $_POST["tip_id"],$_POST["area_id"],$_POST["tick_estado"],$_POST["usu_asig_est"],$_POST["sis_id"],$_POST["tick_Planta"]);
                $data= Array();
                foreach($datos as $row){
                    $sub_array = array();
                    $sub_array[] = $row["tick_corre"];
                    $sub_array[] = $row["tip_nom"];
                    $sub_array[] = $row["cat_nom"];
                    $sub_array[] = $row["tick_Planta"]; 
                    $sub_array[] = $row["area_nom"];
                    $sub_array[] = $row["suba_nom"];
                    $sub_array[] = $row["tick_titulo"];

                    if ($row["tick_prio"]=="Baja"){
                        $sub_array[] = '<span class="label label-pill label-default">Baja</span>';
                    }else if ($row["tick_prio"]=="Media"){
                        $sub_array[] = '<span class="label label-pill label-warning">Media</span>';
                    }else if ($row["tick_prio"]=="Alta"){
                        $sub_array[] = '<span class="label label-pill label-danger">Alta</span>';
                    }

                    if ($row["tick_estado"]=="Abierto"){
                        $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                    }else{
                        $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }

                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                    if ($row["fech_cierre"]==""){
                        $sub_array[] = '<span class="label label-pill label-default">Pendiente</span>';
                    }else{
                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
                    }

                    if ($row["usu_asig"]==""){
                        $sub_array[] = '<a onClick="asignar('.$row["tick_id"].');"  id="'.$row["tick_id"].'"><span class="label label-pill label-default">Sin Asignar</span></a>';
                    }else{
                        $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                        foreach($datos1 as $row1){
                            $sub_array[] = '<a onClick="asignar('.$row["tick_id"].');"  id="'.$row["tick_id"].'"><span class="label label-pill label-success">'.$row1["usu_nom"].'</span></a>';
                        }
                    }

                    $sub_array[] = '<button type="button" onClick="ver('.$row["tick_id"].');"  id="'.$row["tick_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                    $data[] = $sub_array;
                }

                $results = array(
                    "sEcho"=>1,
                    "iTotalRecords"=>count($data),
                    "iTotalDisplayRecords"=>count($data),
                    "aaData"=>$data);
                echo json_encode($results);
            }
            break;

        case "listardetalle":
            $datos=$ticket->listar_ticketdetalle_x_ticket($_POST["tick_id"]);
            ?>
                <?php
                    foreach($datos as $row){
                        ?>
                            <article class="activity-line-item box-typical">
                                <div class="activity-line-date">
                                    <?php echo date("d/m/Y", strtotime($row["fech_crea"]));?>
                                </div>
                                <header class="activity-line-item-header">
                                    <div class="activity-line-item-user">
                                        <div class="activity-line-item-user-photo">
                                            <a href="#">
                                                <img src="../../public/<?php echo $row['rol_id'] ?>.jpg" alt="">
                                            </a>
                                        </div>
                                        <div class="activity-line-item-user-name"><?php echo $row['usu_nom'].' '.$row['usu_ape'];?></div>
                                        <div class="activity-line-item-user-status">
                                            <?php 
                                                if ($row['rol_id']==1){
                                                    echo 'Usuario';
                                                }else{
                                                    echo 'Soporte';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </header>
                                <div class="activity-line-action-list">
                                    <section class="activity-line-action">
                                        <div class="time"><?php echo date("H:i:s", strtotime($row["fech_crea"]));?></div>
                                        <div class="cont">
                                            <div class="cont-in">
                                                <p>
                                                    <?php echo $row["tickd_descrip"];?>
                                                </p>

                                                <br>

                                                <?php
                                                    $datos=$ticket->listar_ticket_file($row["tickd_id"]);
                                                    if(is_array($datos)==true and count($datos)>0){
                                                        ?>
                                                        <p>
                                                            Documentos Adjuntos
                                                        </p>

                                                        <p>
                                                            <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 60%;"> Nombre</th>
                                                                        <th style="width: 40%;"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        $datos=$ticket->listar_ticket_file($row["tickd_id"]);
                                                                        foreach($datos as $row){
                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo $row["tickf_ruta"];?></td>
                                                                            <td>
                                                                                <a href="../../public/files/<?php echo $row["tickd_id"];?>/<?php echo $row["tickf_ruta"];?>" target="_blank" class="btn btn-inline btn-primary btn-sm">Ver</a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </p>
                                                        <?php
                                                    }
                                                ?>

                                            </div>
                                        </div>
                                    </section>

                                </div>
                            </article>
                        <?php
                    }
                ?>
            <?php
            break;

        case "mostrar";
            $datos=$ticket->listar_ticket_x_id($_POST["tick_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row) {
                    if ($row["tick_id"]==0){
                        $output["tick_id"] = $row["tick_id"];
                    }else{
                        $output["tick_id"] = $row["tick_id"];
                        $output["usu_id"] = $row["usu_id"];
                        $output["tip_id"] = $row["tip_id"];
                        $output["tip_nom"] = $row["tip_nom"];
                        $output["cat_id"] = $row["cat_id"];
                        
                        $output["sis_id"] = $row["sis_id"];

                        $output["tick_titulo"] = $row["tick_titulo"];
                        $output["tick_descrip"] = $row["tick_descrip"];
                        $output["tick_prio"] = $row["tick_prio"];
                        $output["area_nom"] = $row["area_nom"];
                        $output["suba_nom"] = $row["suba_nom"];

                        $output["tick_opc"] = $row["tick_opc"];

                        if ($row["tick_estado"]=="Abierto"){
                            $output["tick_estado"] = '<span class="label label-pill label-success">Abierto</span>';
                        }else{
                            $output["tick_estado"] = '<span class="label label-pill label-danger">Cerrado</span>';
                        }

                        $output["tick_estado_texto"] = $row["tick_estado"];

                        $output["fech_crea"] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                        $output["usu_nom"] = $row["usu_nom"];
                        $output["usu_ape"] = $row["usu_ape"];
                        $output["cat_nom"] = $row["cat_nom"];
                        $output["tick_Planta"] = $row["tick_Planta"];
                        $output["usu_asig"] = $row["usu_asig"];
                        $output["tick_corre"] = $row["tick_corre"];
                    }

                }
                echo json_encode($output);
            }
            break;

        case "insertdetalle":
            /* $datos=$ticket->insert_ticketdetalle($_POST["tick_id"],$_POST["usu_id"],$_POST["tickd_descrip"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["tickd_id"] = $row["tickd_id"];

                    if ($_FILES['files']['name']==0){

                    }else{
                        $countfiles = count($_FILES['files']['name']);
                        $ruta = '../public/files/' . $output["tickd_id"] . '/';
                        $files_arr = array();

                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }

                        for ($index = 0; $index < $countfiles; $index++) {
                            $doc1 = $_FILES["files"]['tmp_name'][$index];
                            $destino = $ruta . $_FILES["files"]["name"][$index];

                            $ticket->insert_ticket_file($output["tickd_id"], $_FILES["files"]["name"][$index]);

                            move_uploaded_file($doc1, $destino);
                        }
                    }

                }
                echo json_encode($output); */

                $datos = $ticket->insert_ticketdetalle($_POST["tick_id"],$_POST["usu_id"],$_POST["tickd_descrip"]);
                if($datos > 0) {
                    $ruta = '../public/files/' . $datos . '/';
                    if (!file_exists($ruta)) {
                        mkdir($ruta, 0777, true);
                    }

                    if ($_FILES['files']['name'] != 0) {
                        $countfiles = count($_FILES['files']['name']);
                        $files_arr = array();

                        for ($index = 0; $index < $countfiles; $index++) {
                            $doc1 = $_FILES["files"]['tmp_name'][$index];
                            $destino = $ruta . $_FILES["files"]["name"][$index];

                            $ticket->insert_ticket_file($datos, $_FILES["files"]["name"][$index]);

                            move_uploaded_file($doc1, $destino);
                        }
                    }

                    $output["tickd_id"] = $datos;
                    echo json_encode($output);

            }
            break;

        case "asignar":
            $ticket->asignar_ticket($_POST["tick_id"],$_POST["usu_asig"]);
            break;

        case "total";
            $datos=$ticket->get_ticket_total($_POST["grupo_id"],$_POST["sis_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        case "totalabierto";
            $datos=$ticket->get_ticket_totalabierto($_POST["grupo_id"],$_POST["sis_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        case "totalcerrado";
            $datos=$ticket->get_ticket_totalcerrado($_POST["grupo_id"],$_POST["sis_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        case "totalsinasignar";
            $datos=$ticket->get_ticket_totalsinasignar($_POST["grupo_id"],$_POST["sis_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        case "grafico";
            $datos=$ticket->get_ticket_grafico($_POST["grupo_id"],$_POST["sis_id"]);  
            echo json_encode($datos);
            break;

    }
?>