<?php
/* librerias necesarias para que el proyecto pueda enviar emails */
require('class.phpmailer.php');
include("class.smtp.php");

/* llamada de las clases necesarias que se usaran en el envio del mail */
require_once("../config/conexion.php");
require_once("../Models/Ticket.php");
require_once("../Models/Ticketoc.php");
require_once("../Models/Usuario.php");

class Email  extends PHPMailer
{

    /* funcion para la alerta de un ticket abierto mas adelante se uasara en el controllador */
    public function ticket_abierto($tick_id)
    {
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row) {
            $id = $row["tick_corre"];
            $usu = $row["usu_nom"];
            $usuapellido = $row["usu_ape"];
            $titulo = $row["tick_titulo"];
            $prioridad = $row["tick_prio"];
            $categoria = $row["cat_nom"];
            $area = $row["area_nom"];
            $subarea= $row["suba_nom"];
            $correo = $row["usu_correo"];
            $descripcion= $row["tick_descrip"];
            $planta=$row["tick_Planta"];
            $fechacreacion= $row["FechaCorta"];

            $sis_nom = $row["sis_nom"];
            $tip_nom = $row["tip_nom"];
            $correla = $row["tick_corre"];

            $gCorreo = $row["sis_correo"];
            $gContrasena = $row["sis_correo_pass"];

            $usu_dominio = $row["usu_dominio"];

            $usu_grupal = $row["usu_grupal"];
        }

        $ruta = new Conectar();
        $rut = $ruta->ruta();

        if($usu_dominio == "agente.cl"){
            //Nada
        }else{
            $this->IsSMTP();
            $this->Host = 'smtp.office365.com';//Aqui el server
            $this->Port = 587;//Aqui el puerto
            $this->SMTPAuth = true;
            $this->Username = $gCorreo;
            $this->Password = $gContrasena;
            $this->From = $gCorreo;
            $this->SMTPSecure = 'tls';
            $this->FromName = $this->tu_nombre = "Ticket Abierto N° ".$correla." - ".$tip_nom;
            $this->CharSet = 'UTF8';
            $this->addAddress($correo);
            
            /* Correo Grupal para alerta */
            $this->addAddress($usu_grupal);
            
            $this->WordWrap = 50;
            $this->IsHTML(true);
            /* $this->Subject = "Ticket Abierto"; */
            $this->Subject = $this->tu_nombre = "Ticket Abierto N° ".$correla." - ".$tip_nom;
            /* Ruta del template en formato HTML */
            $cuerpo = file_get_contents('../public/NuevoTicket.html'); 
            /* parametros del template a remplazar */
            $cuerpo = str_replace('xnroticket', $id, $cuerpo);
            $cuerpo = str_replace('lblNomUsu', $usu, $cuerpo);
            $cuerpo = str_replace('lblApellidoUsu', $usuapellido, $cuerpo);
            $cuerpo = str_replace('fech_crea', $fechacreacion, $cuerpo);
            $cuerpo = str_replace('lblTitu', $titulo, $cuerpo);
            $cuerpo = str_replace('lblPrio', $prioridad, $cuerpo);
            $cuerpo = str_replace('lblPlanta', $planta, $cuerpo);
            $cuerpo = str_replace('lblCate', $categoria, $cuerpo);
            $cuerpo = str_replace('lblAre', $area, $cuerpo);
            $cuerpo = str_replace('lblsubarea', $subarea, $cuerpo);
            $cuerpo = str_replace('lblDescripcion', $descripcion, $cuerpo);
            $cuerpo = str_replace('lblsisnom', $sis_nom, $cuerpo);
            $cuerpo = str_replace('lblruta', $rut.'view/DetalleTicket/?ID='.$tick_id, $cuerpo);

            $this->Body = $cuerpo;
            $this->IsHTML(true);
            $this->AltBody = strip_tags("Ticket Abierto");
            return $this->Send();
        }
    }

    public function ticket_abiertooc($tickoc_id)
    {
        $ticketoc = new Ticketoc();
        $datos = $ticketoc->listar_ticketoc_x_id($tickoc_id);
        foreach ($datos as $row) {
            $id = $row["tickoc_corre"];
            $usu = $row["usu_nom"];
            $titulo = $row["tickoc_titulo"];
            /* $prioridad = $row["tickoc_prio"]; */
            $categoria = $row["cat_nom"];
            $area = $row["area_nom"];
            $correo = $row["usu_correo"];
            $sis_nom = $row["sis_nom"];
            $tip_nom = $row["tip_nom"];
            $correla = $row["tickoc_corre"];

            $gCorreo = $row["sis_correo"];
            $gContrasena = $row["sis_correo_pass"];

            $usu_grupal = $row["usu_grupal"];
        }

        $ruta = new Conectar();
        $rut = $ruta->ruta();

    
        $this->IsSMTP();
        $this->Host = 'smtp.office365.com';//Aqui el server
        $this->Port = 587;//Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $gCorreo;
        $this->Password = $gContrasena;
        $this->From = $gCorreo;
        $this->SMTPSecure = 'tls';
        $this->FromName = $this->tu_nombre = "Ticket Abierto N° ".$correla." - ".$tip_nom;
        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        /* $this->addAddress("wzuniga@ranco.cl"); */
        
        /* Correo Grupal para alerta */
        $this->addAddress($usu_grupal);
        
        $this->WordWrap = 50;
        $this->IsHTML(true);
        /* $this->Subject = "Ticket Abierto"; */
        $this->Subject = $this->tu_nombre = "Ticket OC N° ".$correla." - ".$tip_nom;
        /* Ruta del template en formato HTML */
        $cuerpo = file_get_contents('../public/NuevoTicketoc.html'); 
        /* parametros del template a remplazar */
        $cuerpo = str_replace('xnroticket', $id, $cuerpo);
        $cuerpo = str_replace('lblNomUsu', $usu, $cuerpo);
        $cuerpo = str_replace('lblTitu', $titulo, $cuerpo);
        /* $cuerpo = str_replace('lblPrio', $prioridad, $cuerpo); */
        $cuerpo = str_replace('lblCate', $categoria, $cuerpo);
        $cuerpo = str_replace('lblAre', $area, $cuerpo);
        $cuerpo = str_replace('lblsisnom', $sis_nom, $cuerpo);
        $cuerpo = str_replace('lblruta', $rut.'view/DetalleTicketoc/?ID='.$tickoc_id, $cuerpo);

        $this->Body = $cuerpo;
        $this->IsHTML(true);
        $this->AltBody = strip_tags("Ticket OC");
        return $this->Send();
    }

    /* funcion para alertar cuando un ticket a sido cerrado */
    public function ticket_cerrado($tick_id)
    {
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row) {
            $id = $row["tick_corre"];
            $usu = $row["usu_nom"];
            $titulo = $row["tick_titulo"];
            $prioridad = $row["tick_prio"];
            $categoria = $row["cat_nom"];
            $area = $row["area_nom"];
            $descripcion= $row["tick_descrip"];
            $correo = $row["usu_correo"];
            $planta=$row["tick_Planta"];
            $fechacreacion= $row["fech_crea"];

            $gCorreo = $row["sis_correo"];
            $gContrasena = $row["sis_correo_pass"];

            $usu_dominio = $row["usu_dominio"];

            $usu_grupal = $row["usu_grupal"];
        }

        $ruta = new Conectar();
        $rut = $ruta->ruta();

        if($usu_dominio == "agente.cl"){
            //Nada
        }else{
            $this->IsSMTP();
            $this->Host = 'smtp.office365.com';
            $this->Port = 587;
            $this->SMTPAuth = true;
            $this->Username = $gCorreo;
            $this->Password = $gContrasena;
            $this->From = $gCorreo;
            $this->SMTPSecure = 'tls';
            $this->FromName = $this->tu_nombre = "Ticket Cerrado";
            $this->CharSet = 'UTF8';
            $this->addAddress($correo);
            /* Correo Grupal para alerta */
            /* $this->addAddress($usu_grupal); */
            $this->WordWrap = 50;
            $this->IsHTML(true);
            $this->Subject = "Ticket Cerrado";
            /* Ruta del template en formato HTML */
            $cuerpo = file_get_contents('../public/CerradoTicket.html');
            /* parametros del template a remplazar */
            $cuerpo = str_replace('xnroticket', $id, $cuerpo);
            $cuerpo = str_replace('lblNomUsu', $usu, $cuerpo);
            $cuerpo = str_replace('lblTitu', $titulo, $cuerpo);
            $cuerpo = str_replace('lblPrio', $prioridad, $cuerpo);
            $cuerpo = str_replace('lblCate', $categoria, $cuerpo);
            $cuerpo = str_replace('lblAre', $area, $cuerpo);
            $cuerpo = str_replace('lblDescripcion', $descripcion, $cuerpo);
            $cuerpo = str_replace('lblruta', $rut.'view/DetalleTicket/?ID='.$tick_id, $cuerpo);
            $this->Body = $cuerpo;
            $this->IsHTML(true);
            $this->AltBody = strip_tags("Ticket Cerrado");
            return $this->Send();
        }
    }

    /* funcion para alertar cuando un ticket a sido cerrado */
    public function ticket_cerradooc($tickoc_id)
    {
        $ticketoc = new Ticketoc();
        $datos = $ticketoc->listar_ticketoc_x_id($tickoc_id);
        foreach ($datos as $row) {
            $id = $row["tickoc_corre"];
            $usu = $row["usu_nom"];
            $titulo = $row["tickoc_titulo"];
            /* $prioridad = $row["tickoc_prio"]; */
            $categoria = $row["cat_nom"];
            $area = $row["area_nom"];
            $correo = $row["usu_correo"];
            $sis_nom = $row["sis_nom"];
            $tip_nom = $row["tip_nom"];
            $correla = $row["tickoc_corre"];
            $usu_dominio = $row["usu_dominio"];

            $gCorreo = $row["sis_correo"];
            $gContrasena = $row["sis_correo_pass"];

            $usu_grupal = $row["usu_grupal"];
        }

        $ruta = new Conectar();
        $rut = $ruta->ruta();

        if($usu_dominio == "agente.cl"){
            //Nada
        }else{
            $this->IsSMTP();
            $this->Host = 'smtp.office365.com';
            $this->Port = 587;
            $this->SMTPAuth = true;
            $this->Username = $gCorreo;
            $this->Password = $gContrasena;
            $this->From = $gCorreo;
            $this->SMTPSecure = 'tls';
            $this->FromName = $this->tu_nombre = "Ticket Cerrado";
            $this->CharSet = 'UTF8';
            $this->addAddress($correo);
            /* Correo Grupal para alerta */
            /* $this->addAddress($usu_grupal); */
            $this->WordWrap = 50;
            $this->IsHTML(true);
            $this->Subject = "Ticket Cerrado";
            /* Ruta del template en formato HTML */
            $cuerpo = file_get_contents('../public/CerradoTicketoc.html');
            /* parametros del template a remplazar */
            $cuerpo = str_replace('xnroticket', $id, $cuerpo);
            $cuerpo = str_replace('lblNomUsu', $usu, $cuerpo);
            $cuerpo = str_replace('lblTitu', $titulo, $cuerpo);
            $cuerpo = str_replace('lblCate', $categoria, $cuerpo);
            $cuerpo = str_replace('lblAre', $area, $cuerpo);
            $cuerpo = str_replace('lblruta', $rut.'view/DetalleTicket/?ID='.$tickoc_id, $cuerpo);
            $this->Body = $cuerpo;
            $this->IsHTML(true);
            $this->AltBody = strip_tags("Ticket Cerrado");
            return $this->Send();
        }
    }

    /* funcion para poder alertar que el ticket a sido asignado */
    public function ticket_asignado($tick_id)
    {
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row) {
            $id = $row["tick_corre"];
            $usu = $row["usu_nom"];
            $titulo = $row["tick_titulo"];
            $prioridad = $row["tick_prio"];
            $categoria = $row["cat_nom"];
            $area = $row["area_nom"];
            $descripcion= $row["tick_descrip"];
            $asignado = $row["usu_asig"];
            $planta=$row["tick_Planta"];
            $usuapellido = $row["usu_ape"];
            $subarea= $row["suba_nom"];
            $fechacreacion= $row["FechaCorta"];


            $gCorreo = $row["sis_correo"];
            $gContrasena = $row["sis_correo_pass"];

            $usu_grupal = $row["usu_grupal"];
        }

        $ruta = new Conectar();
        $rut = $ruta->ruta();

        $usuario = new Usuario();
        $datos1 = $usuario->get_usuario_x_id($asignado);
        foreach ($datos1 as $row1) {
            $correoasignado = $row1["usu_correo"];
            $usu_dominio = $row1["usu_dominio"];
        }

        if($usu_dominio == "agente.cl"){
            //Nada
        }else{

            $this->IsSMTP();
            $this->Host = 'smtp.office365.com';
            $this->Port = 587;
            $this->SMTPAuth = true;
            $this->Username = $gCorreo;
            $this->Password = $gContrasena;
            $this->From = $gCorreo;
            $this->SMTPSecure = 'tls';
            $this->FromName = $this->tu_nombre = "Ticket Asignado";
            $this->CharSet = 'UTF8';
            $this->addAddress($correoasignado);
            /* Correo Grupal para alerta */
            /* $this->addAddress($usu_grupal); */
            $this->WordWrap = 50;
            $this->IsHTML(true);
            $this->Subject = "Ticket Asignado";
            /* Ruta del template en formato HTML */
            $cuerpo = file_get_contents('../public/AsignarTicket.html');
            /* parametros del template a remplazar */
            $cuerpo = str_replace('xnroticket', $id, $cuerpo);
            $cuerpo = str_replace('lblNomUsu', $usu, $cuerpo);
            $cuerpo = str_replace('lblApellidoUsu', $usuapellido, $cuerpo);
            $cuerpo = str_replace('fech_crea', $fechacreacion, $cuerpo);
            $cuerpo = str_replace('lblTitu', $titulo, $cuerpo);
            $cuerpo = str_replace('lblPrio', $prioridad, $cuerpo);
            $cuerpo = str_replace('lblCate', $categoria, $cuerpo);
            $cuerpo = str_replace('lblAre', $area, $cuerpo);
            $cuerpo = str_replace('lblsubarea', $subarea, $cuerpo);
            $cuerpo = str_replace('lblPlanta', $planta, $cuerpo);
            $cuerpo = str_replace('lblDescripcion', $descripcion, $cuerpo);
            $cuerpo = str_replace('lblruta', $rut.'view/DetalleTicket/?ID='.$tick_id, $cuerpo);
            $this->Body = $cuerpo;
            $this->IsHTML(true);
            $this->AltBody = strip_tags("Ticket Asignado");
            return $this->Send();
        }
    }

    public function ticketoc_asignado($tickoc_id)
    {
        $ticketoc = new Ticketoc();
        $datos = $ticketoc->listar_ticketoc_x_id($tickoc_id);
        foreach ($datos as $row) {
            $id = $row["tickoc_corre"];
            $usu = $row["usu_nom"];
            $titulo = $row["tickoc_titulo"];
            $categoria = $row["cat_nom"];
            $area = $row["area_nom"];
            $asignado = $row["usu_asig"];

            $gCorreo = $row["sis_correo"];
            $gContrasena = $row["sis_correo_pass"];

            $usu_grupal = $row["usu_grupal"];
        }

        $ruta = new Conectar();
        $rut = $ruta->ruta();

        $usuario = new Usuario();
        $datos1 = $usuario->get_usuario_x_id($asignado);
        foreach ($datos1 as $row1) {
            $correoasignado = $row1["usu_correo"];
            $usu_dominio = $row1["usu_dominio"];
        }

        $this->IsSMTP();
        $this->Host = 'smtp.office365.com';
        $this->Port = 587;
        $this->SMTPAuth = true;
        $this->Username = $gCorreo;
        $this->Password = $gContrasena;
        $this->From = $gCorreo;
        $this->SMTPSecure = 'tls';
        $this->FromName = $this->tu_nombre = "Ticket Asignado";
        $this->CharSet = 'UTF8';
        $this->addAddress($correoasignado);
        
        
        /* Correo Grupal para alerta */
        /* $this->addAddress($usu_grupal); */
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Ticket Asignado";
        /* Ruta del template en formato HTML */
        $cuerpo = file_get_contents('../public/AsignarTicketoc.html');
        /* parametros del template a remplazar */
        $cuerpo = str_replace('xnroticket', $id, $cuerpo);
        $cuerpo = str_replace('lblNomUsu', $usu, $cuerpo);
        $cuerpo = str_replace('lblTitu', $titulo, $cuerpo);
        $cuerpo = str_replace('lblCate', $categoria, $cuerpo);
        $cuerpo = str_replace('lblAre', $area, $cuerpo);
        $cuerpo = str_replace('lblruta', $rut.'view/DetalleTicketoc/?ID='.$tickoc_id, $cuerpo);
        $this->Body = $cuerpo;
        $this->IsHTML(true);
        $this->AltBody = strip_tags("Ticket Asignado");
        return $this->Send();

    }

    public function ticket_detalle($tick_id)
    {
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row) {
            $id = $row["tick_corre"];
            $usu = $row["usu_nom"];
            $titulo = $row["tick_titulo"];
            $prioridad = $row["tick_prio"];
            $categoria = $row["cat_nom"];
            $area = $row["area_nom"];
            $correo = $row["usu_correo"];
            $descripcion= $row["tick_descrip"];
            $planta=$row["tick_Planta"];

            $sis_nom = $row["sis_nom"];
            $tip_nom = $row["tip_nom"];
            $correla = $row["tick_corre"];

            $gCorreo = $row["sis_correo"];
            $gContrasena = $row["sis_correo_pass"];

            $usu_dominio = $row["usu_dominio"];

            $usu_grupal = $row["usu_grupal"];
            $asignado = $row["usu_asig"];
        }

        $datos2 = $ticket->listar_ticketdetalle_x_ticket($tick_id);
        $tbodyFinal = '';
        foreach ($datos2 as $row2) {
            $tbodyFinal .=
            '<tr style="border-bottom:1px dotted;">
                <td width="100" valign="top"><b>' . $row2['usu_nom'] .' '.$row2['usu_ape']. '</b></font></td>
                <td width="100" valign="top">' . date('d/m/Y H:i',strtotime($row2['fech_crea'])) . '</font></td>
                <td style="font-size: 12px; font-family: calibri" valign="top">' . $row2['tickd_descrip'] . '</font></td>
            </tr>';
        }

        $ruta = new Conectar();
        $rut = $ruta->ruta();
        $usuario = new Usuario();
        $datos1 = $usuario->get_usuario_x_id($asignado);
        foreach ($datos1 as $row1) {
            $correoasignado = $row1["usu_correo"];
            $usu_dominio = $row1["usu_dominio"];
        }

        if($usu_dominio == "agente.cl"){
            //Nada
        }else{
            $this->IsSMTP();
            $this->Host = 'smtp.office365.com';//Aqui el server
            $this->Port = 587;//Aqui el puerto
            $this->SMTPAuth = true;
            $this->Username = $gCorreo;
            $this->Password = $gContrasena;
            $this->From = $gCorreo;
            $this->SMTPSecure = 'tls';
            $this->FromName = $this->tu_nombre = "Ticket Abierto N° ".$correla." - ".$tip_nom;
            $this->CharSet = 'UTF8';
            $this->addAddress($correo);
            $this->addAddress($correoasignado);
            
            /* Correo Grupal para alerta */
            /* $this->addAddress($usu_grupal); */

            $this->WordWrap = 50;
            $this->IsHTML(true);
            /* $this->Subject = "Ticket Abierto"; */
            $this->Subject = $this->tu_nombre = "Ticket Nuevo Comentario N° ".$correla." - ".$tip_nom;
            /* Ruta del template en formato HTML */
            $cuerpo = file_get_contents('../public/NuevoTicketDetalle.html'); 
            /* parametros del template a remplazar */
            $cuerpo = str_replace('xnroticket', $id, $cuerpo);
            $cuerpo = str_replace('lblNomUsu', $usu, $cuerpo);
            $cuerpo = str_replace('lblTitu', $titulo, $cuerpo);
            $cuerpo = str_replace('lblPrio', $prioridad, $cuerpo);
            $cuerpo = str_replace('lblCate', $categoria, $cuerpo);
            $cuerpo = str_replace('lblAre', $area, $cuerpo);
            $cuerpo = str_replace('lblDescripcion', $descripcion, $cuerpo);
            $cuerpo = str_replace('lblsisnom', $sis_nom, $cuerpo);
            $cuerpo = str_replace('tbodyFinal', $tbodyFinal, $cuerpo);
            $cuerpo = str_replace('lblruta', $rut.'view/DetalleTicket/?ID='.$tick_id, $cuerpo);

            $this->Body = $cuerpo;
            $this->IsHTML(true);
            $this->AltBody = strip_tags("Ticket Abierto");
            return $this->Send();
        }
    }

    public function ticketoc_detalle($tickoc_id)
    {
        $ticketoc = new Ticketoc();
        $datos = $ticketoc->listar_ticketoc_x_id($tickoc_id);
        foreach ($datos as $row) {
            $id = $row["tickoc_corre"];
            $usu = $row["usu_nom"];
            $titulo = $row["tickoc_titulo"];
            $prioridad = $row["tickoc_prio"];
            $categoria = $row["cat_nom"];
            $area = $row["area_nom"];
            $correo = $row["usu_correo"];
            $sis_nom = $row["sis_nom"];
            $tip_nom = $row["tip_nom"];
            $correla = $row["tickoc_corre"];

            $gCorreo = $row["sis_correo"];
            $gContrasena = $row["sis_correo_pass"];

            $usu_dominio = $row["usu_dominio"];

            $usu_grupal = $row["usu_grupal"];
            $asignado = $row["usu_asig"];
        }

        $datos2 = $ticketoc->listar_ticketocdetalle_x_ticketoc($tickoc_id);
        $tbodyFinal = '';
        foreach ($datos2 as $row2) {
            $tbodyFinal .=
            '<tr style="border-bottom:1px dotted;">
                <td width="100" valign="top"><b>' . $row2['usu_nom'] .' '.$row2['usu_ape']. '</b></td>
                <td width="100" valign="top">' . date('d/m/Y H:i',strtotime($row2['fech_crea'])) . '</td>
                <td style="font-size: 12px; font-family: calibri" valign="top">' . $row2['tickocd_descrip'] . '  </td>
            </tr>';
        }

        $ruta = new Conectar();
        $rut = $ruta->ruta();

        $usuario = new Usuario();
        $datos1 = $usuario->get_usuario_x_id($asignado);
        foreach ($datos1 as $row1) {
            $correoasignado = $row1["usu_correo"];
            $usu_dominio = $row1["usu_dominio"];
        }

        if($usu_dominio == "agente.cl"){
            //Nada
        }else{
            $this->IsSMTP();
            $this->Host = 'smtp.office365.com';//Aqui el server
            $this->Port = 587;//Aqui el puerto
            $this->SMTPAuth = true;
            $this->Username = $gCorreo;
            $this->Password = $gContrasena;
            $this->From = $gCorreo;
            $this->SMTPSecure = 'tls';
            $this->FromName = $this->tu_nombre = "Ticket Abierto N° ".$correla." - ".$tip_nom;
            $this->CharSet = 'UTF8';
            $this->addAddress($correo);
            $this->addAddress($correoasignado);
            
            /* Correo Grupal para alerta */
            /* $this->addAddress($usu_grupal); */

            $this->WordWrap = 50;
            $this->IsHTML(true);
            /* $this->Subject = "Ticket Abierto"; */
            $this->Subject = $this->tu_nombre = "OC Nuevo Comentario N° ".$correla." - ".$tip_nom;
            /* Ruta del template en formato HTML */
            $cuerpo = file_get_contents('../public/NuevoTicketDetalleoc.html'); 
            /* parametros del template a remplazar */
            $cuerpo = str_replace('xnroticket', $id, $cuerpo);
            $cuerpo = str_replace('lblNomUsu', $usu, $cuerpo);
            $cuerpo = str_replace('lblTitu', $titulo, $cuerpo);
            $cuerpo = str_replace('lblPrio', $prioridad, $cuerpo);
            $cuerpo = str_replace('lblCate', $categoria, $cuerpo);
            $cuerpo = str_replace('lblAre', $area, $cuerpo);
            $cuerpo = str_replace('lblsisnom', $sis_nom, $cuerpo);
            $cuerpo = str_replace('tbodyFinal', $tbodyFinal, $cuerpo);
            $cuerpo = str_replace('lblruta', $rut.'view/DetalleTicketoc/?ID='.$tickoc_id, $cuerpo);

            $this->Body = $cuerpo;
            $this->IsHTML(true);
            $this->AltBody = strip_tags("OC Abierto");
            return $this->Send();
        }
    }

    public function ticket_abiertoResponsablesoc($tickoc_id)
    {
        $ticketoc = new Ticketoc();
        $datos = $ticketoc->listar_ticketoc_x_id($tickoc_id);
        foreach ($datos as $row) {
            $id = $row["tickoc_corre"];
            $usu = $row["usu_nom"];
            $titulo = $row["tickoc_titulo"];
            /* $prioridad = $row["tickoc_prio"]; */
            $categoria = $row["cat_nom"];
            $area = $row["area_nom"];
            $subarea = $row["suba_nom"];
            $correo = $row["usu_correo"];
            $descripcion= $row["tickoc_descrip"];

            $sis_nom = $row["sis_nom"];
            $tip_nom = $row["tip_nom"];
            $correla = $row["tickoc_corre"];

            $gCorreo = $row["sis_correo"];
            $gContrasena = $row["sis_correo_pass"];

            //$usu_grupal = $row["usu_grupal"];

            $CorreoGerente_Responsable= $row["area_correo_geren"];
            $CorreoJefatura_Responsable = $row["suba_correo_geren"];
        }

        $ruta = new Conectar();
        $rut = $ruta->ruta();

    
        $this->IsSMTP();
        $this->Host = 'smtp.office365.com';//Aqui el server
        $this->Port = 587;//Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $gCorreo;
        $this->Password = $gContrasena;
        $this->From = $gCorreo;
        $this->SMTPSecure = 'tls';
        $this->FromName = $this->tu_nombre = "Aviso Para Gerencia y Jefatura-Ticket Abierto OC N° ".$correla." - ".$tip_nom;
        $this->CharSet = 'UTF8';

        $this->addAddress($CorreoGerente_Responsable);
        $this->addAddress($CorreoJefatura_Responsable);
        
        /* $this->addAddress($correo); */
        /* $this->addAddress("wzuniga@ranco.cl"); */
        
        /* Correo Grupal para alerta */
        /* $this->addAddress($usu_grupal); */

        $this->WordWrap = 50;
        $this->IsHTML(true);
        /* $this->Subject = "Ticket Abierto"; */
        $this->Subject = $this->tu_nombre = "Aviso Para Gerencia y Jefatura-Ticket Abierto OC N° ".$correla." - ".$tip_nom;
        /* Ruta del template en formato HTML */
        $cuerpo = file_get_contents('../public/NuevoTicketocResponsable.html'); 
        /* parametros del template a remplazar */
        $cuerpo = str_replace('xnroticket', $id, $cuerpo);
        $cuerpo = str_replace('lblNomUsu', $usu, $cuerpo);
        $cuerpo = str_replace('lblTitu', $titulo, $cuerpo);
        /* $cuerpo = str_replace('lblPrio', $prioridad, $cuerpo); */
        $cuerpo = str_replace('lblCate', $categoria, $cuerpo);
        $cuerpo = str_replace('lblAre', $area, $cuerpo);
        $cuerpo = str_replace('lblSubAre', $subarea, $cuerpo);
        $cuerpo = str_replace('lblDescripcion', $descripcion, $cuerpo);
        $cuerpo = str_replace('lblsisnom', $sis_nom, $cuerpo);
        $cuerpo = str_replace('lblruta', $rut.'view/DetalleTicketoc/?ID='.$tickoc_id, $cuerpo);

        $this->Body = $cuerpo;
        $this->IsHTML(true);
        $this->AltBody = strip_tags("Ticket OC");
        return $this->Send();
    }

    public function ticket_cerradoResponsablesoc($tickoc_id)
    {
        $ticketoc = new Ticketoc();
        $datos = $ticketoc->listar_ticketoc_x_id($tickoc_id);
        foreach ($datos as $row) {
            $id = $row["tickoc_corre"];
            $usu = $row["usu_nom"];
            $titulo = $row["tickoc_titulo"];
            /* $prioridad = $row["tickoc_prio"]; */
            $categoria = $row["cat_nom"];
            $area = $row["area_nom"];
            $subarea = $row["suba_nom"];
            $correo = $row["usu_correo"];
            $descripcion= $row["tickoc_descrip"];

            $sis_nom = $row["sis_nom"];
            $tip_nom = $row["tip_nom"];
            $correla = $row["tickoc_corre"];

            $gCorreo = $row["sis_correo"];
            $gContrasena = $row["sis_correo_pass"];

            //$usu_grupal = $row["usu_grupal"];

            $CorreoGerente_Responsable= $row["area_correo_geren"];
            $CorreoJefatura_Responsable = $row["suba_correo_geren"];
        }

        $ruta = new Conectar();
        $rut = $ruta->ruta();

    
        $this->IsSMTP();
        $this->Host = 'smtp.office365.com';//Aqui el server
        $this->Port = 587;//Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $gCorreo;
        $this->Password = $gContrasena;
        $this->From = $gCorreo;
        $this->SMTPSecure = 'tls';
        $this->FromName = $this->tu_nombre = "Aviso Para Gerencia y Jefatura Ticket Cerrado N° ".$correla." - ".$tip_nom;
        $this->CharSet = 'UTF8';

        $this->addAddress($CorreoGerente_Responsable);
        $this->addAddress($CorreoJefatura_Responsable);
        
        /* $this->addAddress($correo); */
        /* $this->addAddress("wzuniga@ranco.cl"); */
        
        /* Correo Grupal para alerta */
        /* $this->addAddress($usu_grupal); */

        $this->WordWrap = 50;
        $this->IsHTML(true);
        /* $this->Subject = "Ticket Abierto"; */
        $this->Subject = $this->tu_nombre = "Aviso Para Gerencia y Jefatura-Ticket Cerrado OC N° ".$correla." - ".$tip_nom;
        /* Ruta del template en formato HTML */
        $cuerpo = file_get_contents('../public/CerradoTicketocResponsables.html'); 
        /* parametros del template a remplazar */
        $cuerpo = str_replace('xnroticket', $id, $cuerpo);
        $cuerpo = str_replace('lblNomUsu', $usu, $cuerpo);
        $cuerpo = str_replace('lblTitu', $titulo, $cuerpo);
        /* $cuerpo = str_replace('lblPrio', $prioridad, $cuerpo); */
        $cuerpo = str_replace('lblCate', $categoria, $cuerpo);
        $cuerpo = str_replace('lblAre', $area, $cuerpo);
        $cuerpo = str_replace('lblSubAre', $subarea, $cuerpo);
        $cuerpo = str_replace('lblsisnom', $sis_nom, $cuerpo);
        $cuerpo = str_replace('lblDescripcion', $descripcion, $cuerpo);
        $cuerpo = str_replace('lblruta', $rut.'view/DetalleTicketoc/?ID='.$tickoc_id, $cuerpo);

        $this->Body = $cuerpo;
        $this->IsHTML(true);
        $this->AltBody = strip_tags("Ticket OC");
        return $this->Send();
    }
    
}
