var usu_id =  $('#user_idx').val();
var rol_id =  $('#rol_idx').val();
var grupo_id =  $('#grupo_idx').val();
var sis_id = $('#sis_idx').val()

console.log("usu_id:", usu_id);
console.log("sis_id:", sis_id);

var tabla = $('#flujo_data').DataTable({
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
    "ajax": {
        url: '../../controller/flujo.php?op=listar',
        type: "post",
        data: {
            usu_id: usu_id,
            sis_id: sis_id
        },
        dataType: "json",
        error: function(e) {
            console.log(e.responseText);
        }
    },
    "columns": [
        { "data": "id" },
        { "data": "itemCompra" },
        { "data": "nombreSolicitante" },
        { "data": "correoSolicitante" },
        { "data": "nombreJefatura" },
        { "data": "correoJefatura" },
        { "data": "FechaRespuesta" },
        { "data": "EstadoRespuesta" }
    ],
    "bDestroy": true,
    "responsive": true,
    "bInfo": true,
    "iDisplayLength": 10,
    "autoWidth": false,
    "language": {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sSearch": "Buscar:",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        }
    }
});

function refreshDataTables() {
    $('#flujo_data').DataTable().ajax.reload();
}




