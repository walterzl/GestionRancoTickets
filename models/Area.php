<?php
    /* Extencion con la clase conectar para poder consumir sus funciones */
    class Area extends Conectar{

        /* Funcion necesaria para insertar un nuevo registro */
        public function insert_area($area_nom){
            $conectar= parent::conexion();
            /* consulta sql */
            $sis_id = $_SESSION["sis_id"];
            $sql="INSERT INTO tm_area (sis_id,area_nom,fech_crea,est) VALUES ($sis_id,?,getdate(),1);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $area_nom);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para actualizar un nuevo registro */
        public function update_area($area_id,$area_nom){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="UPDATE tm_area set
                area_nom = ?
                WHERE
                area_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $area_nom);
            $sql->bindValue(2, $area_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para eliminar un nuevo registro */
        public function delete_area($area_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="UPDATE tm_area set
                est = 0
                WHERE
                area_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $area_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para obtener un registro x id */
        public function get_area_x_id($area_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="SELECT * FROM tm_area WHERE est=1
                AND area_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $area_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para listar todos los registros de la tabla que esten activos */
        public function get_area($sis_id){
            /* consulta sql */
            $conectar= parent::conexion();
            $sql="SP_L_AREA_01 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

    }
?>