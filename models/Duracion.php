<?php
    /* Extencion con la clase conectar para poder consumir sus funciones */
    class Duracion extends Conectar{

        /* Funcion necesaria para listar todos los registros de la tabla que esten activos */
        public function get_duracion($sis_id){
            /* consulta sql */
            $conectar= parent::conexion();
            $sql="SELECT * FROM tm_duracion WHERE sis_id = ? AND est=1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

    }
?>