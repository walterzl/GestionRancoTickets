var usu_id =  $('#user_idx').val();
var rol_id =  $('#rol_idx').val();
var grupo_id =  $('#grupo_idx').val();
var sis_id = $('#sis_idx').val();

function init(){

}

$(document).ready(function(){
    var tick_id = getUrlParameter('ID');

    listardetalle(tick_id);


    $('#tickd_descrip').summernote({
        height: 400,
        lang: "es-ES",
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
        ],
        
    });

    $('#tickd_descripusu').summernote({
        height: 400,
        lang: "es-ES",
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });

    $("#tip_id").change(function(){
        $("#tip_id option:selected").each(function () {
            tip_id = $(this).val();

            $.post("../../controller/categoria.php?op=combo_x_tipo", { tip_id:tip_id }, function (data) {
                $("#cat_id").html(data);
            });
        });
    });

    $("#cat_id").change(function(){
        $("#cat_id option:selected").each(function () {
            cat_id = $(this).val();

            if (cat_id=='86'){
                $('#btncerrarticket').prop('disabled', true);
            }else{
                $('#btncerrarticket').prop('disabled', false);
            }
        });
    });

    $('#tickd_descripusu').summernote('disable');

    tabla=$('#documentos_data').dataTable({
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
            data : {tick_id:tick_id},
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

    /* Si el rol es igual 1 entonces ocultar el combo de opcion ticket */
    if (rol_id==1 || rol_id==4 || rol_id==7 ){
        $('#lblopcion').hide();

        $('#lbltipid').hide();
        $('#lblcatid').hide();

        $('#lbltipnom').show();
        $('#lblcatnom').show();
    }else{
        $('#lblopcion').show();

        $('#lbltipid').show();
        $('#lblcatid').show();

        $('#lbltipnom').hide();
        $('#lblcatnom').hide();
    }

});

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

$(document).on("click","#btnenviar", function(){

    var tick_id = getUrlParameter('ID');
    var usu_id = $('#user_idx').val();
    var tickd_descrip = $('#tickd_descrip').val();
    var tick_opc = $('#tick_opc').val();

    var tip_id = $('#tip_id').val();
    var cat_id = $('#cat_id').val();

    var formData = new FormData();
    formData.append('tick_id', tick_id);
    formData.append('usu_id', usu_id);
    formData.append('tickd_descrip', tickd_descrip);
    var totalfiles = $('#fileElem').get(0).files.length;
    for (var index = 0; index < totalfiles; index++) {
        formData.append("files[]", $('#fileElem')[0].files[index]);
    }

    if ($('#tickd_descrip').summernote('isEmpty')){
        swal("Advertencia!", "Falta Descripción", "warning");
    }else{
        /* Validando Roles */
        if (rol_id==1 || rol_id==4 || rol_id==7){
            /* Si es Rol 1 entonces se guarda sin problemas */

            $.ajax({
                url: "../../controller/ticket.php?op=insertdetalle",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    listardetalle(tick_id);
                    $('#tickd_descrip').summernote('reset');

                    $.post("../../controller/email.php?op=ticket_detalle", {tick_id:tick_id}, function (data) {

                    });

                    $('#fileElem').val('');

                    swal("Correcto!", "Registrado Correctamente", "success");
                }
            });

            $.post("../../controller/ticket.php?op=insertdetalle", { tick_id:tick_id,usu_id:usu_id,tickd_descrip:tickd_descrip}, function (data) {

            });
        }else{
            /* En caso Contrario validar que se llene el combo opcion */
            if ($('#tick_opc').val()==0){
                /* Mensaje de Error */
                swal("Advertencia!", "Seleccione Opcion de Ticket", "warning");
            }else{
                $.post("../../controller/ticket.php?op=update_opcion", { tick_id:tick_id,tick_opc:tick_opc}, function (data) {

                });

                $.post("../../controller/ticket.php?op=update_tipo_categoria", { tick_id:tick_id,tip_id:tip_id,cat_id:cat_id}, function (data) {

                });

                $.ajax({
                    url: "../../controller/ticket.php?op=insertdetalle",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                        listardetalle(tick_id);
                        $('#tickd_descrip').summernote('reset');

                        $.post("../../controller/email.php?op=ticket_detalle", {tick_id:tick_id}, function (data) {

                        });

                        $('#fileElem').val('');

                        swal("Correcto!", "Registrado Correctamente", "success");
                    }
                });

            }
        }

    }
});

$(document).on("click","#btncerrarticket", function(){
    if (rol_id==1 || rol_id==4){
        /* Validacion de Cerrar Ticket si aun no esta asignado */
        if ($('#usu_asig').val()||null){ /* de '' -> null */
            swal({
                title: "SISOR!",
                text: "Esta seguro de Cerrar el Ticket?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-warning",
                confirmButtonText: "Si",
                cancelButtonText: "No",
                closeOnConfirm: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    var tick_id = getUrlParameter('ID');
                    var usu_id = $('#user_idx').val();
                    $.post("../../controller/ticket.php?op=update", { tick_id : tick_id,usu_id : usu_id }, function (data) {

                    });

                    $.post("../../controller/email.php?op=ticket_cerrado",{tick_id:tick_id},function(data, status){

                    });

                    listardetalle(tick_id);

                    swal({
                        title: "SISOR!",
                        text: "Ticket Cerrado correctamente.",
                        type: "success",
                        confirmButtonClass: "btn-success"
                    });
                }
            });
        }else{
            /* mensaje de envio correcto*/
            swal({
                title: "SISOR!",
                text: "Error no se puede cerrar Ticket, Se debe asignar un Agente primero.",
                type: "warning",
                confirmButtonClass: "btn-warning"
            });
        }
    }else{
        if ($('#tick_opc').val()||null){
            if ($('#usu_asig').val()||null){ /* de '' -> null */
                swal({
                    title: "SISOR!",
                    text: "Esta seguro de Cerrar el Ticket?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-warning",
                    confirmButtonText: "Si",
                    cancelButtonText: "No",
                    closeOnConfirm: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        var tick_id = getUrlParameter('ID');
                        var usu_id = $('#user_idx').val();
                        $.post("../../controller/ticket.php?op=update", { tick_id : tick_id,usu_id : usu_id }, function (data) {

                        });

                        $.post("../../controller/email.php?op=ticket_cerrado",{tick_id:tick_id},function(data, status){

                        });

                        listardetalle(tick_id);

                        swal({
                            title: "SISOR!",
                            text: "Ticket Cerrado correctamente.",
                            type: "success",
                            confirmButtonClass: "btn-success"
                        });
                    }
                });
            }else{
                /* mensaje de envio correcto*/
                swal({
                    title: "SISOR!",
                    text: "Error no se puede cerrar Ticket, Se debe asignar un Agente primero.",
                    type: "warning",
                    confirmButtonClass: "btn-warning"
                });
            }
        }else{
            /* mensaje de envio correcto*/
            swal({
                title: "SISOR!",
                text: "Error Seleccione opcion antes de cerrar el ticket.",
                type: "warning",
                confirmButtonClass: "btn-warning"
            });
        }
    }
});

function listardetalle(tick_id){

    $.post("../../controller/ticket.php?op=mostrar", { tick_id : tick_id }, function (data) {
        data = JSON.parse(data);
        if (data.tick_id==0){
            window.open('../../404.php','_self');
        }else{
            if (data.sis_id==sis_id){
                $('#lblestado').html(data.tick_estado);
                $('#lblnomusuario').html('Ticket Creador por:  '+data.usu_nom +' '+data.usu_ape);
                $('#lblfechcrea').html('Fecha de apertura:  '+data.fech_crea);

                $('#lblnomidticket').html("Detalle Ticket - "+data.tick_corre);

                $.post("../../controller/tipo.php?op=combo_select", { sis_id: sis_id,tip_id:data.tip_id}, function (data) {
                    $("#tip_id").html(data);
                });

                $('#tip_nom').val(data.tip_nom);
                $('#cat_nom').val(data.cat_nom);
                $.post("../../controller/categoria.php?op=combo_select", { tip_id: data.tip_id,cat_id:data.cat_id }, function (data) {
                    $("#cat_id").html(data);
                });

                if (data.cat_id=='86'){
                    $('#btncerrarticket').prop('disabled', true);
                }else{
                    $('#btncerrarticket').prop('disabled', false);
                }

                $('#tick_titulo').val(data.tick_titulo);
                $('#tickd_descripusu').summernote ('code',data.tick_descrip);
                $('#area_nom').val(data.area_nom);
                $('#suba_nom').val(data.suba_nom);
                $('#tick_prio').val(data.tick_prio);

                $('#usu_asig').val(data.usu_asig);

                $('#tick_opc').val(data.tick_opc).trigger('change');

                if (data.tick_estado_texto == "Cerrado"){
                    $('#pnldetalle').hide();
                }
            }else{
                window.open('../../404.php','_self');
            }

        }
    });

    $.post("../../controller/ticket.php?op=listardetalle", { tick_id : tick_id }, function (data) {
        $('#lbldetalle').html(data);
    });
}

init();
