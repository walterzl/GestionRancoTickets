<div id="modalmantenimiento" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form method="post" id="usuario_form">
                <div class="modal-body">
                    <input type="hidden" id="usu_id" name="usu_id">

                    <div class="form-group">
                        <b style="color:#FF0000" align="center">IMPORTANTE:</b><b>Los campos obligatorios presentan este simbolo a su costado (*)</b>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="usu_nom">Nombre *</label>
                        <input type="text" class="form-control" id="usu_nom" name="usu_nom" placeholder="Ingrese Nombre" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="usu_ape">Apellido *</label>
                        <input type="text" class="form-control" id="usu_ape" name="usu_ape" placeholder="Ingrese Apellido" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="usu_correo">Correo Electronico *</label>
                        <input type="email" class="form-control" id="usu_correo" name="usu_correo" placeholder="test@test.com" required>
                    </div>
                    <!-- Ocultando input de contraseña -->
                    <input type="hidden" id="usu_pass" name="usu_pass" value="1111">

                    <div class="form-group">
                        <label class="form-label" for="rol_id">Rol *</label>
                        <select class="select2" id="rol_id" name="rol_id" data-placeholder="Seleccionar">

                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="grupo_id">Grupo *</label>
                        <select class="select2" id="grupo_id" name="grupo_id" data-placeholder="Seleccionar">

                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="area_id">Area *</label>
                        <select class="select2" id="area_id" name="area_id" data-placeholder="Seleccionar">

                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="suba_id">Sub Area *</label>
                        <select class="select2" id="suba_id" name="suba_id" data-placeholder="Seleccionar">

                        </select>
                    </div>

                    <div class="form-group">
                        <b style="color:#FF0000" align="center">IMPORTANTE: </b><b>Es importante que complete todos los campos antes de PRESIONAR "GUARDAR"</b>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" id="#" value="add" class="btn btn-rounded btn-primary">Guardar</button>
                </div>

               

                
            </form>
        </div>
    </div>
</div>