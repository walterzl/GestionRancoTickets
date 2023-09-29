<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>Ranco::Tickets ingresados por mi</title>
</head>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

    <div class="mobile-menu-left-overlay"></div>
    
    <?php require_once("../MainNav/nav.php");?>

	<!-- Contenido -->
	<div class="page-content">
		<div class="container-fluid">

			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Tickets ingresados por mi</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="..\Home\">Home</a></li>
								<li class="active">Tickets ingresados por mi</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				<table id="ticket_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
							<?php 
								if($_SESSION["sis_id"]==3){
									?> 
										<th style="width: 5%;">Nro</th>
										<th style="width: 5%;">Orden</th>
										<th style="width: 15%;">Tipo</th>
										<th style="width: 15%;">Categoria</th>
										<th style="width: 15%;">Area</th>
										<th style="width: 15%;">Sub Area</th>
										<th class="d-none d-sm-table-cell" style="width: 40%;">Titulo</th>
										<th class="d-none d-sm-table-cell" style="width: 40%;">Est.Orden</th>
										<th class="d-none d-sm-table-cell" style="width: 5%;">Est.</th>
										<th class="d-none d-sm-table-cell" style="width: 20%;">Fech.Creación</th>
										<th class="d-none d-sm-table-cell" style="width: 25%;">Fech.Cierre</th>
										<!-- columnas de flujo -->
										<!-- <th class="d-none d-sm-table-cell" style="width: 25%;">Fech.Orden Digitada</th>
										<th class="d-none d-sm-table-cell" style="width: 25%;">Fech.Orden Aprobada</th>
										<th class="d-none d-sm-table-cell" style="width: 25%;">Fech.Orden Env.Prov.</th>
										<th class="d-none d-sm-table-cell" style="width: 25%;">Fech.Orden Recep.Bodega</th> -->
										<!--  -->
										<th class="d-none d-sm-table-cell" style="width: 25%;">Agente Asignado</th>
										<th class="text-center" style="width: 5%;">Ver</th>
									<?php
								}else{
									?> 
										<th style="width: 5%;">Nro</th>
										<th style="width: 15%;">Tipo</th>
										<th style="width: 15%;">Categoria</th>
										<th style="width: 15%;">Planta x</th>
										<th style="width: 15%;">Area</th>
										<th style="width: 15%;">Sub Area</th>
										<th class="d-none d-sm-table-cell" style="width: 40%;">Titulo</th>
										<th class="d-none d-sm-table-cell" style="width: 5%;">Prioridad</th>
										<th class="d-none d-sm-table-cell" style="width: 5%;">Est.</th>
										<th class="d-none d-sm-table-cell" style="width: 20%;">Fecha Creación</th>
										<th class="d-none d-sm-table-cell" style="width: 25%;">Fecha Cierre</th>
										<th class="d-none d-sm-table-cell" style="width: 25%;">Agente Asignado</th>
										<th class="text-center" style="width: 5%;">Ver</th>
									<?php
								}
							?>
								
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
			</div>

		</div>
	</div>
	<!-- Contenido -->

	<?php require_once("modalasignar.php");?>

	<?php require_once("../MainJs/js.php");?>
	
	<script type="text/javascript" src="consultarticket.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>