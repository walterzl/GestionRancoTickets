<?php

    /* Extencion con la clase conectar para poder consumir sus funciones */
    class Estado extends Conectar{

        /* Listar*/
        public function get_estado(){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="SELECT
                tm_estado_oc.estoc_id,
                tm_estado_oc.tip_id,
                tm_estado_oc.estoc_nom1,
                tm_estado_oc.estoc_nom2,
                tm_tipo.tip_nom
            FROM
                tm_estado_oc INNER JOIN
                tm_tipo ON tm_estado_oc.tip_id = tm_tipo.tip_id  
            WHERE 
                tm_estado_oc.est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para insertar un nuevo registro */
        public function insert_estado($tip_id,$estoc_nom1,$estoc_nom2,$estoc_campo){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="INSERT INTO tm_estado_oc (tip_id,estoc_nom1,estoc_nom2,estoc_campo,est) VALUES (?,?,?,?,1);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tip_id);
            $sql->bindValue(2, $estoc_nom1);
            $sql->bindValue(3, $estoc_nom2);
            $sql->bindValue(4, $estoc_campo);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll(pdo::FETCH_ASSOC);
        }

        /* Funcion necesaria para actualizar un registro */
        public function update_estado($estoc_id,$tip_id,$estoc_nom1,$estoc_nom2,$estoc_campo){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="UPDATE tm_estado_oc set
                tip_id=?,
                estoc_nom1 = ?,
                estoc_nom2 = ?,
                estoc_campo = ?
                WHERE
                estoc_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tip_id);
            $sql->bindValue(2, $estoc_nom1);
            $sql->bindValue(3, $estoc_nom2);
            $sql->bindValue(4, $estoc_campo);
            $sql->bindValue(5, $estoc_id);
            $sql->execute();
        }

        /* Funcion necesaria para eliminar un registro cambiado el estado */
        public function delete_estado($estoc_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="UPDATE tm_estado_oc set
                est = 0
                WHERE
                estoc_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $estoc_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para seleccionar un registro x id*/
        public function get_estado_x_id($estoc_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="SELECT
                tm_estado_oc.estoc_id,
                tm_estado_oc.tip_id,
                tm_estado_oc.estoc_nom1,
                tm_estado_oc.estoc_nom2,
                tm_estado_oc.estoc_campo,
                tm_tipo.tip_nom
                FROM
                tm_estado_oc INNER JOIN
                tm_tipo ON tm_estado_oc.tip_id = tm_tipo.tip_id 
                WHERE 
                tm_estado_oc.estoc_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $estoc_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function get_estado_x_tipo($tip_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="SELECT
                tm_estado_oc.estoc_id,
                tm_estado_oc.tip_id,
                tm_estado_oc.estoc_nom1,
                tm_estado_oc.estoc_nom2,
                tm_estado_oc.estoc_campo,
                tm_tipo.tip_nom
                FROM
                tm_estado_oc INNER JOIN
                tm_tipo ON tm_estado_oc.tip_id = tm_tipo.tip_id 
                WHERE 
                tm_estado_oc.tip_id = ?
                AND tm_estado_oc.est = 1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tip_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }
    }
?>