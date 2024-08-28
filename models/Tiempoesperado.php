<?php
    /* Extencion con la clase conectar para poder consumir sus funciones */
    class Tiempoesperado extends Conectar{

        /* Funcion necesaria para listar todos los registros de la tabla que esten activos */
        public function get_tiempoesperado($sis_id){
            /* consulta sql */
            $conectar= parent::conexion();
            $sql="SELECT * FROM tm_tiempoEsperado WHERE sis_id = ? AND est=1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $sis_id);
            $sql->execute();
            /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function insert_tiempo_esperado($tiempoesperado_nom) {
            $conectar = parent::conexion();
            $sis_id = $_SESSION["sis_id"];
            $sql = "INSERT INTO tm_tiempoEsperado (sis_id, TiempoEsperado_nom, TiempoEsperado_nom2, est) VALUES (?, ?, ?, 1)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $sis_id);
            $sql->bindValue(2, $tiempoesperado_nom);
            $sql->bindValue(3, $tiempoesperado_nom);
            $sql->execute();
            return $sql->fetchAll();
        }
    
        public function update_tiempo_esperado($TiempoEsperado_id,$TiempoEsperado_nom) {
            $conectar = parent::conexion();
            $sql = "UPDATE tm_tiempoEsperado SET 
                TiempoEsperado_nom = ? 
                WHERE 
                TiempoEsperado_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $TiempoEsperado_nom);
            $sql->bindValue(2, $TiempoEsperado_id);
            // Imprimir la consulta para validarla
            echo $sql->queryString;

            $sql->execute();
            
            /* return $sql->fetchAll(); */
        }
    
        public function delete_tiempo_esperado($tiempoesperado_id) {
            $conectar = parent::conexion();
            $sql = "UPDATE tm_tiempoEsperado SET est = 0 WHERE tiempoesperado_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $tiempoesperado_id);
            $sql->execute();
            return $sql->fetchAll();
        }
    
        public function get_tiempo_esperado_by_id($tiempoesperado_id) {
            try {
                $conectar = parent::conexion();
                $sql = "SELECT * FROM tm_tiempoEsperado WHERE est = 1 AND tiempoesperado_id = ?";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $tiempoesperado_id);
                $sql->execute();
                $result = $sql->fetchAll(PDO::FETCH_ASSOC); // Asegúrate de que se devuelvan los resultados como un array asociativo
               
                return $result;
            } catch (Exception $e) {
                error_log("Error fetching data: " . $e->getMessage());
                return array();
            }

            
        }
    
        public function get_tiempo_esperado($sis_id) {
            $conectar = parent::conexion();
            $sql = "SP_L_TIEMPOESPERADO_01 ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $sis_id);
            $sql->execute();
            return $sql->fetchAll();
        }

    }
?>