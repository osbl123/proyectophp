
<section>
    <h3><?php echo $detalle->titulo; ?></h3>
    <strong>Author:</strong> <?= $docente->nombre." ".$docente->apellido_p." ".$docente->apellido_m ; ?> <br>
    <strong>Tema:</strong> <?= $detalle->tema ; ?> <br>
    <strong>Fecha Publicacion:</strong> <?= $detalle->fecha; ?>
    <?= $detalle->contenido;  ?>
    
</section>
<section>
    <?php
        $attributes = array('class' => 'form_comment', 'id' => 'form_comment');
        $hidden = array('id_entrada' => $detalle->id_entrada, 'id_respuesta' => '');
        echo form_open('blog/add_comment',$attributes,$hidden);
    ?>

    <div class="xpanel">
        <div class="titulo-comentario">
            <h5>10 Comentarios</h5>
        </div>
        <div class="d-flex">
            <div>
                <img src="<?= base_url(); ?>plantillas/img/admin.jpg" class="imagen" alt="Imagen estudiante">
            </div>
            <div class="w-100 pl-3">
                <div>
                    <p>vas a comentar de forma publica como <strong>Juan Peres</strong></p>
                    <textarea name="tacoment" id="tacoment" rows="1" placeholder ="Comparte tu opinión con el autor!"  class="txt-comment style-scope iron-autogrow-textarea" autocomplete="off" required="" maxlength="500" ></textarea>
                </div>
                <div class="d-flex">
                    <p>
                        Desea realizar el comentario…
                    </p>
                    <div class="ml-auto" >
                        <input type="button" value="Comentar">
                        <input type="button" value="Cancelar">
                    </div>
                </div>
                
            </div>
        </div>
        <div class="mt-5">
            <ul class="list-unstyled msg_list">
                <li class="d-flex">
                    <a >
                        <span >
                            <img class="imagen" src="<?= base_url() ?>/plantillas/img/admin.jpg" alt="imagen" />
                        </span>
                    </a>
                    <div class="ml-3">
                        <div>
                            <span>
                                <strong>John Smith</strong>
                                <span class="time">3 mins ago</span>
                            </span>
                        </div>
                        <div class="mt-2">
                            <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that
                            </span>
                        </div>
                        <div>
                            <a href="">
                            <strong>
                                Ver las 2 respuesta
                            </strong>
                            <span class="fa fa-chevron-right" ></span>
                        </a>
                        </div>
                    </div>
                    
                </li>
            </ul>
        </div>
    </div>
    
</section>