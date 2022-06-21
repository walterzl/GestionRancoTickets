var usu_id =  $('#user_idx').val();
var rol_id =  $('#rol_idx').val();
var grupo_id =  $('#grupo_idx').val();
var sis_id = $('#sis_idx').val();

function init(){

}

$(document).ready(function(){
    var usu_id = $('#user_idx').val();

    if ( $('#rol_idx').val() == 1 || $('#rol_idx').val() == 4 || $('#rol_idx').val() == 7 ){ //valida los contadores del home dependiendo del rol
        $.post("../../controller/usuario.php?op=total", {usu_id:usu_id}, function (data) {
            data = JSON.parse(data);
            $('#lbltotal').html(data.TOTAL);
        });

        $.post("../../controller/usuario.php?op=totalabierto", {usu_id:usu_id}, function (data) {
            data = JSON.parse(data);
            $('#lbltotalabierto').html(data.TOTAL);
        });

        $.post("../../controller/usuario.php?op=totalcerrado", {usu_id:usu_id}, function (data) {
            data = JSON.parse(data);
            $('#lbltotalcerrado').html(data.TOTAL);
        });

        $.post("../../controller/usuario.php?op=totalsinasignar", {usu_id:usu_id}, function (data) {
            data = JSON.parse(data);
            $('#lbltotalsinasignar').html(data.TOTAL);
        });

        $.post("../../controller/usuario.php?op=grafico", {usu_id:usu_id},function (data) {
            data = JSON.parse(data);

            new Morris.Bar({
                element: 'divgrafico',
                data: data,
                xkey: 'nom',
                ykeys: ['total'],
                labels: ['cantidad'],
                barColors: ["#1AB244"], 
            });
        });

    }else{
        if (sis_id==3){
            $.post("../../controller/ticketoc.php?op=total",{grupo_id:grupo_id,sis_id:sis_id},function (data) {
                data = JSON.parse(data);
                $('#lbltotal').html(data.TOTAL);
            });
    
            $.post("../../controller/ticketoc.php?op=totalabierto",{grupo_id:grupo_id,sis_id:sis_id},function (data) {
                data = JSON.parse(data);
                $('#lbltotalabierto').html(data.TOTAL);
            });
    
            $.post("../../controller/ticketoc.php?op=totalcerrado",{grupo_id:grupo_id,sis_id:sis_id}, function (data) {
                data = JSON.parse(data);
                $('#lbltotalcerrado').html(data.TOTAL);
            });
    
            $.post("../../controller/ticketoc.php?op=totalsinasignar",{grupo_id:grupo_id,sis_id:sis_id}, function (data) {
                data = JSON.parse(data);
                $('#lbltotalsinasignar').html(data.TOTAL);
            });
    
            $.post("../../controller/ticketoc.php?op=grafico",{grupo_id:grupo_id,sis_id:sis_id},function (data) {
                data = JSON.parse(data);
    
                new Morris.Bar({
                    element: 'divgrafico',
                    data: data,
                    xkey: 'nom',
                    ykeys: ['total'],
                    labels: ['cantidad']
                });
            });
        }else{
            $.post("../../controller/ticket.php?op=total",{grupo_id:grupo_id,sis_id:sis_id},function (data) {
                data = JSON.parse(data);
                $('#lbltotal').html(data.TOTAL);
            });
    
            $.post("../../controller/ticket.php?op=totalabierto",{grupo_id:grupo_id,sis_id:sis_id},function (data) {
                data = JSON.parse(data);
                $('#lbltotalabierto').html(data.TOTAL);
            });
    
            $.post("../../controller/ticket.php?op=totalcerrado",{grupo_id:grupo_id,sis_id:sis_id}, function (data) {
                data = JSON.parse(data);
                $('#lbltotalcerrado').html(data.TOTAL);
            });
    
            $.post("../../controller/ticket.php?op=totalsinasignar",{grupo_id:grupo_id,sis_id:sis_id}, function (data) {
                data = JSON.parse(data);
                $('#lbltotalsinasignar').html(data.TOTAL);
            });
    
            $.post("../../controller/ticket.php?op=grafico",{grupo_id:grupo_id,sis_id:sis_id},function (data) {
                data = JSON.parse(data);
    
                new Morris.Bar({
                    element: 'divgrafico',
                    data: data,
                    xkey: 'nom',
                    ykeys: ['total'],
                    labels: ['cantidad']
                });
            });
        }

        

    }
});

init();