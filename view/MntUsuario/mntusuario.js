var tabla;
var usu_id =  $('#user_idx').val();
var rol_id =  $('#rol_idx').val();
var sis_id =  $('#sis_idx').val();

function init(){
    $("#usuario_form").on("submit",function(e){
        guardaryeditar(e);	
    });

}

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#usuario_form")[0]);
    $.ajax({
        url: "../../controller/usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            console.log(datos);
            if (datos="OK"){
                $("#modalmantenimiento").modal('hide');
                $('#usuario_data').DataTable().ajax.reload();

                swal({
                    title: "SISOR!!",
                    text: "Completado.",
                    type: "success",
                    confirmButtonClass: "btn-success"
                });

            }else if (datos=="EXISTE"){
                swal({
                    title: "SISOR!!",
                    text: "Correo ya Existe.",
                    type: "error",
                    confirmButtonClass: "btn-danger"
                });
            }

        }
    });
}

$(document).ready(function(){

    $.post("../../controller/grupo.php?op=combo",{sis_id:sis_id}, function (data) {
        $('#grupo_id').html(data);
    });

    $.post("../../controller/area.php?op=combo",{sis_id:sis_id}, function (data) {
        $('#area_id').html(data);
    });
    $("#area_id").change(function(){
        $("#area_id option:selected").each(function () {
            area_id = $(this).val();

            $.post("../../controller/subarea.php?op=combo", { area_id: area_id }, function (data) {
                $("#suba_id").html(data);
            });
        });
    });

    $.post("../../controller/rol.php?op=combo",{sis_id:sis_id}, function (data) {
        $('#rol_id').html(data);
    });

    $("#rol_id").change(function(){
        $("#rol_id option:selected").each(function () {
            rol_id = $(this).val();

            if (rol_id==1 || 4){
                $("#grupo_id").val(4).trigger('change');;
            }else{
                $.post("../../controller/grupo.php?op=combo",{sis_id:sis_id}, function (data) {
                    $('#grupo_id').html(data);
                });
            }

        });
    });

    tabla=$('#usuario_data').dataTable({
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
            url: '../../controller/usuario.php?op=listar',
            type : "post",
            data : {sis_id : sis_id},
            dataType : "json",
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

function editar(usu_id){
    $('#mdltitulo').html('Editar Registro');
    $.post("../../controller/usuario.php?op=mostrar", {usu_id : usu_id}, function (data) {
        data = JSON.parse(data);
        $('#usu_id').val(data.usu_id);
        $('#usu_nom').val(data.usu_nom);
        $('#usu_ape').val(data.usu_ape);
        $('#usu_correo').val(data.usu_correo);
        $('#usu_pass').val(data.usu_pass);
        $('#rol_id').val(data.rol_id).trigger('change');

        $.post("../../controller/area.php?op=combo_select",{sis_id:sis_id,area_id:data.area_id}, function (data) {
            $('#area_id').html(data);
        });

        $.post("../../controller/subarea.php?op=combo_select",{area_id:data.area_id,suba_id:data.suba_id}, function (data) {
            $('#suba_id').html(data);
        });

        $.post("../../controller/grupo.php?op=combo_select",{sis_id:sis_id,grupo_id:data.grupo_id}, function (data) {
            $('#grupo_id').html(data);
        });

    });

    $('#modalmantenimiento').modal('show');
}

function eliminar(usu_id){
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
            $.post("../../controller/usuario.php?op=eliminar", {usu_id : usu_id}, function (data) {

            }); 

            $('#usuario_data').DataTable().ajax.reload();	

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
    $.post("../../controller/grupo.php?op=combo",{sis_id:sis_id}, function (data) {
        $('#grupo_id').html(data);
    });

    $.post("../../controller/area.php?op=combo",{sis_id:sis_id}, function (data) {
        $('#area_id').html(data);
    });

    $.post("../../controller/rol.php?op=combo",{sis_id:sis_id}, function (data) {
        $('#rol_id').html(data);
    });

    $('#usu_id').val('');

    $('#mdltitulo').html('Nuevo Registro');
    $('#usuario_form')[0].reset();
    $('#modalmantenimiento').modal('show');
});

init();