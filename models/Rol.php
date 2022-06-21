<?php
    /* Extencion con la clase conectar para poder consumir sus funciones */
    class Rol extends Conectar{
        /* Funcion necesaria para insertar un nuevo registro */
        public function insert_rol($rol_nom,$rol_color){
            $conectar= parent::conexion();
            /* consulta sql */
            $sis_id = $_SESSION["sis_id"];
            $sql="INSERT INTO tm_rol (sis_id,rol_nom,rol_color,fech_crea,est) VALUES ($sis_id,?,?,getdate(),1);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $rol_nom);
            $sql->bindValue(2, $rol_color);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para actualizar un nuevo registro */
        public function update_rol($rol_id,$rol_nom,$rol_color){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="UPDATE tm_rol set
                rol_nom = ?,
                rol_color = ?
                WHERE
                rol_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $rol_nom);
            $sql->bindValue(2, $rol_color);
            $sql->bindValue(3, $rol_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para eliminar un nuevo registro */
        public function delete_rol($rol_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="UPDATE tm_rol set
                est = 0
                WHERE
                rol_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $rol_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para obtener un registro x id */
        public function get_rol_x_id($rol_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="SELECT * FROM tm_rol WHERE est=1
                AND rol_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $rol_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }
        /* Funcion necesaria para listar todos los registros de la tabla que esten activos */
        public function get_rol($sis_id){
            /* consulta sql */
            $conectar= parent::conexion();
            $sql="SP_L_ROL_01 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

    }
?>