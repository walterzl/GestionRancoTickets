<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usu_id"])) {
?>
  <!DOCTYPE html>
  <html>
  <?php require_once("../MainHead/head.php"); ?>
  <title>Ranco::Detalle OC</title>
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
                <h3 id="lblnomidticket">Detalle Orden de Compra - </h3>
                <div id="lblestado"></div>
                <span class="label label-pill label-primary" id="lblnomusuario"></span>
                <span class="label label-pill label-default" id="lblfechcrea"></span>
                <ol class="breadcrumb breadcrumb-simple">
                  <li><a href="..\Home\">Home</a></li>
                  <!-- <li><a href="..\Consultarticket\">Consultar Orden de Compra</a></li> -->
                  <li class="active">Detalle Orden de Compra</li>
                  <!-- <li><a href="javascript:history.go(-1);" style="color:#FF0000;">Volver Atras</a></li> -->
                </ol>
              </div>
            </div>
          </div>
        </header>

        <div class="box-typical box-typical-padding">
          <div class="row">

              <input type="hidden" id="usu_asig" name="usu_asig">

              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tickoc_titulo">Titulo de la Solicitud</label>
                  <input type="text" class="form-control" id="tickoc_titulo" name="tickoc_titulo" readonly>
                </fieldset>
              </div>

              <!-- <div class="col-lg-2">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tickoc_coti_cerra">Ticket Cotizacion Asociado</label>
                  <input type="text" class="form-control" id="tickoc_coti_cerra" name="tickoc_coti_cerra" readonly>
                </fieldset>
              </div> -->

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

              <div class="col-lg-6" id="planta">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tick_Planta">Planta</label>
                  <input type="text" class="form-control" id="tick_Planta" name="tick_Planta" readonly>
                </fieldset>
              </div>

             <!--  <div class="col-lg-6" id="lbltipnom">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tip_nom">Tipo Solicitud </label>
                  <input type="text" class="form-control" id="tip_nom" name="tip_nom" readonly>
                </fieldset>
              </div> -->

              <!-- <div class="col-lg-6" id="lblcatid" style="visibility:hidden">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="cat_id">Tipo Categoria </label>
                  <select class="select2" id="cat_id" name="cat_id" data-placeholder="Seleccionar">
                    <option label="Seleccionar"></option>

                  </select>
                </fieldset>
              </div> -->

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

              <div class="col-lg-6">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="cntcon_nom">Cuenta Contable </label>
                  <input type="text" class="form-control" id="cntcon_nom" name="cntcon_nom" readonly>
                </fieldset>
              </div>

              <div class="col-lg-6">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="ent_nom">Entrega </label>
                  <input type="text" class="form-control" id="ent_nom" name="ent_nom" readonly>
                </fieldset>
              </div>

              <!-- <div class="col-lg-6">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="dura_nom">Duración </label>
                  <input type="text" class="form-control" id="dura_nom" name="dura_nom" readonly>
                </fieldset>
              </div> -->

              <div class="col-lg-6">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="TiempoEsperado_nom">Tiempo Esperado </label>
                  <input type="text" class="form-control" id="TiempoEsperado_nom" name="TiempoEsperado_nom" readonly>
                </fieldset>
              </div>

              <div class="col-lg-6">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="OpcionesCotizacion_nom">Cotizacion o Regularizaciòn* </label>
                  <input type="text" class="form-control" id="OpcionesCotizacion_nom" name="OpcionesCotizacion_nom" readonly>
                </fieldset>
              </div>

              <!-- <div class="col-lg-6">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="valor_estimado">Valor Estimado Maximo</label>
                  <input type="number" class="form-control" id="valor_estimado" name="valor_estimado" readonly>
                </fieldset>
              </div> -->


              <!-- ORDENES -->

              <div class="col-lg-12" id="Ocultar_para_Cotizacion" type="hidden" style="visibility:hidden">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tickoc_orden">Nro de Orden </label>
                  <input type="text" class="form-control" id="tickoc_orden" name="tickoc_orden">
                </fieldset>
              </div>


              <div class="col-lg-6"  id="RegistroOrden">
                  <fieldset class="form-group">
                      <label class="form-label semibold" for="numeroOrdenAsignado">Asociar Numero Orden</label>
                      <div class="input-group bootstrap-touchspin input-group">
                          <input type="number" class="form-control" id="numeroOrdenAsignado" name="numeroOrden_id" placeholder="Ingrese el numeroOrden para Registar" min="0" oninput="validity.valid||(value='');" required>
                          <span class="input-group-addon bootstrap-touchspin-postfix btn btn-default" id="btnagregarNumeroOrden">Agregar</span>
                      </div>
                  </fieldset>
              </div>

              <?php
                if( $_SESSION["rol_id"]==8  || $_SESSION["rol_id"]==9){
                ?>

                  <div class="col-lg-6">
                    <fieldset class="form-group">
                      <!-- <label class="form-label semibold" for="tickocd_descripusu" style="color:red;" align=center>Numero de Ordenes asignadas al Ticket</label> -->
                      <div id = "lblOrdnesAsignadas">

                      </div>

                    </fieldset>
                  </div>
                  
                <?php
              }else {
                # code...
                ?>

                <div class="col-lg-12">
                  <fieldset class="form-group">
                    <!-- <label class="form-label semibold" for="tickocd_descripusu" style="color:red;" align=center>Numero de Ordenes asignadas al Ticket</label> -->
                    <div id = "lblOrdnesAsignadas">

                    </div>

                  </fieldset>
                </div>
                
              <?php
              }
              
              ?>

              

             
              <!-- X -->
              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="estoc_id">Estado de la Orden</label>
							    <div class="input-group bootstrap-touchspin input-group">
                      <span class="input-group-btn"></span>
                      <select class="select2" id="estoc_id" name="estoc_id" data-placeholder="Seleccionar">
                      <option label="Seleccionar"></option>

                      </select>
                      <span class="input-group-addon bootstrap-touchspin-postfix btn btn-default" id="btnagregar">Agregar</span>
                  </div>
                </fieldset>
              </div>

              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tickocd_descripusu" style="color:red;" align=center>Registro de Estados la Orden de Compra - Flujo</label>
                  <div id = "lblestadosoc">

                  </div>

                </fieldset>
              </div>
              

              <div class="col-lg-12">
                <fieldset class="form-group">
                  <!-- <label class="form-label semibold" for="tickocd_descripusu">Cotizacion Formal y/o Documentos Adicionales</label> -->
                  <table id="documentos_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                      <tr>
                        <th style="width: 90%;">Documentos Solicitante</th>
                        <th class="text-center" style="width: 5%;" align=center>Ver Documento</th>
                      </tr>
                    </thead>
                    <tbody >

                    </tbody>
                  </table>

                </fieldset>
              </div>

              <div class="col-lg-12">
                <fieldset class="form-group">
                 <!--  <label class="form-label semibold" for="tickocd_descripusu">Cotizacion Formal y/o Documentos Adicionales</label> -->
                  <table id="documentos_data2" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                      <tr>
                        <th style="width: 90%;">Documentos Agentes</th>
                        <th class="text-center" style="width: 5%;" align=center>Ver Documento</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>

                </fieldset>
              </div>

              

              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tickocd_descripusu">Descripción del Ticket OC</label>
                  <div class="summernote-theme-1">
                    <textarea id="tickocd_descripusu" name="tickocd_descripusu" class="summernote" name="name"></textarea>
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
                  <label class="form-label semibold" for="tickocd_descrip">Ingrese Descripción de su Duda-Consulta-Comentario</label>
                  <div class="summernote-theme-1">
                    <textarea id="tickocd_descrip" name="tickocd_descrip" class="summernote" name="name"></textarea>
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
                    <button type="button" id="btncerrarticket" class="btn btn-rounded btn-inline btn-warning">Cerrar OC</button>
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

    <script type="text/javascript" src="detalleticketoc.js">

      /* var rol = 10; */ // Aquí debes asignar el valor del rol dinámicamente

      var rol =  $('#rol_idx').val();

      console.log(rol);

      if (rol != 7 ) {
          document.getElementById('RegistroOrden').style.display = 'none';
      }
  
   </script>
    
  </body>

  </html>
<?php
} else {
  require_once("../../models/Ticketoc.php");
  $ticketoc = new Ticketoc();
  $ticx = $ticketoc->listar_ticketoc_x_id($_GET["ID"]);
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
        header("Location:" . Conectar::ruta() . "index.php?s=3");
      }
    }
}
?>