var usu_id =  $('#user_idx').val();
var rol_id =  $('#rol_idx').val();
var grupo_id =  $('#grupo_idx').val();
var sis_id = $('#sis_idx').val();

function init(){

}

$(document).ready(function(){
    var tickoc_id = getUrlParameter('ID');

    listardetalle(tickoc_id);

    $('#tickocd_descrip').summernote({
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

    $('#tickocd_descripusu').summernote({
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

            $.post("../../controller/estado.php?op=combotipo", { tip_id:tip_id }, function (data) {
                $("#estoc_id").html(data);
            });
        });
    });

    $("#estoc_id").change(function(){
        $("#estoc_id option:selected").each(function () {
            estoc_id = $(this).val();

            $.post("../../controller/estado.php?op=mostrar", { estoc_id:estoc_id }, function (data) {
                data = JSON.parse(data);
                if (data.estoc_nom1=='Cerrado'){
                    $('#tickoc_orden').attr('readonly', true);
                    $("#tickoc_check1").attr("disabled", true);
                    $("#tickoc_check2").attr("disabled", true);
                }else{
                    $('#tickoc_orden').attr('readonly', false);
                    $("#tickoc_check1").attr("disabled", false);
                    $("#tickoc_check2").attr("disabled", false);
                }
            });
        });
    });

    $('#tickocd_descripusu').summernote('disable');

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
            url: '../../controller/documentooc.php?op=listar',
            type : "post",
            data : {tickoc_id:tickoc_id},
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

    /* Si rol es igual a 7 entonces sera de solo lectura */
    if (rol_id==1){
        $("#tickoc_orden").attr("readonly","readonly");
        $("#estoc_id").attr("readonly","readonly");
    }else if(rol_id==7){
        $("#tickoc_orden").attr("readonly","readonly");
        $("#estoc_id").attr("disabled", true);
        $("#tickoc_geren").attr("disabled", true);
        $("#tickoc_geren2").attr("disabled", true);
    }

});

$(document).on("click","#btnenviar", function(){

    var tickoc_id = getUrlParameter('ID');
    var usu_id = $('#user_idx').val();
    var tickocd_descrip = $('#tickocd_descrip').val();
    var tick_opc = $('#tick_opc').val();
    var tickoc_orden = $('#tickoc_orden').val();

    if ($('#tickoc_geren').val() == ''){
        var tickoc_geren = 'NO';
    }else{
        var tickoc_geren = $('#tickoc_geren').val();
    }

    if ($('#tickoc_geren2').val() == ''){
        var tickoc_geren2 = 'NO';
    }else{
        var tickoc_geren2 = $('#tickoc_geren2').val();
    }

    var tip_id = $('#tip_id').val();
    var cat_id = $('#cat_id').val();

    if ($("#tickoc_check1").prop("checked") == true){
        var tickoc_check1 = "S";
    }else{
        var tickoc_check1 = "N";
    }

    if ($("#tickoc_check2").prop("checked") == true){
        var tickoc_check2 = "S";
    }else{
        var tickoc_check2 = "N";
    }

    var formData = new FormData();
    formData.append('tickoc_id', tickoc_id);
    formData.append('usu_id', usu_id);
    formData.append('tickocd_descrip', tickocd_descrip);
    formData.append('tickoc_orden', tickoc_orden);
    formData.append('tickoc_check1', tickoc_check1);
    formData.append('tickoc_check2', tickoc_check2);
    formData.append('tickoc_geren', tickoc_geren);
    formData.append('tickoc_geren2', tickoc_geren2);
    var totalfiles = $('#fileElem').get(0).files.length;
    for (var index = 0; index < totalfiles; index++) {
        formData.append("files[]", $('#fileElem')[0].files[index]);
    }

    if ($('#tickocd_descrip').summernote('isEmpty')){
        swal("Advertencia!", "Falta Descripción", "warning");
    }else{
        /* Validando Roles */
        if (rol_id==1 || rol_id==4 || rol_id==7){
            /* Si es Rol 1 entonces se guarda sin problemas */

            $.ajax({
                url: "../../controller/ticketoc.php?op=insertdetalle",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    console.log(data);
                    listardetalle(tickoc_id);
                    $('#tickocd_descrip').summernote('reset');
                    swal("Correcto!", "Registrado Correctamente", "success");
                }
            });

        }else{
            /* TODO: En caso Contrario validar que se llene el combo opcion */
            if ($('#tick_opc').val()==0){
                /* TODO: Mensaje de Error */
                swal("Advertencia!", "Seleccione Opcion de Ticket", "warning");
            }else{
                $.post("../../controller/ticketoc.php?op=update_opcion", { tickoc_id:tickoc_id,tick_opc:tick_opc}, function (data) {

                });

                $.post("../../controller/ticketoc.php?op=update_tipo_categoria", { tickoc_id:tickoc_id,tip_id:tip_id,cat_id:cat_id}, function (data) {

                });

                $.ajax({
                    url: "../../controller/ticketoc.php?op=insertdetalle",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                        console.log(data);
                        listardetalle(tickoc_id);
                        $('#tickocd_descrip').summernote('reset');

                        /* TODO: Alerta de DetalleOC */
                        $.post("../../controller/email.php?op=ticket_detalleoc", {tickoc_id:tickoc_id}, function (data) {

                        });

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
                text: "Esta seguro de Cerrar el OC?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-warning",
                confirmButtonText: "Si",
                cancelButtonText: "No",
                closeOnConfirm: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    var tickoc_id = getUrlParameter('ID');
                    var usu_id = $('#user_idx').val();
                    $.post("../../controller/ticketoc.php?op=update", { tickoc_id : tickoc_id,usu_id : usu_id }, function (data) {
                        console.log(data);
                    });

                    $.post("../../controller/email.php?op=ticket_cerradooc",{tickoc_id:tickoc_id},function(data, status){

                    });

                    listardetalle(tickoc_id);

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
        if ($('#usu_asig').val()||null){ /* de '' -> null */
            swal({
                title: "SISOR!",
                text: "Esta seguro de Cerrar el OC?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-warning",
                confirmButtonText: "Si",
                cancelButtonText: "No",
                closeOnConfirm: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    var tickoc_id = getUrlParameter('ID');
                    var usu_id = $('#user_idx').val();
                    $.post("../../controller/ticketoc.php?op=update", { tickoc_id : tickoc_id,usu_id : usu_id }, function (data) {
                     
                    });

                    $.post("../../controller/email.php?op=ticket_cerradooc",{tickoc_id:tickoc_id},function(data, status){

                    });

                    listardetalle(tickoc_id);

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
    }
});

function listardetalle(tickoc_id){

    $.post("../../controller/ticketoc.php?op=mostrar", { tickoc_id : tickoc_id }, function (data) {
        data = JSON.parse(data);
        if (data.tickoc_id==0){
            window.open('../../404.php','_self');
        }else{
            if (data.sis_id==$('#sis_idx').val()){
                $('#lblestado').html(data.tickoc_estado);
                $('#lblnomusuario').html('Ticket Creador por:  '+data.usu_nom +' '+data.usu_ape);
                $('#lblfechcrea').html('Fecha de apertura:  '+data.fech_crea);

                $('#lblnomidticket').html("Detalle OC - "+data.tickoc_corre);

                $.post("../../controller/tipo.php?op=combo_select", { sis_id: sis_id,tip_id:data.tip_id}, function (data) {
                    $("#tip_id").html(data);
                });

                $.post("../../controller/estado.php?op=combo_select", { tip_id:data.tip_id,estoc_id:data.estoc_id }, function (data) {
                    $("#estoc_id").html(data);
                });

                $('#tip_nom').val(data.tip_nom);
                $('#cat_nom').val(data.cat_nom);

                $.post("../../controller/categoria.php?op=combo_select", { tip_id: data.tip_id,cat_id:data.cat_id }, function (data) {
                    $("#cat_id").html(data);
                });

                $('#tickoc_titulo').val(data.tickoc_titulo);
                $('#tickocd_descripusu').summernote ('code',data.tickoc_descrip);
                $('#area_nom').val(data.area_nom);
                $('#suba_nom').val(data.suba_nom);

                $('#usu_asig').val(data.usu_asig);
                $('#tickoc_coti_cerra').val(data.tickoc_coti_cerra);

                $('#ent_nom').val(data.ent_nom);
                $('#dura_nom').val(data.dura_nom);
                $('#cntcon_nom').val(data.cntcon_nom +' '+data.cntcon_nom2);

                $('#tickoc_opc').val(data.tickoc_opc).trigger('change');

                //esconder Elementos si es cat=cotizacion

                if (data.cat_id=='80'){
                    document.getElementById('Ocultar_para_Cotizacion').style.display = 'none';
                    document.getElementById('Ocultar_para_Cotizacion2').style.display = 'none';
                }else{
                    document.getElementById('Ocultar_para_Cotizacion').style.display = 'block';
                    document.getElementById('Ocultar_para_Cotizacion2').style.display = 'block';
                }

                if (data.tickoc_estado_texto == "Cerrado"){
                    $('#pnldetalle').hide();
                    $('#tickoc_orden').attr('readonly', true);
                    $("#tickoc_check1").attr("disabled", true);
                    $("#tickoc_check2").attr("disabled", true);

                    $("#btnagregar").prop('disabled', true);
                    $("#estoc_id").attr("disabled", true);
                }

                if (data.tickoc_check1 == "N"){
                    $("#tickoc_check1").prop("checked", false);
                }else{
                    $("#tickoc_check1").prop("checked", true);
                }

                if (data.tickoc_check2 == "N"){
                    $("#tickoc_check2").prop("checked", false);
                }else{
                    $("#tickoc_check2").prop("checked", true);
                }

                $('#tickoc_geren').val(data.tickoc_geren).trigger('change');
                $('#tickoc_geren2').val(data.tickoc_geren2).trigger('change');

                $('#tickoc_orden').val(data.tickoc_orden);
            }else{
                window.open('../../404.php','_self');
            }
        }
    });

    $.post("../../controller/ticketoc.php?op=listardetalle", { tickoc_id : tickoc_id }, function (data) {
        $('#lbldetalle').html(data);
    });

    $.post("../../controller/ticketoc.php?op=listarestado", { tickoc_id : tickoc_id }, function (data) {
        $('#lblestadosoc').html(data);
    });

}

$(document).on("click","#btnagregar", function(){
    var tickoc_id = getUrlParameter('ID');
    var estoc_id = $('#estoc_id').val();
    var usu_id = $('#user_idx').val();
    $.post("../../controller/ticketoc.php?op=agregar", { tickoc_id:tickoc_id,estoc_id:estoc_id,usu_id:usu_id}, function (data) {
        listardetalle(tickoc_id);
        swal("Correcto!", "Registrado Correctamente", "success");
    });
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

init();
