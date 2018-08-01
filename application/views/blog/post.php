
<section>
    <h3><?php echo $detalle->titulo; ?></h3>
    <strong>Author:</strong> <?= $docente ?> <br>
    <strong>Tema:</strong> <?= $detalle->tema ; ?> <br>
    <strong>Fecha Publicacion:</strong> <?= $detalle->fecha; ?>
    <?= $detalle->contenido;  ?>

    <hr>
    
</section>
<section>
    <?php
        $attributes = array('class' => 'form_comment', 'id' => 'formularioComentar');
        $hidden = array(
            'id_post' => $detalle->id_post
            //,'id_respuesta' => ''
        );
        echo form_open('blog/nuevo_comentario',$attributes,$hidden);
    ?>

    <div class="xpanel">
        <!-- Inicio formulario para el ingreso de comentarios -->
        <span><?php echo validation_errors(); ?></span>
        <div id="comentarios" class="d-flex align-items-center">
            <div class="align">
                <img src="<?= base_url(); ?>plantillas/img/usuario2.png" class="imagen" alt="Imagen estudiante">
            </div>
            <div class="w-100 pl-3">
                <div>
                    <p>vas a comentar de forma publica como <strong><?= $nombre_est ?></strong><span  class="fa fa-spinner fa-spin " id="spinner" ></span ></p>
                    <textarea name="comentario" id="comentario" rows="1" placeholder ="Comparte tu opinión con el autor!" class="txt-comment style-scope iron-autogrow-textarea" autocomplete="off" required maxlength="500" ></textarea>
                </div>
                <div id="comentario-opciones" class="">
                    <p>Desea realizar el comentario…</p>
                    <div class="ml-auto" >
                        <input type="submit" value="Publicar comentario">
                        <input type="button" value="Cancelar">
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin fomulario -->
        <!--mostramos un mensaje conforme se ha publicado el comentario-->
        <div id="comentarioPublicado" class="alert alert-success">Comentario publicado</div>
        <!--fin del mensaje-->
    </div>
    <?= form_close(); ?> 
    <hr style="border-top:3px solid rgba(0,0,0,.1);">
</section>
<section>
    <!--mostramos los comentarios si es que los hay-->      
    <div id="mostrarComentarios" ></div>
        <!--fin del div que muestra los comentarios-->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Escribe tu respuesta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php 
      $attributes = array('class' => 'form_comment', 'id' => 'formularioResponder');
      $hidden = array(
          'id_post_respuesta' => $detalle->id_post,
          'id_respuesta' => ''
      );
      echo form_open('blog/nueva_respuesta',$attributes,$hidden);
      ?>
      <form>
      <div class="modal-body">
          <div class="form-group">

            <label for="message-text" class="col-form-label">Respuesta:</label>
            <textarea class="form-control" id="respuesta-text" name="respuesta-text" required></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <input type="submit" value="Enviar" class="btn btn-primary"/>
        <!-- 
        <button type="button" class="btn btn-primary">Enviar</button>
        -->
      </div>
      <?= form_close(); ?> 
    </div>
  </div>
</div>
</section>

<script>

$(function(){
    $('#formularioResponder').on('submit', function(e){
        e.preventDefault();

        if( $("#respuesta-text").val().length <= 5){
            $("#respuesta-text").focus().after(alert('Escriba como mínimo 5 carácteres para el comentario'));
            return false;
        }else{
            $.ajax({
                url: $(this).attr("action"), //this is the submit URL
                type: 'POST', 
                data: $('#formularioResponder').serialize(),
                success: function(data){
                    console.log('successfully '+data);
                    //alert();
                }
            });
            $("#exampleModal").modal('hide');
        }
    });
});


//función para insertar un nuevo comentario
$(document).ready(function(){
    $("#formularioComentar").submit(function(e){
        e.preventDefault();

        $('#comentario').prop('disabled', true);
        $('#spinner').show();

        if( $("#comentario").val().length <= 5){
            $("#comentario").focus().after(alert('Escriba como mínimo 6 carácteres para el comentario'));
            return false;
        }else{
            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"), 
                data: {
                    comentario:$("#comentario").val()
                    //$('#h_v').val();
                    ,id_post:$("input[name=id_post]").val()
                },
                success:function(data){ 
                    console.log(" el data es: "+data+" eso");

                    $('#comentario').prop('disabled', false);
                    $('#spinner').hide();

                    $('#comentario').val('');    
                    $('#comentario').focus();
                    //$("#comentario").attr("value", "").focus(); 

                    $("#comentarioPublicado").delay(500).show(0);
                    $("#comentarioPublicado").delay(4000).hide(0);
                }
            }); 
            return false;
        }
    });              
});
//función para recargar el div mostrarComentarios cada 2 segundos
$(document).ready(function(){
    /*
    $("#mostrarComentarios").load("<?= base_url() ?>blog/get_comentarios_ajax", 
            { id_post: $("input[name=id_post]").val() }, function() {
            
        });
    */
    setInterval(function() {
        //$("#mostrarComentarios").load("<?= base_url() ?>blog/get_comentarios_ajax", function(){});
        $("#mostrarComentarios").load("<?= base_url() ?>blog/get_comentarios_ajax", 
            { id_post: $("input[name=id_post]").val() }, function() {
            
        });
    }, 2000);
    
    
});

$(document).ready(function(){
    $("#comentarioPublicado").hide();
    $('#spinner').hide();
    //$("#comentario-opciones").hide();

    $("#comentario").focusin(function() {
        //$("#comentario-opciones").show();
    });
    $("#comentario").focusout(function() {
        //$("#comentario-opciones").hide(); 
    });

});

    function setIdRespuesta(valor) {
        $('input[name=id_respuesta]').val(valor)
        //alert('hola mundo'+val);
    }

    function cargarRespueta(idComentario) {
        $('#mostrar_respuesta'+idComentario).load("<?php echo base_url() ?>blog/get_resuestas_ajax", 
            { id_comentario: idComentario }, function() {
                console.log('Entro en el console log');
        });
    }
</script>