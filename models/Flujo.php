<?php
    /* Extencion con la clase conectar para poder consumir sus funciones */
    class Flujo extends Conectar{

         /* Funcion necesaria para obtener registro x ticket solo agentes*/
        public function get_flujo_x_usu($sis_id,$usu_id){
            $conectar= parent::conexion();
            /* consulta sql */
            /* $sql="SP_L_FlujoPorUsuarioID ?,?"; */
            $sql="SELECT 
                        h.*, 
                        u.usu_id 
                    FROM 
                        Venus.[GestionRanco].[dbo].[Hist_EjecucionFlujo] as h
                    INNER JOIN (
                        SELECT
                            MAX([id]) as id,
                            [itemCompra],
                            MAX([FechaRespuesta]) as FechaRespuesta
                        FROM 
                            Venus.[GestionRanco].[dbo].[Hist_EjecucionFlujo]
                        GROUP BY
                            [itemCompra]
                    ) as maximo 
                        ON maximo.id = h.id
                    INNER JOIN 
                        tm_usuario as u 
                        ON h.correoSolicitante = u.usu_correo
                    WHERE 
                        u.sis_id =? AND u.usu_id =?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $sis_id);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

    }
?>