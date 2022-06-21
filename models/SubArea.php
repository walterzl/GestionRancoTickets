<?php
    /* Extencion con la clase conectar para poder consumir sus funciones */
    class SubArea extends Conectar{

        /* Funcion necesaria para insertar un nuevo registro */ 
        public function insert_subarea($area_id,$suba_nom){
            $conectar= parent::conexion();
            /* consulta sql*/
            $sql="INSERT INTO tm_subarea (area_id,suba_nom,fech_crea,est) VALUES (?,?,getdate(),1);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $area_id);
            $sql->bindValue(2, $suba_nom);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para actualizar un nuevo registro */
        public function update_subarea($suba_id,$area_id,$suba_nom){
            $conectar= parent::conexion();
            /* consulta sql*/
            $sql="UPDATE tm_subarea set
                area_id = ?,
                suba_nom = ?
                WHERE
                suba_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $area_id);
            $sql->bindValue(2, $suba_nom);
            $sql->bindValue(3, $suba_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para eliminar un nuevo registro */
        public function delete_subarea($suba_id){
            $conectar= parent::conexion();
            /* consulta sql*/
            $sql="UPDATE tm_subarea set
                est = 0
                WHERE
                suba_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $suba_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para obtener un registro x id */
        public function get_subarea_x_id($suba_id){
            $conectar= parent::conexion();
            /* consulta sql*/
            $sql="SELECT
                    tm_subarea.suba_id,
                    tm_subarea.suba_nom,
                    tm_subarea.area_id,
                    tm_area.area_nom
                    FROM tm_subarea
                    INNER JOIN
                    tm_area on tm_subarea.area_id = tm_area.area_id
                    WHERE tm_subarea.est=1
                    AND tm_subarea.suba_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $suba_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para listar todos los registros de la tabla que esten activos */
        public function get_subarea($sis_id){
            $conectar= parent::conexion();
            /* consulta sql*/
            $sql="SP_L_SUBAREA_01 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function get_subarea_x_area($area_id){
            $conectar= parent::conexion();
            /*parent::set_names();*/
            $sql="SELECT
                tm_subarea.suba_id,
                tm_subarea.suba_nom,
                tm_subarea.area_id,
                tm_area.area_nom
                FROM tm_subarea
                INNER JOIN
                tm_area on tm_subarea.area_id = tm_area.area_id
                WHERE
                tm_subarea.est=1
                AND tm_subarea.area_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $area_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

    }
?>