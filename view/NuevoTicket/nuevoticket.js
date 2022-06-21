var usu_id =  $('#user_idx').val();
var rol_id =  $('#rol_idx').val();
var sis_id =  $('#sis_idx').val();

function init(){

    $("#ticket_form").on("submit",function(e){
        guardaryeditar(e);	
    });

}

$(document).ready(function() {
    $('#tick_descrip').summernote({
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

    $.post("../../controller/categoria.php?op=combo",{sis_id:sis_id},function(data, status){
        $('#cat_id').html(data);
    });

    $.post("../../controller/tipo.php?op=combo",{sis_id:sis_id},function(data, status){
        $('#tip_id').html(data);
    });

    $("#tip_id").change(function(){
        $("#tip_id option:selected").each(function () {
            tip_id = $(this).val();

            if (tip_id == 3){
                $.post("../../controller/categoria.php?op=combo_select", { tip_id: tip_id,cat_id : 86 }, function (data) {
                    $("#cat_id").html(data);
                });
            }else{
                $.post("../../controller/categoria.php?op=combo_x_tipo", { tip_id: tip_id }, function (data) {
                    $("#cat_id").html(data);
                });
            }
        });
    });

    $.post("../../controller/area.php?op=combo",function(data, status){
        $('#area_id').html(data);
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
            data:{ tick_id : 1 },
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

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#ticket_form")[0]);
    if ($('#tick_descrip').summernote('isEmpty') || $('#tick_titulo').val()=='' || $('#tick_prio').val()=='' || $('#suba_id').val()=='' || $('#tip_id').val()=='' || $('#cat_id').val()==''){
        swal("Advertencia!", "Campos Vacios", "warning");
    }else{
        var totalfiles = $('#fileElem').get(0).files.length;
        for (var index = 0; index < totalfiles; index++) {
            formData.append("files[]", $('#fileElem')[0].files[index]);
        }

        $.ajax({
            url: "../../controller/ticket.php?op=insert",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){

                data = JSON.parse(data);
                $('#tick_titulo').val('');
                $('#tick_descrip').summernote('reset');
                swal("Correcto!", "Ticket Generado : "+ data.tick_corre+" \n Sera redirigido al Home en unos segundos al dar en 'Aceptar'", "success");

                $.post("../../controller/email.php?op=ticket_abierto",{tick_id:data.tick_id},function(data, status){

                });

                swal({
                    title: "Correcto!",
                    text: "Ticket Generado : "+ data.tick_corre +" \n \n Sera redirigido al Home en unos segundos al dar en el boton 'Aceptar'",
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

init();