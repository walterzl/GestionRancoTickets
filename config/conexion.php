<?php
    /* Inicio de sesion del proyecto PHP */
    session_start();

    class Conectar{
        protected $dbh;

        protected function Conexion(){
            try {

                //Conexion SQL ; si se quiere conectar a bd remota activar vpn
                //QA
                $conectar = $this->dbh = new PDO("sqlsrv:Server=192.168.1.15,1433;Database=GestionRanco", "GestionRanco", "Walter20");

                //WalterHOME
                /* $conectar = $this->dbh = new PDO("sqlsrv:Server=DESKTOP-CGLV30V,1433;Database=GestionRanco2", "sa", "123456"); */

                //Produccion
                /* $conectar = $this->dbh = new PDO("sqlsrv:Server=192.168.1.14,1433;Database=GestionRanco", "GestionRanco", "Walter20"); */

				return $conectar;
			} catch (Exception $e) {
                /* Mensaje de error en caso las credenciales de acceso esten erroneas */
				print "¡Error BD!: " . $e->getMessage() . "<br/>";
				die();
			}
        }

        public static function ruta(){
            /* Ruta principal del proyecto se centraliza desde aqui toda la ruta principal del proyecto */
			/* return "https://ticket.ranco.cl/GestionRanco/"; */
            /* return "http://localhost/GestionRancoTickets/"; */
            return "http://localhost/Gestion/";
		}

    }
?>

