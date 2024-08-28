<?php
    /* Extencion con la clase conectar para poder consumir sus funciones */
    class Tipo extends Conectar{
        /* Funcion necesaria para insertar un nuevo registro */
        public function insert_tipo($tip_nom){
            $conectar= parent::conexion();
            /* consulta sql */
            $sis_id = $_SESSION["sis_id"];
            $sql="INSERT INTO tm_tipo (sis_id,tip_nom,fech_crea,est) VALUES ($sis_id,?,getdate(),1);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tip_nom);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para actualizar un nuevo registro */
        public function update_tipo($tip_id,$tip_nom){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="UPDATE tm_tipo set
                tip_nom = ?
                WHERE
                tip_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tip_nom);
            $sql->bindValue(2, $tip_id);
            // Imprimir la consulta para validarla
            echo $sql->queryString;
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para eliminar un nuevo registro */
        public function delete_tipo($tip_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="UPDATE tm_tipo set
                est = 0
                WHERE
                tip_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tip_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para obtener un registro x id */
        public function get_tipo_x_id($tip_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="SELECT * FROM tm_tipo WHERE est=1
                AND tip_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tip_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para listar todos los registros de la tabla que esten activos */
        public function get_tipo($sis_id){
            /* consulta sql */
            $conectar= parent::conexion();
            $sql="SP_L_TIPO_01 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

    }
?>