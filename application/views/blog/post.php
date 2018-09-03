
<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title mb-3 text-center"><?php echo $detalle->titulo; ?></h2>

                        <div class="d-flex justify-content-between w-100">
                            <span style="display:inline-block;" class="text-muted"><strong>Author:</strong> <?= $docente ?></span>
                            <span style="display:inline-block;" class="text-muted text-right"><strong>Tema:</strong> <?= $detalle->tema ; ?></span> 
                        </div>
                        <span class="text-muted"><strong>Fecha Publicacion:</strong><?= $detalle->fecha; ?></span>
                    </div>
                    <div class="card-body">
                        
                        <?= $detalle->contenido;  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="id_post" value="<?= $detalle->id_post ?>">
<input type="hidden" name="block_coment" id="block_coment" value="<?= $bloqueado ?>">

<?php 
if($detalle->permite_comentario == 't') {

    if($bloqueado == 't') {
        echo '<div id="msg_bloqueado" class="alert alert-danger">Ud. Esta bloqueado no puede emitir, ni responder comentarios.</div>';
        //echo "<p>Ud. Esta bloqueado no puede emitir comentarios</p>";
    }
    else {
?>
<section>
    <hr>
    <?php
        $attributes = array('class' => 'form_comment', 'id' => 'formularioComentar');
        echo form_open('blog/nuevo_comentario',$attributes);
    ?>

    <div class="xpanel">
        <!-- Inicio formulario para el ingreso de comentarios -->
        <span><?php echo validation_errors(); ?></span>
        <div id="comentarios" class="d-flex align-items-center">
            <div class="align">
                <img src="<?= base_url(); ?>plantillas/gallery/<?= $cod_ceta ?>.jpg" class="imagen" alt="Imagen estudiante">
            </div>
            <div class="w-100 pl-3">
                <div>
                    <p>Vas a comentar de forma publica como <strong><?= $nombre_est ?></strong><span  class="fa fa-spinner fa-spin " id="spinner" ></span ></p>
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
        <div id="msg_comentario" class="alert alert-success">Comentario publicado</div>
        <!--fin del mensaje-->
    </div>
    <?= form_close(); ?> 
    <hr style="border-top:3px solid rgba(0,0,0,.1);">
</section>
<?php
    }
?>


<section>
    <!--mostramos los comentarios si es que los hay-->      
    <div id="mostrar_respuesta" >
        <ul class="list-unstyled msg_list" id="list_coment_0" >
        </ul>
    </div>
        <!--fin del div que muestra los comentarios-->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lbl_titulo_modal"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php 
      $attributes = array('class' => 'form_comment', 'id' => 'formularioResponder');

      echo form_open('blog/nueva_respuesta',$attributes);
      ?>
      <div class="modal-body">
          <div class="form-group">

            <label for="message-text" class="col-form-label" id="lbl_modal">Respuesta:</label>
            <textarea class="form-control" id="respuesta-text" name="respuesta-text" required></textarea>
          </div>
      </div>
      <div class="modal-footer">
          <input type="hidden" name="id_post_respuesta" id="id_post_respuesta" value="<?= $detalle->id_post; ?>">
          <input type="hidden" name="id_operacion" id="id_operacion" value="">
          <input type="hidden" name="tipo_operacion" id="tipo_operacion" value="">
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
<?php 
}
else {
?>
<hr>
<p><strong>Esta publicación tiene deshabilitado los comentarios</strong></p>
<?php
}
?>