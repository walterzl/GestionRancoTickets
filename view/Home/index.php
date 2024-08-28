<?php
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	
	<title>Ranco::Home</title>
</head>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

    <div class="mobile-menu-left-overlay"></div>
    
    <?php require_once("../MainNav/nav.php");?>

	<!-- Contenido -->
	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-12">
					<div class="row">

						<?php
							if ($_SESSION["rol_id"]==1 || $_SESSION["rol_id"]==4 || $_SESSION["rol_id"]==7){
								?>
									<div class="col-sm-4">
										<article class="statistic-box green">
											<div>
												<div class="number" id="lbltotal"></div>
												<div class="caption"><div>Total de Tickets</div></div>
											</div>
										</article>
									</div>
									<div class="col-sm-4">
										<article class="statistic-box yellow">
											<div>
												<div class="number" id="lbltotalabierto"></div>
												<div class="caption"><div>Total de Tickets Abiertos</div></div>
											</div>
										</article>
									</div>
									<div class="col-sm-4">
										<article class="statistic-box red">
											<div>
												<div class="number" id="lbltotalcerrado"></div>
												<div class="caption"><div>Total de Tickets Cerrados</div></div>
											</div>
										</article>
									</div>
								<?php
							}else{
								?>
									<h5 align="center">Cantidad de Tickets Ingresados a su Grupo- <?php echo $_SESSION["sis_nom"] ?></h5>
									<div class="col-sm-3">
										<article class="statistic-box green">
											<div>
												<div class="number" id="lbltotal"></div>
												<div class="caption"><div>Total de Tickets</div></div>
											</div>
										</article>
									</div>
									<div class="col-sm-3">
										<article class="statistic-box yellow">
											<div>
												<div class="number" id="lbltotalabierto"></div>
												<div class="caption"><div>Total de Tickets Abiertos</div></div>
											</div>
										</article>
									</div>
									<div class="col-sm-3">
										<article class="statistic-box red">
											<div>
												<div class="number" id="lbltotalcerrado"></div>
												<div class="caption"><div>Total de Tickets Cerrados</div></div>
											</div>
										</article>
									</div>
									<div class="col-sm-3">
										<article class="statistic-box purple">
											<div>
												<div class="number" id="lbltotalsinasignar"></div>
												<div class="caption"><div>Total de Tickets Sin Asignar</div></div>
											</div>
										</article>
									</div>
								<?php
							}
						?>
					</div>
				</div>
			</div>

			<section class="card">
				<header class="card-header">
					Grafico Estadístico
				</header>
				<div class="card-block">
					<div id="divgrafico" style="height: 250px;"></div>
				</div>
			</section>

			

			<!-- insercion de reporte para roles de Mantencion -->
			<?php
				if($_SESSION["rol_id"]==2 || $_SESSION["rol_id"]==3 ){
				?>

					<section class="card">
							
							<header class="card-header">
								Resumen General "Gestion de Solicitudes TI Ranco" 
							</header>
							<div class="card-block" align="center">
								Hoja 1 : SISOR TI - Resumen 
							</div>
							<div class="card-block" align="center">
								<!-- <p>Proximamente...Estado en mantenimiento.</p> -->
								<iframe width="1000" height="600" src="https://app.powerbi.com/view?r=eyJrIjoiNTQ4NjAxMDctMGQ3Ni00NzgxLWJmODEtNGU4NzMyNjg4Nzg2IiwidCI6ImE1YzkyYjc1LTNkM2MtNGU1Mi05NjIxLTVjNTIwYzhkMGY5NCIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe> 
							</div>
						</section>


						

					
					
				<?php
			}?>


			<!-- insercion de reporte para roles de adquisiciones -->
			<?php
				if( $_SESSION["rol_id"]==8  || $_SESSION["rol_id"]==9){
				?>

						<section class="card">
							
							<header class="card-header">
								Resumen General "Gestion de Solicitudes Adquisiciones Ranco" 
							</header>
							<div class="card-block" align="center">
								Hoja 1 : SISOR OC - Adquisiciones Resumen 
							</div>
							<div class="card-block" align="center">
								<!-- <p>Proximamente...Estado en mantenimiento.</p> -->
								<iframe width="1000" height="600" src="https://app.powerbi.com/view?r=eyJrIjoiMWM4YjllODgtOWUwOS00NjhkLTg0MGItOTE1MjUwZWFhMzU1IiwidCI6ImE1YzkyYjc1LTNkM2MtNGU1Mi05NjIxLTVjNTIwYzhkMGY5NCIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe> 
							</div>
						</section>

					
					
				<?php
			}?>

		</div>
	</div>
	<!-- Contenido -->

	<?php require_once("../MainJs/js.php");?>
	<script
      type="text/javascript"
      src="https://alcdn.msauth.net/lib/1.4.0/js/msal.js"
    ></script>
    <script type="text/javascript">
      if (typeof Msal === "undefined")
        document.write(
          unescape(
            "%3Cscript src='https://alcdn.msftauth.net/lib/1.4.0/js/msal.js' type='text/javascript' %3E%3C/script%3E"
          )
        );
    </script>
    <script
      type="text/javascript"
    ></script>
    <script src="../../Msal/msal.js" type="text/javascript"></script>

	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script type="text/javascript" src="home.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta());
  }
?>