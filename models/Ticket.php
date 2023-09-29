<?php
    class Ticket extends Conectar{

        /* Funcion necesaria para insertar un nuevo registro */
        public function insert_ticket($usu_id,$cat_id,$tick_titulo,$tick_descrip,$tick_prio,$area_id,$suba_id,$tip_id,$tick_Planta){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sis_id = $_SESSION["sis_id"];
            //$sql="INSERT INTO tm_ticket (sis_id,tick_corre,usu_id,cat_id,tick_titulo,tick_descrip,tick_estado,tick_prio,area_id,suba_id,fech_cierre,fech_crea,tip_id,est)           VALUES ($sis_id,(SELECT COUNT(*) + 1 FROM tm_ticket WHERE sis_id = $sis_id),?,?,?,?,'Abierto',?,?,?,NULL,getdate(),?,'1');";
            $sql="INSERT INTO tm_ticket (sis_id,tick_corre,usu_id,cat_id,tick_titulo,tick_descrip,tick_estado,tick_prio,area_id,suba_id,fech_cierre,fech_crea,tip_id,est,tick_Planta) VALUES ($sis_id,(SELECT COUNT(*) + 1 FROM tm_ticket WHERE sis_id = $sis_id),?,?,?,?,'Abierto',?,?,?,NULL,getdate(),?,'1',?);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->bindValue(2, $cat_id);
            $sql->bindValue(3, $tick_titulo);
            $sql->bindValue(4, $tick_descrip);
            $sql->bindValue(5, $tick_prio);
            $sql->bindValue(6, $area_id);
            $sql->bindValue(7, $suba_id);
            $sql->bindValue(8, $tip_id);
            $sql->bindValue(9, $tick_Planta);
            $sql->execute();
            /* genera el ultimo id ingresado para alertar en la vista al generar el ticket */
            $sql1="SELECT tick_id,tick_corre FROM tm_ticket WHERE tick_id = @@IDENTITY";
            $sql1=$conectar->prepare($sql1);
            $sql1->execute();
            return $resultado=$sql1->fetchall(pdo::FETCH_ASSOC);
        }

        /* Funcion necesaria para listar ticket por usuario */ 
        public function listar_ticket_x_usu($usu_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="SP_L_TICKET_03 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para listar ticket por grupo */ 
        public function listar_ticket_x_grupo($grupo_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="SP_L_TICKET_04 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $grupo_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para listar ticket sin asignar usuario */ 
        public function listar_ticket_x_asig($usu_asig){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_L_TICKET_05 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_asig);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para listar ticket por id */ 
        public function listar_ticket_x_id($tick_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="SP_L_TICKET_06 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll(pdo::FETCH_ASSOC);
        }

        /* Funcion necesaria para listar ticket totales */ 
        public function listar_ticket(){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_L_TICKET_07";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para listar detalle de ticket x ticket principal */ 
        public function listar_ticketdetalle_x_ticket($tick_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="SELECT td_ticketdetalle.tickd_id,
                td_ticketdetalle.tickd_descrip,
                td_ticketdetalle.fech_crea,
                tm_ticket.tick_prio,
                tm_ticket.fech_cierre,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_usuario.rol_id
                FROM
                td_ticketdetalle
                INNER join tm_usuario on td_ticketdetalle.usu_id = tm_usuario.usu_id
                INNER JOIN tm_ticket on td_ticketdetalle.tick_id = tm_ticket.tick_id
                WHERE
                td_ticketdetalle.tick_id =?
            ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para registrar ticket detalle guardando su id de ticket principal */ 
        public function insert_ticketdetalle($tick_id,$usu_id,$tickd_descrip){
            
            $conectar = parent::conexion();
            /*consulta SQL*/
            $sql = "INSERT INTO td_ticketdetalle (tick_id,usu_id,tickd_descrip,fech_crea,est) VALUES (?,?,?,getdate(),1);";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->bindValue(3, $tickd_descrip);
            $sql->execute();

            /* Obtiene el último ID insertado */
            $lastInsertedId = $conectar->lastInsertId();

            return $lastInsertedId;
        }

        /* Funcion necesaria para insertar una linea adicional para cerrar el ticket en tabla detalle */ 
        public function insert_ticketdetalle_cerrar($tick_id,$usu_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
                $sql="INSERT INTO td_ticketdetalle (tick_id,usu_id,tickd_descrip,fech_crea,est) VALUES (?,?,'Ticket Cerrado...',getdate(),1)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para actualizar ticket */
        public function update_ticket($tick_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="UPDATE tm_ticket
                set
                    fech_cierre = getdate(),
                    tick_estado = 'Cerrado'
                where
                    tick_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para asignar ticket */
        public function asignar_ticket($tick_id,$usu_asig){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="UPDATE tm_ticket
                set
                    usu_asig = ?,
                    usu_asig_est='Si',
                    fech_asig = getdate()
                where
                    tick_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_asig);
            $sql->bindValue(2, $tick_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para total ticket */
        public function get_ticket_total($grupo_id,$sis_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="SELECT
                    COUNT (tm_ticket.tick_id) as TOTAL
                FROM
                tm_ticket
                INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                INNER join tm_area on tm_ticket.area_id = tm_area.area_id
                INNER JOIN tm_subarea on tm_ticket.suba_id = tm_subarea.suba_id
                WHERE
                tm_ticket.est = 1
                AND tm_categoria.grupo_id = ?
                AND tm_ticket.sis_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $grupo_id);
            $sql->bindValue(2, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para asignar ticket abiertos*/
        public function get_ticket_totalabierto($grupo_id,$sis_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="SELECT
                    count (tm_ticket.tick_id) as TOTAL
                FROM
                tm_ticket
                INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                INNER join tm_area on tm_ticket.area_id = tm_area.area_id
                INNER JOIN tm_subarea on tm_ticket.suba_id = tm_subarea.suba_id
                WHERE
                tm_ticket.est = 1
                AND tm_ticket.tick_estado='Abierto'
                AND tm_categoria.grupo_id = ?
                AND tm_ticket.sis_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $grupo_id);
            $sql->bindValue(2, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para asignar cerrados */
        public function get_ticket_totalcerrado($grupo_id,$sis_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="SELECT
                    count (tm_ticket.tick_id) as TOTAL
                FROM
                tm_ticket
                INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                INNER join tm_area on tm_ticket.area_id = tm_area.area_id
                INNER JOIN tm_subarea on tm_ticket.suba_id = tm_subarea.suba_id
                WHERE
                tm_ticket.est = 1
                AND tm_ticket.tick_estado='Cerrado'
                AND tm_categoria.grupo_id = ?
                AND tm_ticket.sis_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $grupo_id);
            $sql->bindValue(2, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para ticket sin asignar*/
        public function get_ticket_totalsinasignar($grupo_id,$sis_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="SELECT
                    count (tm_ticket.tick_id) as TOTAL
                FROM
                tm_ticket
                INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                INNER join tm_area on tm_ticket.area_id = tm_area.area_id
                INNER JOIN tm_subarea on tm_ticket.suba_id = tm_subarea.suba_id
                WHERE
                tm_ticket.est = 1
                AND fech_asig is null
                AND tm_categoria.grupo_id = ?
                AND tm_ticket.sis_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $grupo_id);
            $sql->bindValue(2, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para ticket en grafico dashboard*/
        public function get_ticket_grafico($grupo_id,$sis_id){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket  JOIN
                    tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id
                WHERE
                tm_ticket.est = 1
                AND tm_categoria.grupo_id = ?
                AND tm_ticket.sis_id = ?
                GROUP BY
                tm_categoria.cat_nom
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $grupo_id);
            $sql->bindValue(2, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function update_ticket_opcion($tick_id,$tick_opc){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_U_TICKET_01 ?,?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $tick_opc);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function update_ticket_tipo_categoria($tick_id,$tip_id,$cat_id){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_U_TICKET_02 ?,?,?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $tip_id);
            $sql->bindValue(3, $cat_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function filtro_ticket($tip_id,$area_id,$tick_estado,$usu_asig_est,$sis_id){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_L_TICKET_02 ?,?,?,?,?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tip_id);
            $sql->bindValue(2, $area_id);
            $sql->bindValue(3, $tick_estado);
            $sql->bindValue(4, $usu_asig_est);
            $sql->bindValue(5, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function insert_ticket_file($tickd_id,$tickf_ruta){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_I_TICKETFILE_01 ?,?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickd_id);
            $sql->bindValue(2, $tickf_ruta);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            //return $resultado=$sql->fetchAll();
        }

        public function listar_ticket_file($tickd_id){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_L_TICKETFILE_01 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickd_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

    }
?>