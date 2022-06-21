<div id="modalmantenimiento" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form method="post" id="categoria_form">
                <div class="modal-body">
                    <input type="hidden" id="cat_id" name="cat_id">

                    <div class="form-group">
                        <b style="color:#FF0000" align="center">IMPORTANTE:</b><b>Los campos obligatorios presentan este simbolo a su costado (*)</b>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="grupo_id">Grupo *</label>
                        <select class="select2" id="grupo_id" name="grupo_id" data-placeholder="Seleccionar">

                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="cat_nom">Nombre *</label>
                        <input type="text" class="form-control" id="cat_nom" name="cat_nom" placeholder="Ingrese Nombre" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tip_id">Tipo *</label>
                        <select class="select2" id="tip_id" name="tip_id" data-placeholder="Seleccionar">

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