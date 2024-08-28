<?php
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>Ranco::Tickets ingresados por mi</title>
	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Last-Modified" content="0">
	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
	<meta http-equiv="Pragma" content="no-cache">
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

			<?php 
				if($_SESSION["sis_id"]==3){
				?> 
										
				<?php
				}else{
				?> 
					<div class="row">
					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label semibold" for="tip_id">Tipo</label>
							<select id="tip_id" name="tip_id" class="select2" data-placeholder="Seleccionar">

							</select>
						</fieldset>
					</div>

					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label semibold" for="tick_Planta">Planta</label>
							<select id="tick_Planta" name="tick_Planta" class="select2" data-placeholder="Seleccionar">

							<?php 
								if($_SESSION["sis_id"]==3){
									?> 
										<option value='Rancagua'>Rancagua</option>
										<option value='Chimbarongo'>Chimbarongo</option>
										<option value='Rancagua y Chimbarongo'>Rancagua y Chimbarongo</option>
										<option value='La Union'>La Union</option>
										<option value='Plantas Externas'>Plantas Externas</option>
									<?php
								}else{
									?> 
										<option label='Seleccionar'></option>
										<option value='Rancagua'>Rancagua</option>
										<option value='Chimbarongo'>Chimbarongo</option>
										<option value='La Union'>La Union</option>
									<?php
								}
							?>
									
							</select>
						</fieldset>
					</div>

					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label semibold" for="area_id">Area</label>
							<select id="area_id" name="area_id" class="select2" data-placeholder="Seleccionar">

							</select>
						</fieldset>
					</div>

					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label semibold" for="tick_estado">Estado</label>
							<select id="tick_estado" name="tick_estado" class="select2" data-placeholder="Seleccionar">
								<option label="Seleccionar"></option>
								<option value="Abierto" selected>Abierto</option>
								<option value="Cerrado">Cerrado</option>
							</select>
						</fieldset>
					</div>

					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label semibold" for="usu_asig_est">Asignación</label>
							<select id="usu_asig_est" name="usu_asig_est" class="select2" data-placeholder="Seleccionar">
								<option label="Seleccionar"></option>
								<option value="Si">Asignados</option>
								<option value="No">No Asignados</option>
							</select>
						</fieldset>
					</div>

					<div class="col-lg-2" id="divorden">
						<fieldset class="form-group">
							<label class="form-label semibold" for="tickoc_orden">Nro Orden</label>
							<input type="text" class="form-control" id="tickoc_orden" name="tickoc_orden">
						</fieldset>
					</div>

					<div class="col-lg-2" id="divestado">
						<fieldset class="form-group">
							<label class="form-label semibold" for="estoc_id">Estado Orden</label>
							<select id="estoc_id" name="estoc_id" class="select2" data-placeholder="Seleccionar">
								<option label="Seleccionar"></option>

							</select>
						</fieldset>
					</div>

					<div class="col-lg-2" id="divcrea">
						<fieldset class="form-group">
							<label class="form-label semibold" for="fech_crea">Fecha Creación</label>
							<input type="date" class="form-control" id="fech_crea" name="fech_crea">
						</fieldset>
					</div>

					<div class="col-lg-1">
						<fieldset class="form-group">
							<label class="form-label semibold" for="usu_asig_est">&nbsp;</label>
							<button type="submit" class="btn btn-rounded btn-default btn-block" id="btntodo">Todos</button>
						</fieldset>
					</div>

					<div class="col-lg-1">
						<fieldset class="form-group">
							<label class="form-label semibold" for="usu_asig_est">&nbsp;</label>
							<button type="submit" class="btn btn-rounded btn-primary btn-block" id="btnfiltrar">Filtrar</button>
						</fieldset>
					</div>
				</div>					
				<?php
				}
			?>

				
			</div>

			<div class="box-typical box-typical-padding" id="table">
				<table id="ticket_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
							<?php 
								if($_SESSION["sis_id"]==3){
									?> 
										<th style="width: 5%;">Nro</th>
										<th style="width: 5%;">Orden Asignada</th>
										<th style="width: 15%;">Tipo</th>
										<th style="width: 15%;">Area</th>
										<th style="width: 15%;">Sub Area</th>
										<th class="d-none d-sm-table-cell" style="width: 40%;">Titulo</th>
										<th class="d-none d-sm-table-cell" style="width: 40%;">Planta</th>
										<th style='width: 15%;'>Entrega</th>
										<th style='width: 15%;'>Tiempo Esperado</th>
										<th style='width: 15%;'>Cotizacion o Regularización</th>
										<!-- <th style='width: 15%;'>Valor Estimado $</th> -->
										<th style='width: 15%;'>Est.Orden</th>
										<th class="d-none d-sm-table-cell" style="width: 5%;">Est.</th>
										<th class="d-none d-sm-table-cell" style="width: 20%;">Fecha Creación</th>
										<th class="d-none d-sm-table-cell" style="width: 25%;">Fecha Cierre</th>
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