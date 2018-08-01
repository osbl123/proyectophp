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
			<h3 class="text-center"><strong>Modificar Contraseña</strong></h3>	        		
		</div>
		<div class="cart-body">
			
			<div class="container col-md-6 offset-md-3">
					<div  class="text-center alert alert-success" role="alert">
						La contraseña debe tener entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. NO puede tener otros símbolos.
		                    </div>
				<div>
				  <form >
				    <div class="form-group">
				      <label for="password1" >Contraseña Nueva:</label>
				        <input type="password" class="form-control" id="password1" placeholder="Contraseña nueva" data-pattern="[A-Za-z\d$@$!%*?&]{7,15}">
				        <!-- <input type="password" class="form-control" id="password1" placeholder="Contraseña nueva" data-pattern="^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{7,500}$"> -->
						<span id="span_password1" class="invalid-feedback" style="display:none;"></span>
				    </div>
				    <div class="form-group">
				      <label for="password2">Repita Contraseña Nueva:</label>
				        <input type="password" class="form-control" id="password2" placeholder="Repita Contraseña">
						<span id="span_password2" class="invalid-feedback" style="display:none;"></span>
				    </div>
				    <div class="form-group row">
				      <div class="col-sm-12">
				        <button class="btn btn-primary btn-block" id="btn_modificar">Modificar</button>
				      </div>
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
        <h5 class="modal-title" id="exampleModalLabel">Seguro de Modificar</h5>
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
<script>

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

	password1=validar_element("password1","password","La contraseña introducida no cumple los requerimientos", 'span_password1');
	password2=validar_element("password1","identico","password2", 'span_password2');
	if(password1&&password2)
		return true;
	else
		return false;

}
$("#btn_modificar").click(function(e){
    e.preventDefault();
	if(validar())
	{
		mensaje_aux='<div  class="text-center alert alert-warning" role="alert"><h1><span class="fa fa-exclamation-triangle"></span></h1><span> Está seguro de queres modificar su contraseña?</span></div>';
		$('#mensaje').html(mensaje_aux);

				$("#btn_confirmado").attr('disabled', false); 
		$('#Modal_alerta').modal('show');
	}
});
$("#btn_confirmado").click(function(e){
    e.preventDefault();
	$("#btn_confirmado").html('<span  class="fa fa-spinner fa-spin "></span >'); 
        $.post(baseurl+"perfil/contrasenia/update_password",
            {   codigo:$("#cod_ceta").html(),
                password1:$("#password1").val(),            
            }, 
            function(data){
                $("#btn_confirmado").html('Grabar Cambios'); 
				$("#btn_confirmado").attr('disabled', true); 
                if(data==='exito')
                {
                	mensaje_aux='<div  class="text-center alert alert-success" role="alert"><h1><span class="fa fa-exclamation-triangle"></span></h1><span> Cambio realizado con éxito.</span></div>';
					$('#mensaje').html(mensaje_aux);
        			$("#btn_modificar").attr('disabled',true);
        			$("#btn_modificar").html('Realizado');
                }
                else
                {
                	mensaje_aux='<div  class="text-center alert alert-danger" role="alert"><h1><span class="fa fa-exclamation-triangle"></span></h1><span> No se pudo cambiar la contraseña. Comuníque se con el Instituto</span></div>';
					$('#mensaje').html(mensaje_aux);
                }
            });
});


function validar_element(elemento,tipo,mensaje,span_error)
{
	if(tipo=="password")
	{
		var str=$("#"+elemento).val();
		var thisPattern=$("#"+elemento).data("pattern");
		mensaje_alerta='';
		control=true
		
		
		if(str.length<7)
		{
			mensaje_alerta+=' La contraseña debe tener entre 8 y 16 caracteres.';
			control=false;
		}
		else
			if(str.match(thisPattern)==null)
			{
				mensaje_alerta+=' La contraseña debe tener al menos un dígito, al menos una minúscula y al menos una mayúscula. NO puede tener otros símbolos.';
				control=false;
			}
		if(control)
		{
			$("#"+elemento).attr("class","form-control ");
			$("#"+span_error).text("").hide();
			return true;
		}
		else
		{	
			
			$("#"+elemento).attr("class","form-control is-invalid");
			$("#"+span_error).text(mensaje_alerta).show();
			return false;
		}
	}
	if(tipo=="texto")
	{
		var valor=document.getElementById(elemento).value;
		if(valor==null|| valor.length==0||/^\s+$/.test(valor))
		{
			$("#"+elemento).parent().parent().attr("class","form-control is-invalid");
			$("#"+span_error).text(mensaje).show();
			return false;
		}
		else
		{	$("#"+elemento).parent().parent().attr("class","form-control ");
			$("#"+span_error).text("").hide();
			return true;
		}
	}
	if(tipo=="identico")
	{
		var valor1=document.getElementById(elemento).value;
		var valor2=document.getElementById(mensaje).value;
		if(valor1!=valor2)
		{
			$("#"+elemento).parent().parent().attr("class","form-control is-invalid");
			$("#"+span_error).text('La contraseña ingresada no coincide con la anterior').show();
			return false;
		}
		else
		{	$("#"+elemento).parent().parent().attr("class","form-control ");
			$("#"+span_error).text("").hide();
			return true;
		}
	}
	if(tipo=="cero")
	{
		var valor=document.getElementById(elemento).value;
		if(valor=='0')
		{
			$("#"+elemento).parent().parent().attr("class","form-control is-invalid");
			$("#"+span_error).text(mensaje).show();
			return false;
		}
		else
		{	$("#"+elemento).parent().parent().attr("class","form-control ");
			$("#"+span_error).text("").hide();
			return true;
		}
	}

}
</script>
