
<section>
    <h3><?php echo $detalle->titulo; ?></h3>
    <strong>Author:</strong> <?= $docente->nombre." ".$docente->apellido_p." ".$docente->apellido_m ; ?> <br>
    <strong>Tema:</strong> <?= $detalle->etiquetas ; ?> <br>
    <strong>Fecha Publicacion:</strong> <?= $detalle->fecha; ?>
    <?= $detalle->contenido;  ?>
    <hr>
    <h5>Comentarios</h5>
</section>