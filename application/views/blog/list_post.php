<section class="contenido">
    <h1 align="center">Lista de articulos</h1>
    <?php
    if(!is_null($articulos)) {
        foreach($articulos as $item):
            //$url = 'articulo/' . $item->id_articulo . '/';
            //$url = 'articulo/';
            //EL TERCER PARAMETRO hace que sustituya todas la letras  mayusculas por minusculas
            //convert_accented_characters() esta funcion del helper text quita los acentros 
            //$url .= url_title(convert_accented_characters($item->nombre_articulo),'-',TRUE);
            $url = 'post/' . $item->enlace;
    ?>
            <h2><?php 
                echo anchor($url,$item->titulo ); 
            ?></h2>
            <p><?=$item->descripcion?></p>
            <strong>Fecha Publicacion:</strong> <?= $item->fecha; ?>
    <?php
        endforeach;
    } 
    else {
    ?>
        <p>No se encontro ninguna publicacion para ud.</p>    
    <?php
    }
    ?>
    <hr>
    <div class="d-flex justify-content-center">   
    <?php 
        echo $this->pagination->create_links();     
    ?>
    </div>
    
</section>