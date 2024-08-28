<?php
    class Ticketoc extends Conectar{

        /* Funcion necesaria para insertar un nuevo registro */
        public function insert_ticketoc($usu_id,$cat_id,$tickoc_titulo,$tickoc_descrip,$area_id,$suba_id,$tip_id,$ent_id,$cntcon_id,$dura_id,$tickoc_coti_cerra,$tick_Planta,$tiempoesperado_id,$opcionescotizacion_id,$valor_estimado){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sis_id = $_SESSION["sis_id"];
            $sql="INSERT INTO tm_ticket_oc (sis_id,tickoc_corre,usu_id,cat_id,tickoc_titulo,tickoc_descrip,tickoc_estado,area_id,suba_id,fech_cierre,fech_crea,tip_id,ent_id,cntcon_id,dura_id,tickoc_coti_cerra,est,tick_Planta,tiempoesperado_id,opcionescotizacion_id,valor_estimado) 
                    VALUES ($sis_id,(SELECT COUNT(*) + 1 FROM tm_ticket_oc WHERE sis_id = $sis_id),?,?,?,?,'Abierto',?,?,NULL,getdate(),?,?,?,?,?,'1',?,?,?,?);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->bindValue(2, $cat_id);
            $sql->bindValue(3, $tickoc_titulo);
            $sql->bindValue(4, $tickoc_descrip);
            $sql->bindValue(5, $area_id);
            $sql->bindValue(6, $suba_id);
            $sql->bindValue(7, $tip_id);
            $sql->bindValue(8, $ent_id);
            $sql->bindValue(9, $cntcon_id);
            $sql->bindValue(10, $dura_id);
            $sql->bindValue(11, $tickoc_coti_cerra);
            $sql->bindValue(12, $tick_Planta);
            $sql->bindValue(13, $tiempoesperado_id);
            $sql->bindValue(14, $opcionescotizacion_id);
            $sql->bindValue(15, $valor_estimado);
            $sql->execute();
            /* genera el ultimo id ingresado para alertar en la vista al generar el ticket */
            $sql1="SELECT tickoc_id,tickoc_corre FROM tm_ticket_oc WHERE tickoc_id = @@IDENTITY";
            $sql1=$conectar->prepare($sql1);
            $sql1->execute();
            return $resultado=$sql1->fetchall(pdo::FETCH_ASSOC);
        }

        public function insert_otro_ticketoc($tickoc_id){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="INSERT INTO tm_ticket_oc_estOC (tickoc_id,est) VALUES (?,1)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickoc_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll(pdo::FETCH_ASSOC);
        }

        /* Funcion necesaria para listar ticket por usuario */ 
        /* TODO:03/22 SP Actualizado */
        public function listar_ticketoc_x_usu($usu_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
                    $sql="SELECT DISTINCT     
                    oc.tickoc_id,                    
                    oc.usu_id,                                     
                    oc.tickoc_titulo,                    
                    oc.tickoc_descrip,                    
                    oc.tickoc_estado,                                      
                    oc.fech_cierre,                    
                    oc.fech_crea,     
                    oc.tip_id,                    
                    u.usu_nom,                    
                    u.usu_ape,
                    CONCAT(u.usu_nom, ' ', u.usu_ape) AS Solicitante,                  
                    a.area_id,                    
                    a.area_nom,                    
                    oc.usu_asig,                    
                    oc.usu_asig_est,                    
                    s.suba_nom,                  
                    t.tip_nom,                   
                    oc.tickoc_corre,              
                    ocest.tickoc_orden,              
                    ocest.fech_dig,              
                    ocest.fech_apro,              
                    ocest.fech_envprov,              
                    ocest.fech_repbode,              
                    ocest.fech_rechbode,          
                    ocest.estoc_id,              
                    est.estoc_nom2,        
                    asig.usu_nom AS usu_nom_asig,                    
                    asig.usu_ape AS usu_ape_asig,  
                    oc.tick_Planta,
                    tm_tiempoEsperado.TiempoEsperado_nom,
                    tm_OpcionesCotizacion.OpcionesCotizacion_nom,
                    oc.valor_estimado,
                    tm_entrega.ent_nom,
                    STRING_AGG(no.numeroOrdenAsignado, '-') AS numeroOrdenAsignado
                FROM                    
                    tm_ticket_oc oc                                      
                    INNER JOIN tm_usuario u ON oc.usu_id = u.usu_id         
                    LEFT JOIN tm_usuario asig ON oc.usu_asig = asig.usu_id         
                    INNER JOIN tm_area a ON oc.area_id = a.area_id                    
                    INNER JOIN tm_subarea s ON oc.suba_id = s.suba_id                    
                    INNER JOIN tm_tipo t ON oc.tip_id = t.tip_id              
                    LEFT JOIN tm_ticket_oc_estOC ocest ON oc.tickoc_id = ocest.tickoc_id           
                    LEFT JOIN tm_estado_oc est ON ocest.estoc_id = est.estoc_id 
                    LEFT JOIN tm_tiempoEsperado ON oc.TiempoEsperado_id = tm_tiempoEsperado.TiempoEsperado_id
                    LEFT JOIN tm_OpcionesCotizacion ON oc.opcionescotizacion_id = tm_OpcionesCotizacion.OpcionesCotizacion_id 
                    LEFT JOIN tm_entrega ON oc.ent_id = tm_entrega.ent_id
                    LEFT JOIN td_NumeroOrdenes no ON oc.tickoc_id = no.tickoc_id 
                WHERE                    
                    oc.est = 1 AND u.usu_id = ?
                    
                GROUP BY
                    oc.tickoc_id,                    
                    oc.usu_id,                    
                    oc.tickoc_titulo,                    
                    oc.tickoc_descrip,                    
                    oc.tickoc_estado,                    
                    oc.fech_cierre,                    
                    oc.fech_crea,    
                    oc.tip_id,                    
                    u.usu_nom,                    
                    u.usu_ape,
                    a.area_id,                    
                    a.area_nom,                    
                    oc.usu_asig,                    
                    oc.usu_asig_est,                    
                    s.suba_nom,                  
                    t.tip_nom,                   
                    oc.tickoc_corre,              
                    ocest.tickoc_orden,              
                    ocest.fech_dig,              
                    ocest.fech_apro,              
                    ocest.fech_envprov,              
                    ocest.fech_repbode,              
                    ocest.fech_rechbode,          
                    ocest.estoc_id,              
                    est.estoc_nom2,        
                    asig.usu_nom,                    
                    asig.usu_ape,  
                    oc.tick_Planta,
                    tm_tiempoEsperado.TiempoEsperado_nom,
                    tm_OpcionesCotizacion.OpcionesCotizacion_nom,
                    oc.valor_estimado,
                    tm_entrega.ent_nom
                ORDER BY 
                    oc.tickoc_id DESC";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para listar ticket por grupo */
        public function listar_ticketoc_x_grupo($grupo_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
             $sql="SELECT
                    tm_ticket_oc.tickoc_id,
                    tm_ticket_oc.usu_id,
                    tm_ticket_oc.tickoc_titulo,
                    tm_ticket_oc.tickoc_descrip,
                    tm_ticket_oc.tickoc_estado,
                    tm_ticket_oc.fech_cierre,
                    tm_ticket_oc.fech_crea,
                    tm_ticket_oc.tip_id,
                    tm_usuario.usu_nom,
                    tm_usuario.usu_ape,
                    tm_area.area_nom,
                    tm_ticket_oc.usu_asig,
                    tm_subarea.suba_nom,
                    tm_tipo.tip_nom,
                    tm_ticket_oc.tickoc_corre,
                    tm_ticket_oc_estOC.tickoc_orden,
                    tm_ticket_oc_estOC.fech_dig,
                    tm_ticket_oc_estOC.fech_apro,
                    tm_ticket_oc_estOC.fech_envprov,
                    tm_ticket_oc_estOC.fech_repbode,
                    tm_ticket_oc_estOC.fech_rechbode,
                    tm_estado_oc.estoc_nom2,
                    tm_tiempoEsperado.TiempoEsperado_nom,
                    tm_OpcionesCotizacion.OpcionesCotizacion_nom,
                    valor_estimado,
                    tm_entrega.ent_nom,
                    tm_ticket_oc.tick_Planta,
                    no.numeroOrdenAsignado 
                FROM
                    tm_ticket_oc INNER JOIN
                    tm_usuario ON tm_ticket_oc.usu_id = tm_usuario.usu_id INNER JOIN  
                    tm_area ON tm_ticket_oc.area_id = tm_area.area_id INNER JOIN  
                    tm_subarea ON tm_ticket_oc.suba_id = tm_subarea.suba_id INNER JOIN  
                    tm_tipo ON tm_ticket_oc.tip_id = tm_tipo.tip_id LEFT JOIN
                    tm_ticket_oc_estOC ON tm_ticket_oc.tickoc_id = tm_ticket_oc_estOC.tickoc_id LEFT JOIN
                    tm_estado_oc ON tm_ticket_oc_estOC.estoc_id = tm_estado_oc.estoc_id
                    LEFT JOIN tm_tiempoEsperado ON tm_ticket_oc.TiempoEsperado_id = tm_tiempoEsperado.TiempoEsperado_id
                    LEFT JOIN tm_OpcionesCotizacion ON tm_ticket_oc.opcionescotizacion_id = tm_OpcionesCotizacion.OpcionesCotizacion_id 
                    LEFT JOIN  tm_entrega ON  tm_ticket_oc.ent_id =  tm_entrega.ent_id
                    LEFT JOIN td_NumeroOrdenes no ON tm_ticket_oc.tickoc_id = no.tickoc_id 
                WHERE  
            tm_ticket_oc.est = 1  
            AND tm_ticket_oc.usu_asig=?
            ORDER BY tm_ticket_oc.tickoc_id DESC  ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $grupo_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para listar ticket sin asignar usuario */
        public function listar_ticketoc_x_asig($usu_asig){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SELECT DISTINCT     
                    oc.tickoc_id,                    
                    oc.usu_id,                                     
                    oc.tickoc_titulo,                    
                    oc.tickoc_descrip,                    
                    oc.tickoc_estado,                                      
                    oc.fech_cierre,                    
                    oc.fech_crea,     
                    oc.tip_id,                    
                    u.usu_nom,                    
                    u.usu_ape,
                    CONCAT(u.usu_nom, ' ', u.usu_ape) AS Solicitante,                  
                    a.area_id,                    
                    a.area_nom,                    
                    oc.usu_asig,                    
                    oc.usu_asig_est,                    
                    s.suba_nom,                  
                    t.tip_nom,                   
                    oc.tickoc_corre,              
                    ocest.tickoc_orden,              
                    ocest.fech_dig,              
                    ocest.fech_apro,              
                    ocest.fech_envprov,              
                    ocest.fech_repbode,              
                    ocest.fech_rechbode,          
                    ocest.estoc_id,              
                    est.estoc_nom2,        
                    asig.usu_nom AS usu_nom_asig,                    
                    asig.usu_ape AS usu_ape_asig,  
                    oc.tick_Planta,
                    tm_tiempoEsperado.TiempoEsperado_nom,
                    tm_OpcionesCotizacion.OpcionesCotizacion_nom,
                    oc.valor_estimado,
                    tm_entrega.ent_nom,
                    STRING_AGG(no.numeroOrdenAsignado, '-') AS numeroOrdenAsignado
                FROM                    
                    tm_ticket_oc oc                                      
                    INNER JOIN tm_usuario u ON oc.usu_id = u.usu_id         
                    LEFT JOIN tm_usuario asig ON oc.usu_asig = asig.usu_id         
                    INNER JOIN tm_area a ON oc.area_id = a.area_id                    
                    INNER JOIN tm_subarea s ON oc.suba_id = s.suba_id                    
                    INNER JOIN tm_tipo t ON oc.tip_id = t.tip_id              
                    LEFT JOIN tm_ticket_oc_estOC ocest ON oc.tickoc_id = ocest.tickoc_id           
                    LEFT JOIN tm_estado_oc est ON ocest.estoc_id = est.estoc_id 
                    LEFT JOIN tm_tiempoEsperado ON oc.TiempoEsperado_id = tm_tiempoEsperado.TiempoEsperado_id
                    LEFT JOIN tm_OpcionesCotizacion ON oc.opcionescotizacion_id = tm_OpcionesCotizacion.OpcionesCotizacion_id 
                    LEFT JOIN tm_entrega ON oc.ent_id = tm_entrega.ent_id
                    LEFT JOIN td_NumeroOrdenes no ON oc.tickoc_id = no.tickoc_id 
                WHERE  
                    oc.est = 1  AND oc.usu_asig =?
                    
                GROUP BY
                    oc.tickoc_id,                    
                    oc.usu_id,                    
                    oc.tickoc_titulo,                    
                    oc.tickoc_descrip,                    
                    oc.tickoc_estado,                    
                    oc.fech_cierre,                    
                    oc.fech_crea,    
                    oc.tip_id,                    
                    u.usu_nom,                    
                    u.usu_ape,
                    a.area_id,                    
                    a.area_nom,                    
                    oc.usu_asig,                    
                    oc.usu_asig_est,                    
                    s.suba_nom,                  
                    t.tip_nom,                   
                    oc.tickoc_corre,              
                    ocest.tickoc_orden,              
                    ocest.fech_dig,              
                    ocest.fech_apro,              
                    ocest.fech_envprov,              
                    ocest.fech_repbode,              
                    ocest.fech_rechbode,          
                    ocest.estoc_id,              
                    est.estoc_nom2,        
                    asig.usu_nom,                    
                    asig.usu_ape,  
                    oc.tick_Planta,
                    tm_tiempoEsperado.TiempoEsperado_nom,
                    tm_OpcionesCotizacion.OpcionesCotizacion_nom,
                    oc.valor_estimado,
                    tm_entrega.ent_nom
                ORDER BY 
                    oc.tickoc_id DESC";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_asig);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para listar ticket por id */ 
        /* TODO:03/22 SP Actualizado */
        public function listar_ticketoc_x_id($tickoc_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="SP_L_TICKETOC_01 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickoc_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll(pdo::FETCH_ASSOC);
        }

        /* Funcion necesaria para listar ticket totales */ 
        public function listar_ticketoc(){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SELECT
                    tm_ticket_oc.tickoc_id,
                    tm_ticket_oc.usu_id,
                    tm_ticket_oc.cat_id,
                    tm_ticket_oc.tickoc_titulo,
                    tm_ticket_oc.tickoc_descrip,
                    tm_ticket_oc.tickoc_estado,
                    tm_ticket_oc.tickoc_prio,
                    tm_ticket_oc.fech_cierre,
                    tm_ticket_oc.fech_crea,
                    tm_ticket_oc.tip_id,
                    tm_usuario.usu_nom,
                    tm_usuario.usu_ape,
                    tm_categoria.cat_nom,
                    tm_area.area_nom,
                    tm_ticket_oc.usu_asig,
                    tm_subarea.suba_nom,
                    tm_tipo.tip_nom,
                    tm_ticket_oc.tickoc_corre,
                    tm_ticket_oc_estOC.tickoc_orden,
                    tm_ticket_oc_estOC.fech_dig,
                    tm_ticket_oc_estOC.fech_apro,
                    tm_ticket_oc_estOC.fech_envprov,
                    tm_ticket_oc_estOC.fech_repbode,
                    tm_ticket_oc_estOC.fech_rechbode,
                    tm_estado_oc.estoc_nom2
                FROM
                    tm_ticket_oc INNER JOIN
                    tm_categoria ON tm_ticket_oc.cat_id = tm_categoria.cat_id INNER JOIN  
                    tm_usuario ON tm_ticket_oc.usu_id = tm_usuario.usu_id INNER JOIN  
                    tm_area ON tm_ticket_oc.area_id = tm_area.area_id INNER JOIN  
                    tm_subarea ON tm_ticket_oc.suba_id = tm_subarea.suba_id INNER JOIN  
                    tm_tipo ON tm_ticket_oc.tip_id = tm_tipo.tip_id LEFT JOIN
                    tm_ticket_oc_estOC ON tm_ticket_oc.tickoc_id = tm_ticket_oc_estOC.tickoc_id LEFT JOIN
                    tm_estado_oc ON tm_ticket_oc_estOC.estoc_id = tm_estado_oc.estoc_id
                WHERE  
                tm_ticket_oc.est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para listar detalle de ticket x ticket principal */ 
        public function listar_ticketocdetalle_x_ticketoc($tickoc_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="SELECT 
            td_ticketocdetalle.tickocd_id,
            td_ticketocdetalle.tickocd_descrip,
            td_ticketocdetalle.fech_crea,
            tm_ticket_oc.tickoc_prio,
            tm_ticket_oc.fech_cierre,
            tm_usuario.usu_nom,
            tm_usuario.usu_ape,
            tm_usuario.rol_id,
            tm_rol.rol_nom
            FROM
            td_ticketocdetalle
            INNER join tm_usuario on td_ticketocdetalle.usu_id = tm_usuario.usu_id
            INNER JOIN tm_ticket_oc on td_ticketocdetalle.tickoc_id = tm_ticket_oc.tickoc_id 
            INNER JOIN tm_rol on tm_usuario.rol_id = tm_rol.rol_id
            WHERE
            td_ticketocdetalle.tickoc_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickoc_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para registrar ticket detalle guardando su id de ticket principal */
        /* TODO:03/22 SP Actualizado */
        public function insert_ticketocdetalle($tickoc_id,$usu_id,$tickocd_descrip,$tickoc_orden,$tickoc_check1,$tickoc_check2,$tickoc_geren,$tickoc_geren2){
            $conectar= parent::conexion();
             /*consulta SQL*/
                $sql="SP_I_DETALLEOC_01 ?,?,?,?,?,?,?,?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickoc_id);
            $sql->bindValue(2, $usu_id);
            $sql->bindValue(3, $tickocd_descrip);
            $sql->bindValue(4, $tickoc_orden);
            $sql->bindValue(5, $tickoc_check1);
            $sql->bindValue(6, $tickoc_check2);
            $sql->bindValue(7, $tickoc_geren);
            $sql->bindValue(8, $tickoc_geren2);
            $sql->execute();
            return $resultado=$sql->fetchall();
        }

        /* Funcion necesaria para insertar una linea adicional para cerrar el ticket en tabla detalle */ 
        public function insert_ticketocdetalle_cerrar($tickoc_id,$usu_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
                $sql="INSERT INTO td_ticketocdetalle (tickoc_id,usu_id,tickocd_descrip,fech_crea,est) VALUES (?,?,'OC Cerrado...',getdate(),1)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickoc_id);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para actualizar ticket */
        public function update_ticketoc($tickoc_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="UPDATE tm_ticket_oc
                set
                    fech_cierre = getdate(),
                    tickoc_estado = 'Cerrado'
                where
                    tickoc_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickoc_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para asignar ticket */
        public function asignar_ticketoc($tickoc_id,$usu_asig){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="UPDATE tm_ticket_oc
                set
                    usu_asig = ?,
                    usu_asig_est='Si',
                    fech_asig = getdate()
                where
                    tickoc_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_asig);
            $sql->bindValue(2, $tickoc_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para total ticket */
        public function get_ticketoc_total($grupo_id,$sis_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="SELECT
                    COUNT (tm_ticket_oc.tickoc_id) as TOTAL
                FROM
                tm_ticket_oc
                --INNER join tm_categoria on tm_ticket_oc.cat_id = tm_categoria.cat_id
                INNER join tm_usuario on tm_ticket_oc.usu_id = tm_usuario.usu_id
                INNER join tm_area on tm_ticket_oc.area_id = tm_area.area_id
                INNER JOIN tm_subarea on tm_ticket_oc.suba_id = tm_subarea.suba_id
                WHERE
                tm_ticket_oc.est = 1
                --AND tm_categoria.grupo_id = ?
                AND tm_ticket_oc.sis_id = ?";
            $sql=$conectar->prepare($sql);
            /* $sql->bindValue(1, $grupo_id); */
            $sql->bindValue(1, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para asignar ticket abiertos*/
        public function get_ticketoc_totalabierto($grupo_id,$sis_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="SELECT
                    count (tm_ticket_oc.tickoc_id) as TOTAL
                FROM
                tm_ticket_oc
                INNER join tm_usuario on tm_ticket_oc.usu_id = tm_usuario.usu_id
                INNER join tm_area on tm_ticket_oc.area_id = tm_area.area_id
                INNER JOIN tm_subarea on tm_ticket_oc.suba_id = tm_subarea.suba_id
                WHERE
                tm_ticket_oc.est = 1
                AND tm_ticket_oc.tickoc_estado='Abierto'
                AND tm_ticket_oc.sis_id = ?";
            $sql=$conectar->prepare($sql);
            /* $sql->bindValue(1, $grupo_id); */
            $sql->bindValue(1, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para asignar cerrados */
        public function get_ticketoc_totalcerrado($grupo_id,$sis_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="SELECT
                    count (tm_ticket_oc.tickoc_id) as TOTAL
                FROM
                tm_ticket_oc
                --INNER join tm_categoria on tm_ticket_oc.cat_id = tm_categoria.cat_id
                INNER join tm_usuario on tm_ticket_oc.usu_id = tm_usuario.usu_id
                INNER join tm_area on tm_ticket_oc.area_id = tm_area.area_id
                INNER JOIN tm_subarea on tm_ticket_oc.suba_id = tm_subarea.suba_id
                WHERE
                tm_ticket_oc.est = 1
                AND tm_ticket_oc.tickoc_estado='Cerrado'
                --AND tm_categoria.grupo_id = ?
                AND tm_ticket_oc.sis_id = ?";
            $sql=$conectar->prepare($sql);
            /* $sql->bindValue(1, $grupo_id); */
            $sql->bindValue(1, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para ticket sin asignar*/
        public function get_ticketoc_totalsinasignar($grupo_id,$sis_id){
            $conectar= parent::conexion();
             /*consulta SQL*/
            $sql="SELECT
                    count (tm_ticket_oc.tickoc_id) as TOTAL
                FROM
                tm_ticket_oc
                --INNER join tm_categoria on tm_ticket_oc.cat_id = tm_categoria.cat_id
                INNER join tm_usuario on tm_ticket_oc.usu_id = tm_usuario.usu_id
                INNER join tm_area on tm_ticket_oc.area_id = tm_area.area_id
                INNER JOIN tm_subarea on tm_ticket_oc.suba_id = tm_subarea.suba_id
                WHERE
                tm_ticket_oc.est = 1
                AND fech_asig is null
                --AND tm_categoria.grupo_id = ?
                AND tm_ticket_oc.sis_id = ?";
            $sql=$conectar->prepare($sql);
            /* $sql->bindValue(1, $grupo_id); */
            $sql->bindValue(1, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para ticket en grafico dashboard*/
        public function get_ticketoc_grafico($grupo_id,$sis_id){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket_oc  JOIN
                    tm_categoria ON tm_ticket_oc.cat_id = tm_categoria.cat_id
                WHERE
                tm_ticket_oc.est = 1
                AND tm_categoria.grupo_id = ?
                AND tm_ticket_oc.sis_id = ?
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

        public function update_ticketoc_opcion($tickoc_id,$tickoc_opc){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_U_TICKET_01 ?,?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickoc_id);
            $sql->bindValue(2, $tickoc_opc);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function update_ticketoc_tipo_categoria($tickoc_id,$tip_id,$cat_id){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_U_TICKET_02 ?,?,?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickoc_id);
            $sql->bindValue(2, $tip_id);
            $sql->bindValue(3, $cat_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function filtro_ticketoc($tip_id,$area_id,$tickoc_estado,$usu_asig_est,$sis_id,$estoc_id,$tickoc_orden,$fech_crea){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_L_TICKETOC_02 ?,?,?,?,?,?,?,?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tip_id);
            $sql->bindValue(2, $area_id);
            $sql->bindValue(3, $tickoc_estado);
            $sql->bindValue(4, $usu_asig_est);
            $sql->bindValue(5, $sis_id);
            $sql->bindValue(6, $estoc_id);
            $sql->bindValue(7, $tickoc_orden);
            $sql->bindValue(8, $fech_crea);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* TODO:03/22 SP Actualizado */
        public function agregar_ticketoc($tickoc_id,$estoc_id,$usu_id){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_U_TICKETOC_01 ?,?,?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickoc_id);
            $sql->bindValue(2, $estoc_id);
            $sql->bindValue(3, $usu_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function agregar_ticketoc_NumeroOrden($tickoc_id,$numeroOrdenAsignado){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="InsertarNumeroOrdenes ?,?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickoc_id);
            $sql->bindValue(2, $numeroOrdenAsignado);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function listar_segun_ticket_estado_id($tickoc_id){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_L_TICKETOC_03 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickoc_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function listar_segun_ticket_OrdenAsignada($tickoc_id){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_L_TICKETOC_OrdenesAsignadas ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickoc_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function listar_segun_ticket_OrdenAsignada2($numeroOrdenAsignado){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_L_TICKETOC_OrdenesAsignadas2 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $numeroOrdenAsignado);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* TODO:03/22 SP Actualizado */
        public function listar_oc_cotizacion_cerrado($usu_id){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_L_TICKETOC_04 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function insert_ticket_file_oc($tickocd_id,$tickfoc_ruta){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_I_TICKETFILEOC_01 ?,?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickocd_id);
            $sql->bindValue(2, $tickfoc_ruta);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            //return $resultado=$sql->fetchAll();
        }

        public function listar_ticket_file_oc($tickocd_id){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_L_TICKETFILEOC_01 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickocd_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function listar_ticket_file_soloAgentes_oc($tickocd_id){
            $conectar= parent::conexion();
            /*consulta SQL*/
            $sql="SP_L_TICKETFILEOC_SOLOAGENTES_01 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickocd_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }
    }
?>