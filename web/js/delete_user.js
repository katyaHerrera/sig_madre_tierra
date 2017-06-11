/**
 * Created by cgcomputadoras on 8/6/2017.
 */
$(document).ready(function () {
    $('#message').hide();

    $('.btn-delete').click(function (e) {
        e.preventDefault();

//obtengo el id del usuario del boton del modal
        var id= $(this).attr('id');
        var idrow='row_'+id;
        var row=$('#'+idrow);


//reemplazo el id en el action del formulario
        var form=$('#form-delete');
        var url=form.attr('action').replace(':USER_ID',id);
        var data= form.serialize();
      // alert(data);

        $.post(url,data,function (result) {
            if(result.removed == 1){
                var idmodal='eliminarModal_'+id;
                $('#'+idmodal).modal('hide');
                row.fadeOut();
                $('#user-message').text(result.message);
                $('#message').show();
                $('#message').delay(4000).hide(600);

            }
        }).fail(function(){
            alert("ERROR");
            row.show();
        });


    });

    $('.btnAction').click(function (e) {
        e.preventDefault();

//obtengo el id del usuario
        var id= $(this).attr('id');
        var idrow='row_'+id;
        var row=$('#'+idrow);

        var idmodal='desactivarModal_'+id;
        $('#'+idmodal).modal('hide');


        var form=$('#form-update');
        var url=form.attr('action').replace(':USER_ID',id);
        var data=form.serialize();

        var idDesactivar='desactivar_'+id;
        var idActivar='activar_'+id;

        var idTextActivo='textActivo_'+id;
        var idTextDesactivado='textDesactivado_'+id;

        var idTextModalDesactivar='textModalDesactivar_'+id;
        var idTexModalActivar='textModalActivar_'+id;

        var botonDesactivarModal ='desactivarBM_'+id;
        var botonActivarModal= 'activarBM_'+id;

        $.post(url,data,function(result){

            $('#user-message').text(result.message);
            $('#message').show();
            $('#message').delay(4000).hide(600);

            if(result.update==1){

                $('#'+idDesactivar).removeClass('hidden');
                $('#'+idActivar).addClass('hidden');
                $('#'+idTextActivo).removeClass('hidden');
                $('#'+idTextDesactivado).addClass('hidden');
                $('#'+idTextModalDesactivar).removeClass('hidden');
                $('#'+idTexModalActivar).addClass('hidden');
                $('.'+botonDesactivarModal).removeClass('hidden');
                $('.'+botonActivarModal).addClass('hidden');

            }else{

                $('#'+idDesactivar).addClass('hidden');
                $('#'+idActivar).removeClass('hidden');
                $('#'+idTextActivo).addClass('hidden');
                $('#'+idTextDesactivado).removeClass('hidden');
                $('#'+idTextModalDesactivar).addClass('hidden');
                $('#'+idTexModalActivar).removeClass('hidden');
                $('.'+botonDesactivarModal).addClass('hidden');
                $('.'+botonActivarModal).removeClass('hidden');
            }

        })

    }).fail(function () {
        alert("ERROR");
        row.show();
    });


});