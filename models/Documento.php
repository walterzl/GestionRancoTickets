<?php
    /* Extencion con la clase conectar para poder consumir sus funciones */
    class Documento extends Conectar{

        /* Funcion necesaria para insertar un nuevo registro */
        public function insert_documento($tick_id,$doc_nom){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="INSERT INTO td_documento (tick_id,doc_nom,fech_crea,est) VALUES (?,?,getdate(),1);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $doc_nom);
            $sql->execute();
        }

        /* Funcion necesaria para eliminar un registro */
        public function delete_documento($doc_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="UPDATE td_documento set
                est = 0
                WHERE
                doc_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $doc_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para obtener registro x ticket*/
        public function get_documento_x_ticket($tick_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="SELECT * FROM td_documento WHERE est=1
                AND tick_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

    }
?>