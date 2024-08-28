var tabla;
var usu_id =  $('#user_idx').val();
var rol_id =  $('#rol_idx').val();
var sis_id = $('#sis_idx').val();

function init(){
    $("#ticket_form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

$(document).ready(function(){

    $.post("../../controller/usuario.php?op=combo",{sis_id:sis_id}, function (data) {
        $('#usu_asig').html(data);
    });

    $.post("../../controller/tipo.php?op=combo",{sis_id:sis_id},function(data, status){
        $('#tip_id').html(data);
    });

    $.post("../../controller/area.php?op=combo",{sis_id:sis_id}, function (data) {
        $('#area_id').html(data);
    });

    $("#tip_id").change(function(){
        $("#tip_id option:selected").each(function () {
            tip_id = $(this).val();

            $.post("../../controller/estado.php?op=combotipo", { tip_id:tip_id }, function (data) {
                $("#estoc_id").html(data);
            });
        });
    });

    $('#divorden').show();
    $('#divestado').show();
    $('#divcrea').show();
    
    var tip_id = $('#tip_id').val();
    var area_id = $('#area_id').val();
    var tick_estado = $('#tick_estado').val();
    var usu_asig_est = $('#usu_asig_est').val();

    var tickoc_orden = $('#tickoc_orden').val();
    var estoc_id = $('#estoc_id').val();
    var fech_crea = $('#fech_crea').val();
    //filtro(tip_id,area_id,tick_estado,usu_asig_est,tickoc_orden,estoc_id,fech_crea)
});

function ver(tick_id){
    window.open('../../view/DetalleTicketoc/?ID='+ tick_id +'','_Blank');
}

function asignar(tick_id){
    $.post("../../controller/ticketoc.php?op=mostrar", {tickoc_id : tick_id}, function (data) {
        data = JSON.parse(data);
        $('#tickoc_id').val(data.tickoc_id);
        $('#usu_asig').val(data.usu_asig).trigger('change');
        /* Validacion de Estado de Ticket Antes de Asignar */
        if (data.tickoc_estado_texto=='Abierto'){
            $('#mdltitulo').html('Asignar Agente');
            $("#modalasignar").modal('show');
        }else{
            swal({
                title: "SISOR!",
                text: "Error OC Cerrado.",
                type: "warning",
                confirmButtonClass: "btn-warning"
            });
        }

    });
}

function filtro(tip_id,area_id,tick_estado,usu_asig_est,tickoc_orden,estoc_id,fech_crea){
    limpiartable();

    var tip_id = $('#tip_id').val();
    var area_id = $('#area_id').val();
    var tick_estado = $('#tick_estado').val();
    var usu_asig_est = $('#usu_asig_est').val();

    var tickoc_orden = $('#tickoc_orden').val();
    var estoc_id = $('#estoc_id').val();
    var fech_crea = $('#fech_crea').val();

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
            url: '../../controller/ticket.php?op=listar_filtro_oc',
            type : "post",
            dataType : "json",
            data:{tip_id:tip_id,area_id:area_id,tick_estado:tick_estado,usu_asig_est:usu_asig_est,sis_id:sis_id,tickoc_orden:tickoc_orden,estoc_id:estoc_id,fech_crea:fech_crea},
            error: function(e){
                console.log(e.responseText);
            }
        },
        "ordering": false,
        "bDestroy": true,
        "responsive": false,
        "scrollX": true,
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
}

$(document).on("click","#btntodo", function(){
    var tip_id = $('#tip_id').val('').trigger('change');
    var area_id = $('#area_id').val('').trigger('change');
    var tick_estado = $('#tick_estado').val('').trigger('change');
    var usu_asig_est = $('#usu_asig_est').val('').trigger('change');

    var tickoc_orden = $('#tickoc_orden').val('');
    var estoc_id = $('#estoc_id').val('').trigger('change');;
    var fech_crea = $('#fech_crea').val('');

    filtro(tip_id,area_id,tick_estado,usu_asig_est,tickoc_orden,estoc_id,fech_crea);
});

function limpiartable(){
    $('#table').html(
        "<table id='ticket_data' class='table table-bordered table-striped table-vcenter js-dataTable-full'>"+
                "<thead>"+
                    "<tr>"+
                        "<th style='width: 5%;'>Nro</th>"+
                        /* "<th style='width: 5%;'>Orden</th>"+ */
                        "<th style='width: 5%;'>Orden Asignada</th>"+
                        "<th style='width: 15%;'>Tipo</th>"+
                        "<th style='width: 15%;'>Nombre Solicitante</th>"+
                        "<th style='width: 15%;'>Area</th>"+
                        "<th style='width: 15%;'>Sub Area</th>"+
                        "<th class='d-none d-sm-table-cell' style='width: 40%;'>Titulo</th>"+
                        "<th class='d-none d-sm-table-cell' style='width: 40%;'>Est.Orden</th>"+
                        "<th style='width: 15%;'>Entrega</th>"+
                        "<th style='width: 15%;'>Tiempo Esperado</th>"+
                        "<th style='width: 15%;'>Cotizacion o Regularización</th>"+
                        /* "<th style='width: 15%;'>Valor estimado</th>"+ */
                        "<th style='width: 15%;'>Planta</th>"+
                        "<th class='d-none d-sm-table-cell' style='width: 5%;'>Est.</th>"+
                        "<th class='d-none d-sm-table-cell' style='width: 20%;'>Fecha Creación</th>"+
                        "<th class='d-none d-sm-table-cell' style='width: 25%;'>Fecha Cierre</th>"+
                        "<th class='d-none d-sm-table-cell' style='width: 25%;'>Agente Asignado</th>"+
                        "<th class='text-center' style='width: 5%;'>Ver</th>"+
                    "</tr>"+
                "</thead>"+
                "<tbody>"+

                "</tbody>"+
            "</table>"
    );
}

$(document).on("click","#btnfiltrar", function(){
    limpiartable();

    var tip_id = $('#tip_id').val();
    var area_id = $('#area_id').val();
    var tick_estado = $('#tick_estado').val();
    var usu_asig_est = $('#usu_asig_est').val();

    var tickoc_orden = $('#tickoc_orden').val();
    var estoc_id = $('#estoc_id').val();
    var fech_crea = $('#fech_crea').val();

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
            url: '../../controller/ticket.php?op=listar_filtro_oc',
            type : "post",
            dataType : "json",
            data:{tip_id:tip_id,area_id:area_id,tick_estado:tick_estado,usu_asig_est:usu_asig_est,sis_id:sis_id,tickoc_orden:tickoc_orden,estoc_id:estoc_id,fech_crea:fech_crea},
            error: function(e){
                console.log(e.responseText);
            }
        },
        "ordering": false,
        "bDestroy": true,
        "responsive": false,
        "scrollX": true,
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

function guardaryeditar(e){
    e.preventDefault();
	var formData = new FormData($("#ticket_form")[0]);
    $.ajax({
        url: "../../controller/ticketoc.php?op=asignar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            $("#modalasignar").modal('hide');

            var tickoc_id = $('#tickoc_id').val();
            $.post("../../controller/email.php?op=ticket_asignaroc", {tickoc_id : tickoc_id}, function (data) {

                swal({
                    title: "SISOR!",
                    text: "Agente Asignado! se enviara un correo de aviso al Agente. Completado.",
                    type: "success",
                    confirmButtonClass: "btn-success"
                });
            });

            var tip_id = $('#tip_id').val('').trigger('change');
            var area_id = $('#area_id').val('').trigger('change');
            var tick_estado = $('#tick_estado').val('').trigger('change');
            var usu_asig_est = $('#usu_asig_est').val('').trigger('change');
        
            var tickoc_orden = $('#tickoc_orden').val('');
            var estoc_id = $('#estoc_id').val('').trigger('change');;
            var fech_crea = $('#fech_crea').val('');
        
            filtro(tip_id,area_id,tick_estado,usu_asig_est,tickoc_orden,estoc_id,fech_crea);
        }
    });

}

init();