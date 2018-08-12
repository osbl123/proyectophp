<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">


            <div class="col-md-12">
                <div class="row">
                    
                    <div class="col-md-6">
                        <form class="" action="blog/cambiar_paginacion" method="post">
                            
                                <label class="form-control-label">Mostrar <select name="lista_avisos_length" aria-controls="lista_avisos" class="form-control form-control-sm" style="display:inline-block;width:70px"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> Posts</label>
                            
                        </form>
                    </div>
                    <div class="col-md-6 clearfix">
                        <form class="" action="blog/buscar_post" method="post">
                        <div class="row form-group">
                            <div class="col col-md-12">
                              <div class="input-group">
                                <div class="input-group-btn">
                                  <button class="btn btn-primary" style="background-color:#003783">
                                    <i class="fa fa-search"></i> Buscar
                                  </button>
                                </div>
                                <input type="text" id="input1-group2" name="input1-group2" placeholder="Ingrese un texto" class="form-control">
                              </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title mb-3">Lista de publicaciones</strong>
                    </div>
                    <div class="card-body">

                        <?php
                        if(!is_null($articulos)) {
                            foreach($articulos as $item):
                        ?>
                                <h2 class="mb-0">
                                <a style="color:#003783;" href="<?=base_url().'post/'.$item->enlace;?>"><?= $item->titulo ?></a>
                                </h2>
                                <span class="text-muted">
                                <strong>Publicado hace:</strong> <?php echo timespan(strtotime($item->fecha), time(), 2); ?>&nbsp;atras.</span>
                                 <div class="mt-2">
                                     <!--
                                    <img src="<?php //base_url() ?>plantillas/img/usuario2.png" alt="Imagen del post" style="width:100px;height:100px;float:left;">-->
                                    <p><?=$item->descripcion?></p> 
                                    <a href="<?=base_url().'post/'.$item->enlace;?>" class="btn btn-primary" style="background-color:#003783">Leer mas</a>
                                 </div>
                                <hr>
                        <?php
                            endforeach;
                        } 
                        else {
                        ?>
                            <p>No se encontro ninguna publicacion para ud.</p>    
                        <?php
                        }
                        ?>
                        
                        <div class="d-flex justify-content-center">   
                        <?php 
                            echo $this->pagination->create_links();     
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>