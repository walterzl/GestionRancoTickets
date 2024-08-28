<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usu_id"])) {
?>
  <!DOCTYPE html>
  <html>
  <?php require_once("../MainHead/head.php"); ?>
  <title>Ranco::Detalle Ticket</title>
  </head>

  <body class="with-side-menu">

    <?php require_once("../MainHeader/header.php"); ?>

    <div class="mobile-menu-left-overlay"></div>

    <?php require_once("../MainNav/nav.php"); ?>

    <!-- Contenido -->
    <div class="page-content">
      <div class="container-fluid">

        <header class="section-header">
          <div class="tbl">
            <div class="tbl-row">
              <div class="tbl-cell">
                <h3 id="lblnomidticket">Detalle Ticket - </h3>
                <div id="lblestado"></div>
                <span class="label label-pill label-warning" id="tick_PlantaTEXT"></span>

                <span class="label label-pill label-primary" id="lblnomusuario"></span>
                <span class="label label-pill label-default" id="lblfechcrea"></span>
                
                <ol class="breadcrumb breadcrumb-simple">
                  <li><a href="..\Home\">Home</a></li>
                  <!-- <li><a href="..\TicketIngresados\">Tickets Ingresados</a></li> -->
                  <li class="active">Detalle Ticket</li>
                  <!-- <li><a href="javascript:history.go(-1);" style="color:#FF0000;">Volver Atras</a></li> -->
                  <!-- <li><a href="window.history.back(-1);" style="color:#FF0000;">Volver Atras</a></li> -->
                </ol>
              </div>
            </div>
          </div>
        </header>

        <div class="box-typical box-typical-padding">
          <div class="row">

              <input type="hidden" id="usu_asig" name="usu_asig">

              <div class="col-lg-6">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="area_nom">Centro de Costo Solicitante</label>
                  <input type="text" class="form-control" id="area_nom" name="area_nom" readonly>
                </fieldset>
              </div>

              <div class="col-lg-6">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="suba_nom">Sub Centro de Costo</label>
                  <input type="text" class="form-control" id="suba_nom" name="suba_nom" readonly>
                </fieldset>
              </div>

              <div class="col-lg-6" id="lbltipnom">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tip_nom">Tipo Solicitud </label>
                  <input type="text" class="form-control" id="tip_nom" name="tip_nom" readonly>
                </fieldset>
              </div>

              <div class="col-lg-6" id="lbltipid">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tip_id">Tipo Solicitud </label>
                  <select class="select2" id="tip_id" name="tip_id" data-placeholder="Seleccionar">
                    <option label="Seleccionar"></option>
                    <option value="1">Soporte e infraestructura</option>
                    <option value="2">Soporte SDT</option>
                    <option value="3">Desarrollo</option>
                  </select>
                </fieldset>
              </div>

              <div class="col-lg-6" id="lblcatid">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="cat_id">Tipo Categoria </label>
                  <select class="select2" id="cat_id" name="cat_id" data-placeholder="Seleccionar">
                    <option label="Seleccionar"></option>

                  </select>
                </fieldset>
              </div>

              <div class="col-lg-6" id="lblcatnom">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="cat_nom">Categoria </label>
                  <input type="text" class="form-control" id="cat_nom" name="cat_nom" readonly>
                </fieldset>
              </div>

              

              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tick_titulo">Titulo</label>
                  <input type="text" class="form-control" id="tick_titulo" name="tick_titulo" readonly>
                </fieldset>
              </div>

              <div class="col-lg-3" id="planta">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tick_Planta">Planta</label>
                  <input type="text" class="form-control" id="tick_Planta" name="tick_Planta" readonly>
                </fieldset>
              </div>

              <div class="col-lg-3">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tick_prio">Prioridad</label>
                  <input type="text" class="form-control" id="tick_prio" name="tick_prio" readonly>
                </fieldset>
              </div>

              <div class="col-lg-3" id="lbloPrioridaInterna">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tick_prioInt">Prioridad Interna</label>
                  <select class="select2" id="tick_prioInt" name="tick_prioInt" data-placeholder="Seleccionar">
                    <option label="Seleccionar"></option>
                    <!-- opciones de sistema 1 TI -->
                    <?php
                      if($_SESSION["sis_id"]==1){
                      ?>

                        <option value="Baja">Baja</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                        <option value="Crítico">Crítico</option>
                      
                      <?php
                    }?>
                    

                    <!-- opciones de sistema 2 Mantencion -->
                    <?php
                      if($_SESSION["sis_id"]==2){
                      ?>

                        <!-- <option value="Incidente">Incidente</option>
                        <option value="Mantencion">Mantención</option>
                        <option value="Modificacion">Modificacion</option>
                        <option value="Mejora">Mejora</option> -->
                        
                      <?php
                    }?>
                  </select>
                </fieldset>
              </div>

              <div class="col-lg-3" id="lblopcion">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tick_opc">Opción</label>
                  <select class="select2" id="tick_opc" name="tick_opc" data-placeholder="Seleccionar">
                    <option label="Seleccionar"></option>
                    <!-- opciones de sistema 1 TI -->
                    <?php
                      if($_SESSION["sis_id"]==1){
                      ?>

                        <option value="Incidente">Incidente</option>
                        <option value="Mantención">Mantención</option>
                        <option value="Consulta">Consulta</option>
                        <option value="Requerimiento">Requerimiento</option>
                        <option value="Requerimiento">Mejora</option>
                      <?php
                    }?>
                    

                    <!-- opciones de sistema 2 Mantencion -->
                    <?php
                      if($_SESSION["sis_id"]==2){
                      ?>

                        <option value="Incidente">Incidente</option>
                        <option value="Mantencion">Mantencion</option>
                        <option value="Modificacion">Modificacion</option>
                        <option value="Mejora">Mejora</option>
                        
                      <?php
                    }?>
                  </select>
                </fieldset>
              </div>

              

              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tickd_descripusu">Documentos Adicionales</label>
                  <table id="documentos_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                      <tr>
                        <th style="width: 90%;">Nombre</th>
                        <th class="text-center" style="width: 5%;"></th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>

                </fieldset>
              </div>

              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tickd_descripusu">Descripción del Problema</label>
                  <div class="summernote-theme-1">
                    <textarea id="tickd_descripusu" name="tickd_descripusu" class="summernote" name="name"></textarea>
                  </div>

                </fieldset>
              </div>

          </div>
        </div>

        <section class="activity-line" id="lbldetalle">

        </section>

        <div class="box-typical box-typical-padding" id="pnldetalle">
          <p>
            Ingrese su Duda,Consulta o Comentarios
          </p>
          <div class="row">
              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tickd_descrip">Ingrese Descripción de su Duda-Consulta-Comentario</label>
                  <div class="summernote-theme-1">
                    <textarea id="tickd_descrip" name="tickd_descrip" class="summernote" name="name"></textarea>
                  </div>
                </fieldset>
              </div>

              <!-- TODO: Agregar archivos adjuntos -->
              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="fileElem">Documentos Adicionales</label>
                  <input type="file" name="fileElem" id="fileElem" class="form-control" multiple>
                </fieldset>
              </div>

              <?php
							if ($_SESSION["rol_id"]==1){
								?>
                  <div class="col-lg-12">
                    <button type="button" id="btnenviar" class="btn btn-rounded btn-inline btn-primary">Enviar</button>
                  </div>

								<?php
							}else{
								?>

                  <div class="col-lg-12">
                    <button type="button" id="btnenviar" class="btn btn-rounded btn-inline btn-primary">Enviar</button>
                    <button type="button" id="btncerrarticket" class="btn btn-rounded btn-inline btn-warning">Cerrar Ticket</button>
                  </div>

								<?php
							}
						?>

          </div>
			  </div>

      </div>
    </div>
    <!-- Contenido -->

    <?php require_once("../MainJs/js.php"); ?>

    <script type="text/javascript" src="detalleticket.js"></script>

  </body>

  </html>
<?php
} else {
  require_once("../../models/Ticket.php");
  $ticket = new Ticket();
  $ticx = $ticket->listar_ticket_x_id($_GET["ID"]);

  for ($i = 0; $i < sizeof($ticx); $i++) {
    if ($ticx[$i]["sis_id"]=$_SESSION["sis_id"]){
      echo $ticx[$i]["sis_id"];
      if($ticx[$i]["sis_id"]=="1"){
        header("Location:" . Conectar::ruta() . "index.php?s=1");
      }else if($ticx[$i]["sis_id"]=="2"){
        header("Location:" . Conectar::ruta() . "index.php?s=2");
      }else{
        header("Location:" . Conectar::ruta() . "index.php?s=3");
      }
    }else{
      /* header("Location:" . Conectar::ruta() . "303-detalleTicket.php"); */
      header("Location:" . Conectar::ruta() . "index.php?s=1");
    }

  }

}
?>