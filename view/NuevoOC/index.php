<?php
  require_once("../../config/conexion.php");
  if(isset($_SESSION["usu_id"])){
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>Ranco::Nuevo OC</title>
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
							<h3>Nuevo OC - <?php echo $_SESSION["sis_nom"] ?></h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="..\Home\">Home</a></li>
								<li class="active">Nuevo OC</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<form method="post" id="ticket_form">
				<div class="box-typical box-typical-padding">
					
					<h5 class="m-t-lg with-border">Ingresar Información de la Orden</h5>
					<p  style="color:#FF0000;" align="center">
					“La información contable asignada en los sgtes campos se cargará a la Orden de Compra y presupuesto del área” </br> <b> “Se emiten OC los lunes, miércoles y viernes, hasta las 14:00 hrs”</b>
					</p>

					<!-- <h5 class="m-t-lg with-border">Ingresar Información</h5> -->

					<div class="row">

						<input type="hidden" id="usu_id" name="usu_id" value="<?php echo $_SESSION["usu_id"] ?>">

						<input type="hidden" id="tickoc_coti_cerra" name="tickoc_coti_cerra">

						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label semibold" for="tickoc_titulo">Titulo de su Solicitud*</label>
								<input type="text" class="form-control" id="tickoc_titulo" name="tickoc_titulo" placeholder="Ingrese Titulo de su Solicitud" required>
							</fieldset>
						</div>

						<div class="col-lg-3">
							<fieldset class="form-group">
								<label class="form-label semibold" for="tip_id">Tipo Solicitud*</label>
								<select id="tip_id" name="tip_id" class="select2" data-placeholder="Seleccione" required>

								</select>
							</fieldset>
						</div>

						<div class="col-lg-3">
							<fieldset class="form-group">
								<label class="form-label">&nbsp;</label>
								<a id="btnseleccionarcoti" name="btnseleccionarcoti" class="btn btn-success">Asociar Ticket con Cotizacion</a>
							</fieldset>
						</div>

						<div class="col-lg-1">
							<fieldset class="form-group">
								<label class="form-label">Nro Coitizacion Asociado</label>
								<input type="text" class="form-control" id="correlativo" name="correlativo" readonly>
							</fieldset>
						</div>

						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label semibold" for="area_id">Centro de Costo*</label>
								<select id="area_id" name="area_id" class="select2" data-placeholder="Seleccione" required>

								</select>
							</fieldset>
						</div>

						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label semibold" for="suba_id">Sub Centro de Costo*</label>
								<select id="suba_id" name="suba_id" class="select2" data-placeholder="Seleccione" required>

								</select>
							</fieldset>
						</div>

						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label semibold" for="cntcon_id">Cuenta Contable*</label>
								<select id="cntcon_id" name="cntcon_id" class="select2" data-placeholder="Seleccione" required>

								</select>
							</fieldset>
						</div>

						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label semibold" for="ent_id">Entrega*</label>
								<select id="ent_id" name="ent_id" class="select2" data-placeholder="Seleccione" required>

								</select>
							</fieldset>
						</div>

						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label semibold" for="dura_id">Duración*</label>
								<select id="dura_id" name="dura_id" class="select2" data-placeholder="Seleccione" required>

								</select>
								<small class="text-muted" id="lblmendura">El iva sujeto a esta OC será retenido hasta que se envíe el comprobante de pago de cotizaciones de los trabajadores contratados por el proveedor</small>
							</fieldset>
						</div>

						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label semibold" for="fileElem">Adjuntar Cotizacion Formal del Proveedor y/o Documentos Adicionales*</label>
								<input type="file" name="fileElem" id="fileElem" class="form-control" multiple >
							</fieldset>
						</div>

						<div class="col-lg-6">
							<fieldset class="form-group" style="visibility:hidden">
								<label class="form-label semibold" for="cat_id">Categoria de la Solicitud*</label>
								<select id="cat_id" name="cat_id" class="select2" data-placeholder="Seleccione el Tipo de Categoria" required >

								</select>
							</fieldset>
						</div>

						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label semibold" for="tickoc_descrip">Ingresar detalle de la Orden de Compra Solicitada o detalle de la documentacion*</label>
								<div class="summernote-theme-1">
									<textarea id="tickoc_descrip" name="tickoc_descrip" class="summernote" name="name" placeholder="Ingrese la Descripcion de su incidente o problema aqui"></textarea>
								</div>
							</fieldset>
						</div>

						<div class="col-lg-12 text-center">
							<button type="submit" name="action" value="add" class="btn btn-rounded btn-inline btn-primary">Guardar Orden</button>
						</div>

					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- Contenido -->

	<?php require_once("modalcotizacion.php");?>

	<?php require_once("../MainJs/js.php");?>

	<script type="text/javascript" src="nuevooc.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>