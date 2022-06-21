<?php
    /*  llamada a clase conexion */
    /* require_once '../config/conexion.php'; */
    /* Extencion con la clase conectar para poder consumir sus funciones */
    class Usuario extends Conectar{

        /* funcion login para llamarla en el controllador */
        public function login($usu_correo,$sis_id){
            $conectar=parent::conexion();
             /* consulta sql */
            $sql = "SP_L_USUARIO_01 ?,?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_correo);
            $sql->bindValue(2, $sis_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* Acceso a login sin Outlook */
        public function login2(){
            $conectar=parent::conexion();
            /*parent::set_names();*/
            if(isset($_POST["enviar"])){
                $correo = $_POST["usu_correo"];
                $pass = $_POST["usu_pass"];
                $sis = $_POST["sis_id"];
                if(empty($correo) and empty($pass) and empty($sis)){
                    header("Location:".conectar::ruta()."index.php?m=2");
					exit();
                }else{
                    $sql = "SP_L_USUARIO_02 ?,?,?";
                    $stmt=$conectar->prepare($sql);
                    $stmt->bindValue(1, $correo);
                    $stmt->bindValue(2, $pass);
                    $stmt->bindValue(3, $sis);
                    $stmt->execute();
                    $resultado = $stmt->fetch();
                    if (is_array($resultado) and count($resultado)>0){
                        $_SESSION["usu_id"]=$resultado["usu_id"];
                        $_SESSION["usu_nom"]=$resultado["usu_nom"];
                        $_SESSION["usu_ape"]=$resultado["usu_ape"];
                        $_SESSION["rol_id"]=$resultado["rol_id"];
                        $_SESSION["grupo_id"]=$resultado["grupo_id"];
                        $_SESSION["area_id"]=$resultado["area_id"];
                        $_SESSION["suba_id"]=$resultado["suba_id"];
                        $_SESSION["sis_id"]=$resultado["sis_id"];
                        $_SESSION["sis_nom"]=$resultado["sis_nom"];

                        header("Location:".Conectar::ruta()."view/Home/");
                        exit();
                    }else{
                        header("Location:".Conectar::ruta()."index.php?m=1");
                        exit();
                    }
                }
            }
        }
        /* funcion para registrar un nuevo registro */
        public function insert_usuario($usu_nom,$usu_ape,$usu_correo,$usu_pass,$rol_id,$grupo_id,$area_id,$suba_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sis_id = $_SESSION["sis_id"];
            $sql="INSERT INTO tm_usuario (sis_id,usu_nom, usu_ape, usu_correo, usu_pass, rol_id,grupo_id,area_id,suba_id,fech_crea,fech_modi,fech_elim,est) VALUES ($sis_id,?,?,?,?,?,?,?,?,getdate(), NULL, NULL, 1);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_ape);
            $sql->bindValue(3, $usu_correo);
            $sql->bindValue(4, $usu_pass);
            $sql->bindValue(5, $rol_id);
            $sql->bindValue(6, $grupo_id);
            $sql->bindValue(7, $area_id);
            $sql->bindValue(8, $suba_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }
        /* funcion para actualizar un registro por id */
        public function update_usuario($usu_id,$usu_nom,$usu_ape,$usu_correo,$usu_pass,$rol_id,$grupo_id,$area_id,$suba_id){
            $conectar= parent::conexion();
             /* consulta sql */
            $sql="UPDATE tm_usuario set
                usu_nom = ?,
                usu_ape = ?,
                usu_correo = ?,
                usu_pass = ?,
                rol_id = ?,
                grupo_id = ?,
                area_id = ?,
                suba_id = ?
                WHERE
                usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_ape);
            $sql->bindValue(3, $usu_correo);
            $sql->bindValue(4, $usu_pass);
            $sql->bindValue(5, $rol_id);
            $sql->bindValue(6, $grupo_id);
            $sql->bindValue(7, $area_id);
            $sql->bindValue(8, $suba_id);
            $sql->bindValue(9, $usu_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }
        /* funcion para eliminar un registro cambiado su estado */
        public function delete_usuario($usu_id){
            $conectar= parent::conexion();
             /* consulta sql */
            $sql="UPDATE tm_usuario
                    SET
                        est=0,
                        fech_elim = getdate()
                    where usu_id=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }
        /* funcion para obtener todos los registros de la tabla */
        public function get_usuario($sis_id){
            $conectar= parent::conexion();
             /* consulta sql */
            $sql="SP_L_USUARIO_03 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $sis_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }
        /* funcion para obtener un registro por id */
        public function get_usuario_x_id($usu_id){
            $conectar= parent::conexion();
             /* consulta sql */
            $sql="SELECT
                tm_usuario.usu_id,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_usuario.usu_correo,
                tm_usuario.usu_pass,
                tm_usuario.rol_id,
                tm_usuario.grupo_id,
                tm_grupo_usuario.grupo_nom,
                tm_usuario.area_id,
                tm_area.area_nom,
                tm_usuario.suba_id,
                tm_subarea.suba_nom,
                SUBSTRING(tm_usuario.usu_correo,CHARINDEX('@', tm_usuario.usu_correo)+1,LEN(tm_usuario.usu_correo)-CHARINDEX('@', tm_usuario.usu_correo)) AS usu_dominio
                FROM
                tm_usuario INNER join
                tm_grupo_usuario on tm_grupo_usuario.grupo_id = tm_usuario.grupo_id INNER JOIN
                tm_area on tm_area.area_id = tm_usuario.area_id INNER JOIN
                tm_subarea on tm_subarea.suba_id = tm_usuario.suba_id
                WHERE
                tm_usuario.usu_id = ?
            ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }
        /* funcion para obtener un registro por correo electronico */
        public function get_usuario_x_correo($usu_correo){
            $conectar= parent::conexion();
             /* consulta sql */
            $sis_id = $_SESSION["sis_id"];
            $sql="SELECT
                tm_usuario.usu_id,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_usuario.usu_correo,
                tm_usuario.usu_pass,
                tm_usuario.rol_id,
                tm_usuario.grupo_id,
                tm_grupo_usuario.grupo_nom,
                tm_usuario.area_id,
                tm_area.area_nom,
                tm_usuario.suba_id,
                tm_subarea.suba_nom
                FROM
                tm_usuario INNER join
                tm_grupo_usuario on tm_grupo_usuario.grupo_id = tm_usuario.grupo_id INNER JOIN
                tm_area on tm_area.area_id = tm_usuario.area_id INNER JOIN
                tm_subarea on tm_subarea.suba_id = tm_usuario.suba_id
                WHERE
                tm_usuario.est = 1
                AND tm_usuario.usu_correo = ?
                AND tm_usuario.sis_id = $sis_id
            ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_correo);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }
        /* funcion para obtener registro por rol del registro */
        public function get_usuario_x_rol($sis_id){
            $conectar= parent::conexion();
             /* consulta sql */
            $sql="SP_L_USUARIO_04 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $sis_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }
        /* funcion para obtener para obtener el total de ticket por usuario */
        public function get_usuario_total_x_id($usu_id){
            $conectar= parent::conexion();
             /* consulta sql */
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and est=1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_oc_total_x_id($usu_id){
            $conectar= parent::conexion();
             /* consulta sql */
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket_oc where usu_id = ? and est=1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        /* funcion para obtener para obtener el total de ticket abiertos por usuario */
        public function get_usuario_totalabierto_x_id($usu_id){
            $conectar= parent::conexion();
             /* consulta sql */
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and tick_estado='Abierto' and est=1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_oc_totalabierto_x_id($usu_id){
            $conectar= parent::conexion();
             /* consulta sql */
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket_oc where usu_id = ? and tickoc_estado='Abierto' and est=1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* funcion para obtener para obtener el total de ticket cerrados por usuario */
        public function get_usuario_totalcerrado_x_id($usu_id){
            $conectar= parent::conexion();
             /* consulta sql */
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and tick_estado='Cerrado' and est=1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_oc_totalcerrado_x_id($usu_id){
            $conectar= parent::conexion();
             /* consulta sql */
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket_oc where usu_id = ? and tickoc_estado='Cerrado' and est=1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_totalsinasignar_x_id($usu_id){
            $conectar= parent::conexion();
             /* consulta sql */
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and fech_asig is null and est=1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_oc_totalsinasignar_x_id($usu_id){
            $conectar= parent::conexion();
             /* consulta sql */
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket_oc where usu_id = ? and fech_asig is null and est=1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        /* funcion para obtener para obtener el total de ticket por categoria */
        public function get_usuario_grafico($usu_id){
            $conectar= parent::conexion();
             /* consulta sql */
            $sql="SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket  JOIN
                    tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
                WHERE
                tm_ticket.est = 1
                and tm_ticket.usu_id = ?
                and tm_ticket.est=1
                GROUP BY
                tm_categoria.cat_nom
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_oc_grafico($usu_id){
            $conectar= parent::conexion();
             /* consulta sql */
            $sql="SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket_oc  JOIN
                    tm_categoria ON tm_ticket_oc.cat_id = tm_categoria.cat_id  
                WHERE
                tm_ticket_oc.est = 1
                and tm_ticket_oc.usu_id = ?
                and tm_ticket_oc.est=1
                GROUP BY
                tm_categoria.cat_nom
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }
        /* funcion para obtener para obtener el total de ticket por categoria */
        public function get_menu_usuario_rol($rol_id){
            $conectar= parent::conexion();
             /* consulta sql */
            $sql="SP_L_MENU_01 ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $rol_id);
            $sql->execute();
             /* retornar resultado en variable resultado y usarlo en el controllador */
            return $resultado=$sql->fetchAll();
        }
    }
?>