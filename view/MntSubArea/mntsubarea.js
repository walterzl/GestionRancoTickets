var tabla;
var usu_id =  $('#user_idx').val();
var rol_id =  $('#rol_idx').val();
var sis_id =  $('#sis_idx').val();

function init(){
    $("#subarea_form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

function guardaryeditar(e){
    e.preventDefault();
	var formData = new FormData($("#subarea_form")[0]);
    $.ajax({
        url: "../../controller/subarea.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            console.log(datos);
            $('#subarea_form')[0].reset();
            $("#modalmantenimiento").modal('hide');
            $('#subarea_data').DataTable().ajax.reload();

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

    $.post("../../controller/area.php?op=combo",{sis_id:sis_id}, function (data) {
        $('#area_id').html(data);
    });

    tabla=$('#subarea_data').dataTable({
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
            url: '../../controller/subarea.php?op=listar',
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

function editar(suba_id){
    $('#mdltitulo').html('Editar Registro');

    $.post("../../controller/subarea.php?op=mostrar",{suba_id : suba_id},function (data) {
        data = JSON.parse(data);
        $('#suba_id').val(data.suba_id);

        $.post("../../controller/area.php?op=combo_select",{sis_id:sis_id,area_id:data.area_id}, function (data) {
            $('#area_id').html(data);
        });

        $('#area_id').val(data.area_id);
        $('#suba_nom').val(data.suba_nom);
    });

    $('#modalmantenimiento').modal('show');
}

function eliminar(suba_id){
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
            $.post("../../controller/subarea.php?op=eliminar",{suba_id:suba_id},function (data) {

            }); 

            $('#subarea_data').DataTable().ajax.reload();	

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
    $.post("../../controller/area.php?op=combo",{sis_id:sis_id}, function (data) {
        $('#area_id').html(data);
    });

    $('#suba_id').val('');
    $('#mdltitulo').html('Nuevo Registro');
    $('#subarea_form')[0].reset();
    $('#modalmantenimiento').modal('show');
});

init();