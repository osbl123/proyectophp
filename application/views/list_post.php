<section class="contenido">
    <h1 align="center">Lista de articulos</h1>
    <?php 
        foreach($articulos as $item):
            //$url = 'articulo/' . $item->id_articulo . '/';
            //$url = 'articulo/';
            //EL TERCER PARAMETRO hace que sustituya todas la letras  mayusculas por minusculas
            //convert_accented_characters() esta funcion del helper text quita los acentros 
            //$url .= url_title(convert_accented_characters($item->nombre_articulo),'-',TRUE);
            $url = 'articulo/' . $item->enlace;
    ?>
            <h2><?php 
                echo anchor($url,$item->titulo ); 
            ?></h2>
            <strong>Fecha Publicacion:</strong> <?= $item->fecha; ?>
    <?php
        endforeach;
    ?>
</section>