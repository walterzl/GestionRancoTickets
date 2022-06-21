<?php
    /* Extencion con la clase conectar para poder consumir sus funciones */
    class Documentooc extends Conectar{

        /* Funcion necesaria para insertar un nuevo registro */
        public function insert_documentooc($tickoc_id,$dococ_nom){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="INSERT INTO td_documento_oc (tickoc_id,dococ_nom,fech_crea,est) VALUES (?,?,getdate(),1);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickoc_id);
            $sql->bindValue(2, $dococ_nom);
            $sql->execute();
        }

        /* Funcion necesaria para eliminar un registro */
        public function delete_documentooc($dococ_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="UPDATE td_documento_oc set
                est = 0
                WHERE
                dococ_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $dococ_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Funcion necesaria para obtener registro x ticket*/
        public function get_documentooc_x_ticket($tickoc_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="SELECT * FROM td_documento_oc WHERE est=1
                AND tickoc_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tickoc_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

    }
?>