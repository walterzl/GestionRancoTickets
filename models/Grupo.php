<?php
    /* Extencion con la clase conectar para poder consumir sus funciones */
    class Grupo extends Conectar{

        /* Funcion necesaria para insertar un nuevo registro */ 
        public function insert_grupo($grupo_nom){
            $conectar= parent::conexion();
            /* consulta sql */
            $sis_id = $_SESSION["sis_id"];
            $sql="INSERT INTO tm_grupo_usuario (sis_id,grupo_nom,fech_crea,est) VALUES ($sis_id,?,getdate(),1);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $grupo_nom);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para actualizar un nuevo registro */
        public function update_grupo($grupo_id,$grupo_nom){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="UPDATE tm_grupo_usuario set
                grupo_nom = ?
                WHERE
                grupo_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $grupo_nom);
            $sql->bindValue(2, $grupo_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para eliminar un nuevo registro */
        public function delete_grupo($grupo_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="UPDATE tm_grupo_usuario set
                est = 0
                WHERE
                grupo_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $grupo_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para obtener un registro x id */
        public function get_grupo_x_id($grupo_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="SELECT * FROM tm_grupo_usuario WHERE est=1
                AND grupo_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $grupo_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para listar todos los registros de la tabla que esten activos */
        public function get_grupo($sis_id){
            $conectar= parent::conexion();
           /* consulta sql */
            $sql="SP_L_GRUPO_01 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $sis_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

    }
?>