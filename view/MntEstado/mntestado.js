var tabla;
var usu_id =  $('#user_idx').val();
var rol_id =  $('#rol_idx').val();
var sis_id =  $('#sis_idx').val();

function init(){
    $("#estado_form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

function guardaryeditar(e){
    e.preventDefault();
	var formData = new FormData($("#estado_form")[0]);
    $.ajax({
        url: "../../controller/estado.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            $('#estado_form')[0].reset();
            $("#modalmantenimiento").modal('hide');
            $('#estado_data').DataTable().ajax.reload();

            swal({
                title: "SISOR!!",
                text: "Completado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    }); 
}

$(document).ready(function(){

    $.post("../../controller/tipo.php?op=combo",{sis_id:sis_id}, function (data) {
        $('#tip_id').html(data);
    });

    tabla=$('#estado_data').dataTable({
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
            url: '../../controller/estado.php?op=listar',
            type : "post",
            dataType : "json",
            data : {sis_id:sis_id},
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

function editar(estoc_id){
    $('#mdltitulo').html('Editar Registro');

    $.post("../../controller/estado.php?op=mostrar", {estoc_id : estoc_id}, function (data) {
        data = JSON.parse(data);
        $('#estoc_id').val(data.estoc_id);

        $.post("../../controller/tipo.php?op=combo_select",{sis_id:sis_id,tip_id:data.tip_id}, function (data) {
            $('#tip_id').html(data);
        });

        $('#estoc_nom1').val(data.estoc_nom1);
        $('#estoc_nom2').val(data.estoc_nom2);
        $('#estoc_campo').val(data.estoc_campo);
    });

    $('#modalmantenimiento').modal('show');
}

function eliminar(estoc_id){
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
            $.post("../../controller/estado.php?op=eliminar",{estoc_id:estoc_id},function (data) {

            }); 

            $('#estado_data').DataTable().ajax.reload();	

            swal({
                title: "SISOR!!",
                text: "Registro Eliminado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
}

$(document).on("click","#btnnuevo", function(){
    $('#estoc_id').val('');
    $('#mdltitulo').html('Nuevo Registro');
    $('#estado_form')[0].reset();
    $('#modalmantenimiento').modal('show');
});


init();