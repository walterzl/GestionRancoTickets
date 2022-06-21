var tabla;
var usu_id = $('#user_idx').val();
var rol_id = $('#rol_idx').val();
var sis_id = $('#sis_idx').val();

function init(){
    $("#rol_form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

function guardaryeditar(e){
    e.preventDefault();
	var formData = new FormData($("#rol_form")[0]);
    $.ajax({
        url: "../../controller/rol.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            console.log(datos);
            $('#rol_form')[0].reset();
            $("#modalmantenimiento").modal('hide');
            $('#rol_data').DataTable().ajax.reload();

            swal({
                title: "SISOR!",
                text: "Completado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
}

$(document).ready(function(){

    tabla=$('#rol_data').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
                ],
        "ajax":{
            url: '../../controller/rol.php?op=listar',
            type : "post",
            dataType : "json",
            data : {sis_id,sis_id},
            error: function(e){
                console.log(e.responseText);	
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    }).DataTable();
});

function editar(rol_id){
    $('#mdltitulo').html('Editar Registro');

    $.post("../../controller/rol.php?op=mostrar",{rol_id : rol_id},function (data) {
        data = JSON.parse(data);
        $('#rol_id').val(data.rol_id);
        $('#rol_nom').val(data.rol_nom);
        $('#rol_color').val(data.rol_color);
    });

    $('#modalmantenimiento').modal('show');
}

function eliminar(rol_id){
    swal({
        title: "SISOR!",
        text: "Esta seguro de Eliminar el registro?",
        type: "error",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false
    },
    function(isConfirm) {
        if (isConfirm) {
            $.post("../../controller/rol.php?op=eliminar",{rol_id:rol_id},function (data) {

            }); 

            $('#rol_data').DataTable().ajax.reload();	

            swal({
                title: "SISOR!",
                text: "Registro Eliminado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
}

$(document).on("click","#btnnuevo", function(){
    $('#rol_id').val('');
    $('#mdltitulo').html('Nuevo Registro');
    $('#rol_form')[0].reset();
    $('#modalmantenimiento').modal('show');
});

init();