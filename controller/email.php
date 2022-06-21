<?php
    /* llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Email.php");
    $email = new Email();
    /* opciones del controlador */
    switch ($_GET["op"]) {
        /*  enviar ticket abierto con el ID */
        case "ticket_abierto":
            $email->ticket_abierto($_POST["tick_id"]);
            break;
        /*  enviar ticket cerrado con el ID */
        case "ticket_cerrado":
            $email->ticket_cerrado($_POST["tick_id"]);
            break;

        case "ticket_cerradooc":
            $email->ticket_cerradooc($_POST["tickoc_id"]);
            break;
        /*  enviar ticket asignado con el ID */
        case "ticket_asignar":
            $email->ticket_asignado($_POST["tick_id"]);
            break;

        case "ticket_asignaroc":
            $email->ticketoc_asignado($_POST["tickoc_id"]);
            break;

        case "ticket_abiertooc":
            $email->ticket_abiertooc($_POST["tickoc_id"]);
            break;

        case "ticket_detalle":
            $email->ticket_detalle($_POST["tick_id"]);
            break;

        case "ticket_detalleoc":
            $email->ticketoc_detalle($_POST["tickoc_id"]);
            break;
    }
?>