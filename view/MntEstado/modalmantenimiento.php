<div id="modalmantenimiento" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form method="post" id="estado_form">
                <div class="modal-body">
                    <input type="hidden" id="estoc_id" name="estoc_id">

                    <div class="form-group">
                        <b style="color:#FF0000" align="center">IMPORTANTE:</b><b>Los campos obligatorios presentan este simbolo a su costado (*)</b>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tip_id">Tipo 1 *</label>
                        <select class="select2" id="tip_id" name="tip_id" data-placeholder="Seleccionar">

                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="estoc_nom1">Nombre 1 *</label>
                        <input type="text" class="form-control" id="estoc_nom1" name="estoc_nom1" placeholder="Ingrese Nombre" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="estoc_nom2">Nombre 2 *</label>
                        <input type="text" class="form-control" id="estoc_nom2" name="estoc_nom2" placeholder="Ingrese Nombre" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="estoc_campo">Campo *</label>
                        <select class="select2" id="estoc_campo" name="estoc_campo" data-placeholder="Seleccionar">
                            <option value='fech_dig'>fech_dig</option>
                            <option value='fech_apro'>fech_apro</option>
                            <option value='fech_envprov'>fech_envprov</option>
                            <option value='fech_repbode'>fech_repbode</option>
                            <option value='fech_rechbode'>fech_rechbode</option>
                            <option value='fech_contactoprov'>fech_contactoprov</option>
                            <option value='fech_envpropuesta'>fech_envpropuesta</option>
                            <option value='fech_repbode_incompleto'>fech_repbode_incompleto</option>
                            <option value='fech_repbode_noconforme'>fech_repbode_noconforme</option>
                            <option value='fech_serviconforme'>fech_serviconforme</option>
                            <option value='fech_norequiere'>fech_norequiere</option>
                            <option value='fech_noajustapresup'>fech_noajustapresup</option>
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