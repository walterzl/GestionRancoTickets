<div id="modalmantenimiento" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form method="post" id="rol_form">
                <div class="modal-body">
                    <input type="hidden" id="rol_id" name="rol_id">

                    <div class="form-group">
                        <label class="form-label" for="rol_nom">Nombre</label>
                        <input type="text" class="form-control" id="rol_nom" name="rol_nom" placeholder="Ingrese Nombre" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="rol_color">Color</label>
                        <input type="text" class="form-control" id="rol_color" name="rol_color" placeholder="Ingrese Color" required>
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