<?php

    /* Extencion con la clase conectar para poder consumir sus funciones */
    class Categoria extends Conectar{

        /* Funcion necesaria para insertar un nuevo registro */
        public function insert_categoria($grupo_id,$cat_nom,$tip_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sis_id = $_SESSION["sis_id"];
            $sql="INSERT INTO tm_categoria (sis_id,grupo_id,cat_nom,tip_id,fech_crea,est) VALUES ($sis_id,?,?,?,getdate(),1);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $grupo_id);
            $sql->bindValue(2, $cat_nom);
            $sql->bindValue(3, $tip_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll(pdo::FETCH_ASSOC);
        }

        /* Funcion necesaria para actualizar un registro */
        public function update_categoria($cat_id,$grupo_id,$cat_nom,$tip_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="UPDATE tm_categoria set
                grupo_id = ?,
                cat_nom = ?,
                tip_id = ?
                WHERE
                cat_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $grupo_id);
            $sql->bindValue(2, $cat_nom);
            $sql->bindValue(3, $tip_id);
            $sql->bindValue(4, $cat_id);
            $sql->execute();
        }

        /* Funcion necesaria para eliminar un registro cambiado el estado */
        public function delete_categoria($cat_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="UPDATE tm_categoria set
                est = 0
                WHERE
                cat_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para seleccionar un registro x id*/
        public function get_categoria_x_id($cat_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="SELECT
                    tm_categoria.cat_id,
                    tm_categoria.cat_nom,
                    tm_categoria.tip_id,
                    tm_grupo_usuario.grupo_id,
                    tm_grupo_usuario.grupo_nom
                FROM tm_categoria
                INNER JOIN
                tm_grupo_usuario on tm_categoria.grupo_id = tm_grupo_usuario.grupo_id
                WHERE tm_categoria.est=1
                AND tm_categoria.cat_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para listar todos los registros de una tabla*/
        public function get_categoria($sis_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="SP_L_CATEGORIA_01 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

         /* Funcion necesaria para listar todos los por tipo de la tabla*/
        public function get_categoria_x_tipo($tip_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="SELECT
                tm_categoria.cat_id,
                tm_categoria.sis_id,
                tm_categoria.cat_nom,
                tm_categoria.tip_id,
                tm_grupo_usuario.grupo_id,
                tm_grupo_usuario.grupo_nom
            FROM tm_categoria
            INNER JOIN
            tm_grupo_usuario on tm_categoria.grupo_id = tm_grupo_usuario.grupo_id
            WHERE
            tm_categoria.est = 1
            AND tm_categoria.tip_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tip_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

    }
?>