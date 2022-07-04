<?php
    require_once("../config/conexion.php");
    require_once("../models/ticketoc.php");
    $ticketoc = new ticketoc();

    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    require_once("../models/Documentooc.php");
    $documentooc = new Documentooc();

    switch($_GET["op"]){

        case "insert":
            if (empty($_POST["ent_id"])){
                $entrega = 3;// Si viene vacio
            }else{
                $entrega = $_POST["ent_id"];
            }

            if (empty($_POST["dura_id"])){
                $duracion = 4;// Si viene vacio
            }else{
                $duracion = $_POST["dura_id"];
            }

            $datos=$ticketoc->insert_ticketoc($_POST["usu_id"],$_POST["cat_id"],$_POST["tickoc_titulo"],$_POST["tickoc_descrip"],$_POST["area_id"],$_POST["suba_id"],$_POST["tip_id"],$entrega,$_POST["cntcon_id"],$duracion,$_POST["tickoc_coti_cerra"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["tickoc_id"] = $row["tickoc_id"];
                    $output["tickoc_corre"] = $row["tickoc_corre"];

                    if ($_FILES['files']['name']==0){

                    }else{
                        $countfiles = count($_FILES['files']['name']);
                        $ruta = '../public/documentosoc/' . $output["tickoc_id"] . '/';
                        $files_arr = array();

                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }

                        for ($index = 0; $index < $countfiles; $index++) {
                            $doc1 = $_FILES["files"]['tmp_name'][$index];
                            $destino = $ruta . $_FILES["files"]["name"][$index];

                            $documentooc->insert_documentooc($output["tickoc_id"], $_FILES["files"]["name"][$index]);

                            move_uploaded_file($doc1, $destino);
                        }
                    }

                }
                echo json_encode($output);
            }
            break;

        case "update":
            $ticketoc->update_ticketoc($_POST["tickoc_id"]);
            $ticketoc->insert_ticketocdetalle_cerrar($_POST["tickoc_id"],$_POST["usu_id"]);
            break;

        case "update_opcion":
            $ticketoc->update_ticketoc_opcion($_POST["tickoc_id"],$_POST["tickoc_opc"]);
            break;

        case "update_tipo_categoria":
            $ticketoc->update_ticketoc_tipo_categoria($_POST["tickoc_id"],$_POST["tip_id"],$_POST["cat_id"]);
            break;
            
        case "listar_x_usu":
            $datos=$ticketoc->listar_ticketoc_x_usu($_POST["usu_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tickoc_corre"];
                $sub_array[] = $row["tip_nom"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["area_nom"];
                $sub_array[] = $row["suba_nom"];
                $sub_array[] = $row["tickoc_titulo"];

                if ($row["tickoc_prio"]=="Baja"){
                    $sub_array[] = '<span class="label label-pill label-default">Baja</span>';
                }else if ($row["tickoc_prio"]=="Media"){
                    $sub_array[] = '<span class="label label-pill label-warning">Media</span>';
                }else if ($row["tickoc_prio"]=="Alta"){
                    $sub_array[] = '<span class="label label-pill label-danger">Alta</span>';
                }

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
            break;

        case "listar":
            $datos=$ticketoc->listar_ticketoc();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tickoc_id"];
                $sub_array[] = $row["tip_nom"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["area_nom"];
                $sub_array[] = $row["suba_nom"];
                $sub_array[] = $row["tickoc_titulo"];

                if ($row["tickoc_prio"]=="Baja"){
                    $sub_array[] = '<span class="label label-pill label-default">Baja</span>';
                }else if ($row["tickoc_prio"]=="Media"){
                    $sub_array[] = '<span class="label label-pill label-warning">Media</span>';
                }else if ($row["tickoc_prio"]=="Alta"){
                    $sub_array[] = '<span class="label label-pill label-danger">Alta</span>';
                }

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
            break;

        case "listar_filtro":
            $datos=$ticketoc->filtro_ticketoc($_POST["tip_id"],$_POST["area_id"],$_POST["tickoc_estado"],$_POST["usu_asig_est"],$_POST["sis_id"],$_POST["estoc_id"],$_POST["tickoc_orden"],$_POST["fech_crea"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tickoc_corre"];
                $sub_array[] = $row["tip_nom"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["area_nom"];
                $sub_array[] = $row["suba_nom"];
                $sub_array[] = $row["tickoc_titulo"];

                if ($row["tickoc_prio"]=="Baja"){
                    $sub_array[] = '<span class="label label-pill label-default">Baja</span>';
                }else if ($row["tickoc_prio"]=="Media"){
                    $sub_array[] = '<span class="label label-pill label-warning">Media</span>';
                }else if ($row["tickoc_prio"]=="Alta"){
                    $sub_array[] = '<span class="label label-pill label-danger">Alta</span>';
                }

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
            break;

        case "listar_cotizacion_cerrada":
            $datos=$ticketoc->listar_oc_cotizacion_cerrado($_POST["usu_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tickoc_corre"];

                $sub_array[] = $row["tip_nom"];
                $sub_array[] = $row["estoc_nom2"];
                $sub_array[] = $row["area_nom"];
                $sub_array[] = $row["suba_nom"];
                $sub_array[] = $row["tickoc_titulo"];
               

                if ($row["tickoc_estado"]=="Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                }else{
                    $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                }

                
                
                

                $sub_array[] = '<button type="button" onClick="seleccionar('.$row["tickoc_id"].');"  id="'.$row["tickoc_id"].'" class="btn btn-inline btn-success btn-sm ladda-button"><i class="fa fa-check"></i></button>';
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
            $datos=$ticketoc->listar_ticketoc_x_asig($_POST["usu_asig"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tickoc_corre"];
                $sub_array[] = $row["tip_nom"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["area_nom"];
                $sub_array[] = $row["suba_nom"];
                $sub_array[] = $row["tickoc_titulo"];

                if ($row["tickoc_prio"]=="Baja"){
                    $sub_array[] = '<span class="label label-pill label-default">Baja</span>';
                }else if ($row["tickoc_prio"]=="Media"){
                    $sub_array[] = '<span class="label label-pill label-warning">Media</span>';
                }else if ($row["tickoc_prio"]=="Alta"){
                    $sub_array[] = '<span class="label label-pill label-danger">Alta</span>';
                }

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
            break;

        case "listar_x_grupo":
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

                if ($row["tickoc_prio"]=="Baja"){
                    $sub_array[] = '<span class="label label-pill label-default">Baja</span>';
                }else if ($row["tickoc_prio"]=="Media"){
                    $sub_array[] = '<span class="label label-pill label-warning">Media</span>';
                }else if ($row["tickoc_prio"]=="Alta"){
                    $sub_array[] = '<span class="label label-pill label-danger">Alta</span>';
                }

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
            break;

        case "listardetalle":
            $datos=$ticketoc->listar_ticketocdetalle_x_ticketoc($_POST["tickoc_id"]);
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
                                                <img src="../../public/user.png" alt="">
                                            </a>
                                        </div>
                                        <div class="activity-line-item-user-name"><?php echo $row['usu_nom'].' '.$row['usu_ape'];?></div>
                                        <div class="activity-line-item-user-status">
                                            <?php echo $row['rol_nom'] ?>
                                        </div>
                                    </div>
                                </header>
                                <div class="activity-line-action-list">
                                    <section class="activity-line-action">
                                        <div class="time"><?php echo date("H:i:s", strtotime($row["fech_crea"]));?></div>
                                        <div class="cont">
                                            <div class="cont-in">
                                                <p>
                                                    <?php echo $row["tickocd_descrip"];?>
                                                </p>

                                                <br>

                                                <?php
                                                    $datos=$ticketoc->listar_ticket_file_oc($row["tickocd_id"]);
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
                                                                        $datos=$ticketoc->listar_ticket_file_oc($row["tickocd_id"]);
                                                                        foreach($datos as $row){
                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo $row["tickfoc_ruta"];?></td>
                                                                            <td>
                                                                                <a href="../../public/filesoc/<?php echo $row["tickocd_id"];?>/<?php echo $row["tickfoc_ruta"];?>" target="_blank" class="btn btn-inline btn-primary btn-sm">Ver</a>
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
            $datos=$ticketoc->listar_ticketoc_x_id($_POST["tickoc_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row) {
                    if ($row["tickoc_id"]==0){
                        $output["tickoc_id"] = $row["tickoc_id"];
                    }else{
                        $output["tickoc_id"] = $row["tickoc_id"];
                        $output["usu_id"] = $row["usu_id"];
                        $output["tip_id"] = $row["tip_id"];
                        $output["tip_nom"] = $row["tip_nom"];
                        $output["cat_id"] = $row["cat_id"];

                        $output["sis_id"] = $row["sis_id"];

                        $output["tickoc_titulo"] = $row["tickoc_titulo"];
                        $output["tickoc_descrip"] = $row["tickoc_descrip"];
                        $output["area_nom"] = $row["area_nom"];
                        $output["suba_nom"] = $row["suba_nom"];

                        if ($row["tickoc_estado"]=="Abierto"){
                            $output["tickoc_estado"] = '<span class="label label-pill label-success">Abierto</span>';
                        }else{
                            $output["tickoc_estado"] = '<span class="label label-pill label-danger">Cerrado</span>';
                        }

                        $output["tickoc_estado_texto"] = $row["tickoc_estado"];

                        $output["fech_crea"] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                        $output["usu_nom"] = $row["usu_nom"];
                        $output["usu_ape"] = $row["usu_ape"];
                        $output["cat_nom"] = $row["cat_nom"];
                        $output["usu_asig"] = $row["usu_asig"];
                        $output["tickoc_corre"] = $row["tickoc_corre"];
                        $output["tickoc_orden"] = $row["tickoc_orden"];

                        if ($row["tickoc_coti_cerra"]=="0"){
                            $output["tickoc_coti_cerra"] = "No";
                        }else{
                            $datos2=$ticketoc->listar_ticketoc_x_id($row["tickoc_coti_cerra"]);
                            $output["tickoc_coti_cerra"] = $datos2[0]["tickoc_corre"];
                        }

                        $output["ent_nom"] = $row["ent_nom"];
                        $output["dura_nom"] = $row["dura_nom"];
                        $output["cntcon_nom"] = $row["cntcon_nom"];
                        $output["cntcon_nom2"] = $row["cntcon_nom2"];

                        $output["tickoc_check1"] = $row["tickoc_check1"];
                        $output["tickoc_check2"] = $row["tickoc_check2"];
                        $output["tickoc_geren"] = $row["tickoc_geren"];
                        $output["tickoc_geren2"] = $row["tickoc_geren2"];

                        $output["estoc_id"] = $row["estoc_id"];
                    }

                }
                echo json_encode($output);
            }

            break;

        case "insertdetalle":
            $datos=$ticketoc->insert_ticketocdetalle(
                $_POST["tickoc_id"],
                $_POST["usu_id"],
                $_POST["tickocd_descrip"],
                $_POST["tickoc_orden"],
                $_POST["tickoc_check1"],
                $_POST["tickoc_check2"],
                $_POST["tickoc_geren"],
                $_POST["tickoc_geren2"]
            );

            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["tickocd_id"] = $row["tickocd_id"];

                    if ($_FILES['files']['name']==0){

                    }else{
                        $countfiles = count($_FILES['files']['name']);
                        $ruta = '../public/filesoc/' . $output["tickocd_id"] . '/';
                        $files_arr = array();

                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }

                        for ($index = 0; $index < $countfiles; $index++) {
                            $doc1 = $_FILES["files"]['tmp_name'][$index];
                            $destino = $ruta . $_FILES["files"]["name"][$index];

                            $ticketoc->insert_ticket_file_oc($output["tickocd_id"], $_FILES["files"]["name"][$index]);

                            move_uploaded_file($doc1, $destino);
                        }
                    }

                }
                echo json_encode($output);
            }
            break;

        case "asignar":
            $ticketoc->asignar_ticketoc($_POST["tickoc_id"],$_POST["usu_asig"]);
            break;

        case "total";
            $datos=$ticketoc->get_ticketoc_total($_POST["grupo_id"],$_POST["sis_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        case "totalabierto";
            $datos=$ticketoc->get_ticketoc_totalabierto($_POST["grupo_id"],$_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        case "totalcerrado";
            $datos=$ticketoc->get_ticketoc_totalcerrado($_POST["grupo_id"],$_POST["sis_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        case "totalsinasignar";
            $datos=$ticketoc->get_ticketoc_totalsinasignar($_POST["grupo_id"],$_POST["sis_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        case "grafico";
            $datos=$ticketoc->get_ticketoc_grafico($_POST["grupo_id"],$_POST["sis_id"]);  
            echo json_encode($datos);
            break;
        
        case "agregar":
            $ticketoc->agregar_ticketoc($_POST["tickoc_id"],$_POST["estoc_id"],$_POST["usu_id"]);
            break;

        case "insertotro":
            $ticketoc->insert_otro_ticketoc($_POST["tickoc_id"]);
            break;

        case "listarestado":
            $datos=$ticketoc->listar_segun_ticket_estado_id($_POST["tickoc_id"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach ($datos as $row) {
                ?>
                    <?php
                        if ($row['tip_id']==16 ){
                            ?>
                                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                                    <thead>
                                        <tr>
                                            <th>Contacto Proveedor</th>
                                            <th>Envio de propuesta</th>
                                            <th>Oc Digitada</th>
                                            <th>Oc Aprobada</th>
                                            <th>OC enviada a proveedor</th>
                                            <th>Material Recepcionado Incompleto en Bodega</th>
                                            <th>Material Recepcionado no conforme</th>
                                            <th>Material Recepcionado Conforme en bodega</th>
                                            <th>Oc Rechazada por Gerencia</th>
                                            <th>Producto No se requiere</th>
                                            <th>Valor no se ajusta al presupuesto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo ($row['fech_contactoprov']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_contactoprov']))); ?></td>
                                            <td><?php echo ($row['fech_envpropuesta']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_envpropuesta']))); ?></td>
                                            <td><?php echo ($row['fech_dig']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_dig']))); ?></td>
                                            <td><?php echo ($row['fech_apro']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_apro']))); ?></td>
                                            <td><?php echo ($row['fech_envprov']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_envprov']))); ?></td>
                                            <td><?php echo ($row['fech_repbode_incompleto']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_repbode_incompleto']))); ?></td>
                                            <td><?php echo ($row['fech_repbode_noconforme']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_repbode_noconforme']))); ?></td>
                                            <td><?php echo ($row['fech_repbode']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_repbode']))); ?></td>
                                            <td><?php echo ($row['fech_rechbode']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_rechbode']))); ?></td>
                                            <td><?php echo ($row['fech_norequiere']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_norequiere']))); ?></td>
                                            <td><?php echo ($row['fech_noajustapresup']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_noajustapresup']))); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php
                        }else if ($row['tip_id']==17){
                            ?>
                                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                                    <thead>
                                        <tr>
                                            <th>Contacto Proveedor</th>
                                            <th>Envio de propuesta</th>
                                            <th>Oc Digitada</th>
                                            <th>Oc Aprobada</th>
                                            <th>OC enviada a proveedor</th>
                                            <th>Servicio realizado Conforme</th>
                                            <th>Servicios no se requiere</th>
                                            <th>Valor no se ajusta al presupuesto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo ($row['fech_contactoprov']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_contactoprov']))); ?></td>
                                            <td><?php echo ($row['fech_envpropuesta']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_envpropuesta']))); ?></td>
                                            <td><?php echo ($row['fech_dig']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_dig']))); ?></td>
                                            <td><?php echo ($row['fech_apro']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_apro']))); ?></td>
                                            <td><?php echo ($row['fech_envprov']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_envprov']))); ?></td>
                                            <td><?php echo ($row['fech_serviconforme']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_serviconforme']))); ?></td>
                                            <td><?php echo ($row['fech_norequiere']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_norequiere']))); ?></td>
                                            <td><?php echo ($row['fech_noajustapresup']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_noajustapresup']))); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php
                        }else if ($row['tip_id']==18){
                            ?>
                                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                                    <thead>
                                        <tr>
                                            <th>Contacto Proveedor</th>
                                            <th>Envio de propuesta</th>
                                            <th>Emitir OC</th>
                                            <th>Producto no se requiere</th>
                                            <th>Valor no se ajusta al presupuesto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo ($row['fech_contactoprov']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_contactoprov']))); ?></td>
                                            <td><?php echo ($row['fech_envpropuesta']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_envpropuesta']))); ?></td>
                                            <td><?php echo ($row['fech_emitiroc']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_emitiroc']))); ?></td>
                                            <td><?php echo ($row['fech_norequiere']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_norequiere']))); ?></td>
                                            <td><?php echo ($row['fech_noajustapresup']=="" ? "" : date("d/m/Y H:i:s", strtotime($row['fech_noajustapresup']))); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php
                        }
                    ?>
                <?php
                }
            }
            break;

    }
?>