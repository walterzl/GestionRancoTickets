var usu_id =  $('#user_idx').val();
var rol_id =  $('#rol_idx').val();
var sis_id =  $('#sis_idx').val();

function init(){

    $("#ticket_form").on("submit",function(e){
        guardaryeditar(e);	
    });

}

$(document).ready(function() {

    $('#btnseleccionarcoti').hide();

    $('#tickoc_descrip').summernote({
        height: 150,
        lang: "es-ES",
        popover: {
            image: [],
            link: [],
            air: []
        },
        callbacks: {
            onImageUpload: function(image) {
                console.log("Image detect...");
                myimagetreat(image[0]);
            },
            onPaste: function (e) {
                console.log("Text detect...");
            }
        },
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });

    $('#lblmendura').hide();

    $("#ent_id").select2({disabled: true});

    $("#dura_id").select2({disabled: true});

    var area_id = $("#area_idx").val();
    var suba_id = $("#suba_idx").val();
    $.post("../../controller/subarea.php?op=combo_select", { area_id: area_id,suba_id:suba_id }, function (data) {
        $("#suba_id").html(data);
    });

    $.post("../../controller/area.php?op=combo_select",{sis_id:sis_id,area_id:area_id},function(data, status){
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

    $.post("../../controller/tipo.php?op=combo",{sis_id:sis_id},function(data, status){
        $('#tip_id').html(data);
    });

    $.post("../../controller/plancontable.php?op=combo",{sis_id:sis_id},function(data, status){
        $('#cntcon_id').html(data);
    });

    $.post("../../controller/condicionpago.php?op=combo",{sis_id:sis_id},function(data, status){
        $('#condp_id').html(data);
    });

    $("#tip_id").change(function(){
        $("#tip_id option:selected").each(function () {
            tip_id = $(this).val();

            $.post("../../controller/categoria.php?op=combo_x_tipo", { tip_id: tip_id }, function (data) {
                $("#cat_id").html(data);
            });

            if (tip_id == 16){//Si tipo es Insumo
                $("#ent_id").select2({disabled: false});
                $("#dura_id").select2({disabled: true});

                $('#btnseleccionarcoti').show();

                $('#correlativo').val();
                $('#tickoc_coti_cerra').val();

                $.post("../../controller/entrega.php?op=combo",{sis_id:sis_id},function(data, status){
                    $('#ent_id').html(data);
                });
            }else if (tip_id == 17){//Si tipo es Servicios
                $("#ent_id").select2({disabled: true});
                $("#dura_id").select2({disabled: false});

                $('#btnseleccionarcoti').show();

                $('#correlativo').val();
                $('#tickoc_coti_cerra').val();

                $.post("../../controller/duracion.php?op=combo",{sis_id:sis_id},function(data, status){
                    $('#dura_id').html(data);
                });
            }else{
                $("#ent_id").select2({disabled: true});
                $("#dura_id").select2({disabled: true});

                $('#btnseleccionarcoti').hide();

                $('#correlativo').val();
                $('#tickoc_coti_cerra').val();
            }

        });
    });

    /* Ocultar Mensaje para Duracion segun info */
    $("#dura_id").change(function(){
        $("#dura_id option:selected").each(function () {
            dura_id = $(this).val();

            if (dura_id == 3){
                $('#lblmendura').show();
            }else{
                $('#lblmendura').hide();
            }
        });
    });

    tabla=$('#documento_data').dataTable({
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
            url: '../../controller/documento.php?op=listar',
            type : "post",
            dataType : "json",
            data:{ tickoc_id : 1 },
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

    tabla=$('#ticket_data').dataTable({
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
            url: '../../controller/ticketoc.php?op=listar_cotizacion_cerrada',
            type : "post",
            dataType : "json",
            data:{ usu_id : usu_id },
            error: function(e){
                console.log(e.responseText);
            }
        },
        "ordering": false,
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 4,
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

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#ticket_form")[0]);
    if ($('#tickoc_descrip').summernote('isEmpty')  || $('#tickoc_titulo').val()=='' || $('#suba_id').val()=='' || $('#tip_id').val()=='' || $('#cat_id').val()==''){
        swal("Advertencia!", "Campos Vacios", "warning");
    }else{
        var totalfiles = $('#fileElem').get(0).files.length;
        for (var index = 0; index < totalfiles; index++) {
            formData.append("files[]", $('#fileElem')[0].files[index]);
        }

        $.ajax({
            url: "../../controller/ticketoc.php?op=insert",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){
                console.log(data);
                data = JSON.parse(data);
                $('#tickoc_titulo').val('');
                $('#tickoc_descrip').summernote('reset');
                swal("Correcto!", "OC Generado : "+ data.tickoc_corre+" \n Sera redirigido al Home en unos segundos al dar en 'Aceptar'", "success");

                $.post("../../controller/ticketoc.php?op=insertotro",{tickoc_id:data.tickoc_id},function(data, status){
                    console.log(data);
                });

                $.post("../../controller/email.php?op=ticket_abiertooc",{tickoc_id:data.tickoc_id},function(data, status){

                });

                swal({
                    title: "Correcto!",
                    text: "OC Generado : "+ data.tickoc_corre +" \n \n Sera redirigido al Home en unos segundos al dar en el boton 'Aceptar'",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Aceptar",
                    closeOnConfirm: false,
                },
                function(isConfirm) {
                    if (isConfirm) {
                        window.open('../home/','_self');
                    }
                });
            }
        });

    }
}

function eliminar(doc_id){
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
            $.post("../../controller/documento.php?op=eliminar",{doc_id:doc_id},function (data) {

            });

            $('#documento_data').DataTable().ajax.reload();	

            swal({
                title: "SISOR!",
                text: "Registro Eliminado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
}

function seleccionar(tickoc_id){
    $.post("../../controller/ticketoc.php?op=mostrar", { tickoc_id : tickoc_id }, function (data) {
        data = JSON.parse(data);
        $('#tickoc_coti_cerra').val(data.tickoc_id);
        $('#correlativo').val(data.tickoc_corre);
    });

    $('#modalmantenimiento').modal('hide');
}

$(document).on("click","#btnseleccionarcoti", function(){
    $('#modalmantenimiento').modal('show');
});

init();