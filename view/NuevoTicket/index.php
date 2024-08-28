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
	
	<title>Ranco::Nuevo Ticket</title>
</head>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

    <div class="mobile-menu-left-overlay"></div>

    <?php require_once("../MainNav/nav.php");?>

	<div class="page-content">
		<div class="container-fluid">

			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Nuevo Ticket - <?php echo $_SESSION["sis_nom"] ?></h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="..\Home\">Home</a></li>
								<li class="active">Nuevo Ticket</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<form method="post" id="ticket_form">
				<div class="box-typical box-typical-padding">
					<p>
						Desde esta ventana podrá generar nuevos tickets de HelpDesk. Ingrese todos los datos e información solicitados en el formulario, <b>los campos obligatorios presentan este símbolo a su costado (*).</b>
					</p>

					<h5 class="m-t-lg with-border">Ingresar Información</h5>

					<div class="row">

						<input type="hidden" id="usu_id" name="usu_id" value="<?php echo $_SESSION["usu_id"] ?>">

						<input type="hidden" id="area_id" name="area_id" value="<?php echo $_SESSION["area_id"] ?>">

						<input type="hidden" id="suba_id" name="suba_id" value="<?php echo $_SESSION["suba_id"] ?>">

						<div class="col-lg-4">
							<fieldset class="form-group">
								<label class="form-label semibold" for="tip_id">Tipo Solicitud*</label>
								<select id="tip_id" name="tip_id" class="select2" data-placeholder="Seleccione Tipo de Solicitud">

								</select>
							</fieldset>
						</div>

						<div class="col-lg-5" id="cat_ido">
							<fieldset class="form-group">
								<label class="form-label semibold" for="cat_id">Categoria de la Solicitud*</label>
								<select id="cat_id" name="cat_id" class="select2" data-placeholder="Seleccione el Tipo de Categoria">

								</select>
							</fieldset>
						</div>

						<div class="col-lg-3">
							<fieldset class="form-group">
								<label class="form-label semibold" for="tick_Planta">Planta*</label>
								<select id="tick_Planta" name="tick_Planta" class="select2" data-placeholder="Seleccione Planta">
									<option label='Seleccionar'></option>
									<option value='Rancagua'>Rancagua</option>
									<option value='Chimbarongo'>Chimbarongo</option>
									<option value='La Union'>La Union</option>
								</select>
							</fieldset>
						</div>

						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label semibold" for="tick_titulo">Titulo de su Solicitud*</label>
								<input type="text" class="form-control" id="tick_titulo" name="tick_titulo" placeholder="Ingrese Titulo de su Solicitud">
							</fieldset>
						</div>

						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label semibold" for="tick_prio">Prioridad de su solicitud*</label>
								<select id="tick_prio" name="tick_prio" class="select2" data-placeholder="Seleccione Prioridad">
									<option label='Seleccionar'></option>
									<option value='Baja'>Baja</option>
									<option value='Media'>Media</option>
									<option value='Alta'>Alta</option>
									<!-- <option value='Consulta'>Consulta</option>
									<option value='Requerimiento'>Requerimiento</option>
									<option value='Requerimiento'>Incidente</option> -->
								</select>
							</fieldset>
						</div>

						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label semibold" for="fileElem">Documentos Adicionales</label>
								<input type="file" name="fileElem" id="fileElem" class="form-control" multiple>
							</fieldset>
						</div>

						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label semibold" for="tick_descrip">Descripción del Incidente o Problema*</label>
								<div class="summernote-theme-1">
									<textarea id="tick_descrip" name="tick_descrip" class="summernote" name="name" placeholder="Ingrese la Descripcion de su incidente o problema aqui"></textarea>
								</div>
							</fieldset>
						</div>

						<div id="loading-message1" style="display: none; text-align: center; font-style: italic; font-weight: bold;">Cargando...</div>

						<div id="loading-message2" style="display: none; text-align: center; font-style: italic; font-weight: bold;">Problema en la conexion, por favor verifique y vuelva a cargar la web</div>

						<div class="col-lg-12 text-center text-center" text-center>
							<button type="submit" name="action" value="add" class="btn btn-rounded btn-inline btn-primary">Guardar</button>
						</div>

					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- Contenido -->

	<?php require_once("../MainJs/js.php");?>

	<script type="text/javascript" src="nuevoticket.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>