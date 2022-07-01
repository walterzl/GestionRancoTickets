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
            url: '../../controller/ticket.php?op=listar_x_asig',
            type : "post",
            dataType : "json",
            data:{ usu_asig : usu_id },
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

function ver(tick_id){
    if (sis_id==3){
        window.open('../../view/DetalleTicketoc/?ID='+ tick_id +'','_Blank');
    }else{
        window.open('../../view/DetalleTicket/?ID='+ tick_id +'','_Blank');
    }
}


init();