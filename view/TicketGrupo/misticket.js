var tabla;
var usu_id =  $('#user_idx').val();
var rol_id =  $('#rol_idx').val();
var grupo_id =  $('#grupo_idx').val();
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
            url: '../../controller/ticket.php?op=listar_x_grupo',
            type : "post",
            dataType : "json",
            data:{ grupo_id : grupo_id },
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

function asignar(tick_id){
    $.post("../../controller/ticket.php?op=mostrar", {tick_id : tick_id}, function (data) {
        data = JSON.parse(data);
        $('#tick_id').val(data.tick_id);
        $('#usu_asig').val(data.usu_asig).trigger('change');
        /* Validacion de Estado de Ticket Antes de Asignar */
        if (data.tick_estado_texto=='Abierto'){
            $('#mdltitulo').html('Asignar Agente');
            $("#modalasignar").modal('show');
        }else{
            swal({
                title: "SISOR!",
                text: "Error Ticket Cerrado.",
                type: "warning",
                confirmButtonClass: "btn-warning"
            });
        }

    });

}

function guardaryeditar(e){
    e.preventDefault();
	var formData = new FormData($("#ticket_form")[0]);
    $.ajax({
        url: "../../controller/ticket.php?op=asignar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){


            var tick_id = $('#tick_id').val();

            $("#modalasignar").modal('hide');
            $('#ticket_data').DataTable().ajax.reload();

            $.post("../../controller/email.php?op=ticket_asignar", {tick_id : tick_id}, function (data) {
                swal({
                    title: "SISOR!",
                    text: "Completado.",
                    type: "success",
                    confirmButtonClass: "btn-success"
                });
            });

        }
    });
}

function ver(tick_id){
    if (sis_id==3){
        window.open('../../view/DetalleTicketoc/?ID='+ tick_id +'','_Blank');
    }else{
        window.open('../../view/DetalleTicket/?ID='+ tick_id +'','_Blank');
    }
}


init();