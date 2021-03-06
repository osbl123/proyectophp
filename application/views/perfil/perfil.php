<div class="cart cart-primary table-responsive" >
	<div class="container-fluid" id="log_in_" >
		<div class="card bg-default  col-md-6 offset-md-3">
            <div class="card-body">
                <h5 class="text-center">Por su seguridad identifíquese por favor</h5>
                <form>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-asterisk"></i></span>
                        </div>
                        <input type="password" class="form-control" id="password" placeholder="Contraseña">
                    </div>
                    <div  style="display: none;" class="text-center alert alert-danger" role="alert" id="show_error">
                    </div>
                        <button class="btn btn-success btn-block" id="btn_send">Verificar</button>
                </form>
            </div>
        </div>
	</div>
	<div  id="data" style="display: none;">
		<div class="cart-heading">
			<h3 class="text-center"><strong>Modificar Perfil</strong></h3>	        		
		</div>
		<div class="cart-body">
			<div class="container col-md-10 offset-md-1 col-lg-8 offset-lg-2">
					<div  class="text-center alert alert-success" role="alert">
						Solo puede modificar su <strong>Correo electrónico</strong> y su <strong>Imágen</strong> para el Blog. Si desea modificar otra información de su Biografía, por favor apersónce a la secretaría de su carrera.
		                    </div>
				<div>
				  <form method="post" action="upload.php" enctype="multipart/form-data" id="uploadForm">
				    <div class="form-group">
                        <label for="email" >Correo Electrónico:</label>
                        <div class="input-group mb-3">
                        <input type="e-mail" class="form-control" id="email" placeholder="Ingrese Correo Electrónico" data-pattern="^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$">
                          <div class="input-group-append">
                            <button class="btn btn-primary btn-block" id="btn_modificar">Actualizar</button>
                          </div>
                        </div>
                        <span id="span_email" class="invalid-feedback" style="display:none;"></span>
                    </div>
				    <div class="form-group">
				        <label for="foto_est">Imagen:</label>
                        <div class=" mb-3">
                            <img id="foto_est" src="<?=base_url();?>plantillas/gallery/<?= $cod_ceta;?>.jpg" class="img-responsive" alt="CETA" width="120" height="120" style="margin: 0 auto;" onerror="this.src='<?=base_url();?>plantillas/gallery/user0.jpg'">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_imagen">Cambiar Imagen</button>
                        </div>
						<span id="span_password2" class="invalid-feedback" style="display:none;"></span>
				    </div>
				  </form>
				</div>
			</div>						
		</div>
	</div>
</div>
<div class="modal fade" id="Modal_alerta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="alert_title">Seguro de Modificar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="mensaje">
       	<div  class="text-center alert alert-warning" role="alert">
			<h1><span class="fa fa-exclamation-triangle"></span></h1><span> Está seguro de queres modificar su contraseña?</span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" id="btn_confirmado" class="btn btn-primary">Grabar Cambios</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal_imagen" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
         <form enctype="multipart/form-data" id="formuploadajax" method="post" onsubmit='return checkCoords();'>

        <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel">Seleccione una imagen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" >
            <div class="input-group mb-3">

                <label class="input-group-prepend ">
                    <span class="input-group-btn btn btn-primary ">
                        Seleccionar&hellip; <input type="file" name="file" id="file" style="display: none;" accept="image/*">
                    </span>
                </label>
                <input type="text" class="form-control" id="leyenda_files" readonly style="height: 38px" >
            </div>
            <div id="imagen_sel" style="display: none;">
                    <img width="480" height="360" id="cropbox" src="<?=base_url();?>plantillas/gallery/<?= $cod_ceta;?>.jpg" onerror="this.src='<?=base_url();?>plantillas/gallery/user0.jpg'">        
                    <input type='hidden' id='x' name='x' />
                    <input type='hidden' id='y' name='y' />
                    <input type='hidden' id='w' name='w' />
                    <input type='hidden' id='h' name='h' />
                    <input type='hidden' id='source_image' name='source_image' value='<?=base_url();?>plantillas/gallery/user0.jpg' />
                    <!-- <div class="col-md-12">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button class='btn btn-primary' type='submit' id="enviar">Actualizar</button>
                    </div> -->
            </div>
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <!-- <button type="button" id="enviar" class="btn btn-primary">Grabar Cambios</button> -->
            <button class='btn btn-primary' type='submit' id="enviar">Actualizar</button>
        </div>
    </div>
        <?php echo form_close(); ?>
  </div>
</div>
<script>

            
$("#enviar").click(function(e){
    base64image=$('#cropbox').attr('src');
    e.preventDefault();

            $.post(baseurl+"perfil/perfil/crop",
            {   
                    x: $("#x").val(),
                    y: $("#y").val(),
                    w: $("#w").val(),
                    h: $("#h").val(),  
                    source_image:base64image,          
            }, 
            function(data){
                $('#modal_imagen').modal('hide');
                if(data=='exito')
                {
                    // alert(baseurl+'plantillas/gallery/'+$("#cod_ceta").html()+'.jpg');
                    $('#foto_est').attr('src',baseurl+'plantillas/gallery/'+$("#cod_ceta").html()+'.jpg?timestamp=' + new Date().getTime());
                }
                else
                if(data=='error_thumb')
                {
                    mensaje_aux='<div  class="text-center alert alert-danger" role="alert"><h1><span class="fa fa-exclamation-triangle"></span></h1><span> Error al reducir la imagen. Intente nuevamente</span></div>';
                        $('#alert_title').html('Error al cambiar');
                        $('#mensaje').html(mensaje_aux);
                        $('#Modal_alerta').modal('show');

                }
                else
                {
                    mensaje_aux='<div  class="text-center alert alert-danger" role="alert"><h1><span class="fa fa-exclamation-triangle"></span></h1><span> Error al guardar la imagen. Intente nuevamente</span></div>';
                        $('#alert_title').html('Error al guardar');
                        $('#mensaje').html(mensaje_aux);
                        $('#Modal_alerta').modal('show'); 
                }
                
            });
});
    
    function updateCoords(c)
    {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
    };
    
    function checkCoords()
    {
        if (parseInt($('#w').val())) return true;
        alert('Please select a crop region then press submit.');
        return false;
    };
var jcrop_api;
function filePreview(input) {
    if (input.files && input.files[0]) {

        if (typeof jcrop_api !== 'undefined')
        jcrop_api.destroy();
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#leyenda_files').val(input.files[0].name);
            $('#cropbox').attr('src',e.target.result);
            $('#cropbox').show();
            $('#cropbox').Jcrop({
                // onChange: showPreview,
                 // onSelect: showPreview,
                    setSelect:   [ 100, 100, 50, 50 ],
                    aspectRatio: 1,
                    onSelect: updateCoords
                },function(){ jcrop_api=this});
        }
        reader.readAsDataURL(input.files[0]);
        $('#imagen_sel').show();
    }
}
$("#file").change(function () {
    filePreview(this);
});
function habilitar(parametro)
{
    $("#password").attr('disabled',!parametro);
    $("#btn_send").attr('disabled',!parametro); 
}
$("#btn_send").click(function(e){
    e.preventDefault();
    $("#show_error").hide();
	if($("#password").val().length>0)
	{
    	habilitar(false);
    	$("#btn_send").html('<span  class="fa fa-spinner fa-spin "></span >'); 
        $.post(baseurl+"perfil/contrasenia/login",
            {   codigo:$("#cod_ceta").html(),
                password:$("#password").val(),            
            }, 
            function(data){
                if(data==='exito')
                {
        			$("#log_in_").hide();
        			$("#data").show(); 

        			 $.post(baseurl+"perfil/perfil/get_datos",
			            {   codigo:$("#cod_ceta").html(),
			            }, 
			            function(data){
                            if(data.length>0)
			        			$("#email").val(data);
                            else
                                $("#email").val('No existe Correo Registrado');
			            });      			
                }
                else
                {
                	console.log('entro');
                    $("#show_error").show();
                    $("#btn_send").html('Iniciar Sesión'); 
                    habilitar(true);
                    $("#show_error").html('La Contraseña introducida, no corresponden a un estudiante registrado, verifique sus datos.');
                }
            });
    }
    else
    {
        $("#show_error").html('Introduzca su CONTRASEÑA por favor.');
        $("#show_error").show();
    }

});
function validar() {
	return validar_element("email","email","El correo introducido no es válido", "span_email");	
}
$("#btn_modificar").click(function(e){
    e.preventDefault();
	if(validar())
	{
		mensaje_aux='<div  class="text-center alert alert-warning" role="alert"><h1><span class="fa fa-exclamation-triangle"></span></h1><span> Está seguro de queres modificar el Correo Electrónico?</span></div>';
        $('#alert_title').html('Seguro de cambiar?');
		$('#mensaje').html(mensaje_aux);

				$("#btn_confirmado").attr('disabled', false); 
		$('#Modal_alerta').modal('show');
	}
});
$("#btn_confirmado").click(function(e){
    e.preventDefault();
	$("#btn_confirmado").html('<span  class="fa fa-spinner fa-spin "></span >'); 
        $.post(baseurl+"perfil/perfil/update_email",
            {   codigo:$("#cod_ceta").html(),
                email:$("#email").val(),            
            }, 
            function(data){
                $("#btn_confirmado").html('Grabar Cambios'); 
				$("#btn_confirmado").attr('disabled', true); 
                if(data==='exito')
                {
                	mensaje_aux='<div  class="text-center alert alert-success" role="alert"><h1><span class="fa fa-exclamation-triangle"></span></h1><span> Cambio realizado con éxito.</span></div>';
                    $('#alert_title').html('Cambio realizado');
					$('#mensaje').html(mensaje_aux);
        			// $("#data").hide();
                }
                else
                {
                	mensaje_aux='<div  class="text-center alert alert-danger" role="alert"><h1><span class="fa fa-exclamation-triangle"></span></h1><span> No se pudo cambiar el Correo Electrónico. Comuníque se con el Instituto</span></div>';
                    $('#alert_title').html('Error');
					$('#mensaje').html(mensaje_aux);
                }
            });
});
function validar_element(elemento,tipo,mensaje,span_error)
{
	if(tipo=="email")
	{
		valor=$("#"+elemento).val();
		if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(valor))
		{
			$("#"+elemento).attr("class","form-control ");
			$("#"+span_error).text("").hide();
			return true;
		}
		else
		{	
			$("#"+elemento).attr("class","form-control is-invalid");
			$("#"+span_error).text(mensaje).show();
			return false;
		}
	}	

}


</script>
