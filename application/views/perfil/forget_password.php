<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>WEB SGA - Estudiantes Intituto CETA</title>

    <link rel="icon" type="image/gif" href="<?=base_url()?>plantillas/img/favicon.gif">
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url()?>plantillas/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url()?>plantillas/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="<?= base_url()?>plantillas/js/jquery.min.js"></script>

        
</head>

<body  style="background-image: url(<?=base_url();?>plantillas/img/bg-2.jpg); background-size: cover; background-attachment: fixed; background-position: center; background-repeat: no-repeat;" >
    
    <div class="container" >
        <div class="col-md-4 offset-md-4 " align="center" >
        <img src="<?= base_url()?>plantillas/img/logo.png">        
        </div> 
    </div>

    <div class="main" >
        <div class="row" >
            <div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4" style="padding-bottom: 10px;">
                <div class="card bg-default">
                    <div class="card-header text-center bg-primary">
                        <h4 class="card-title text-center" ><font color="white">¿Tienes problemas para acceder?</font></h2> 
                    </div>
                    <div class="card-body">

                                
                        <div class="radio col-xs-12">
                            <label>
                              <input type="radio" name="radios" class="track-order-change" id="firstRadio" value="">
                              No recuerdo mi Contraseña
                            </label>
                        </div>

                        <div class="col-xs-12 panel-collapse collapse in" id="no_password" style="">
                            <div class="card card-body" id="paso1">
                              <form >
                                <div class="form-group">
                                  <label for="cod_estudiante" >Ingrese el Código de Estudiante que le asignó el Instituto</label>
                                    <input type="text" class="form-control" id="cod_estudiante" placeholder="Código CETA" autofocus onkeypress="return solo_numeros(event)" required>
                                    <span id="span_codigo" class="invalid-feedback" style="display:none;"></span>
                                </div>                                
                                <div class="form-group row">
                                  <div class="col-sm-12">
                                    <button class="btn btn-primary btn-block" id="btn_continuar1">Continuar</button>
                                  </div>
                                </div>
                              </form>
                            </div>
                            <div class="card card-body" id="paso2" style="display: none;">
                              <form >
                                <div class="form-group">
                                  Se le enviará una nueva contraseña al Correo Electrónico <strong id="email_get"></strong>. Una vez ingresado al sistema, cambielo por una contraseña para usted.
                                </div>                                
                                <div class="form-group row">
                                  <div class="col-sm-12">
                                    <button class="btn btn-primary btn-block" id="btn_continuar2">Enviar</button>
                                  </div>
                                </div>
                              </form>
                            </div>
                            <div class="card card-body" id="paso3" style="display: none;">
                              <form >
                                <div class="form-group" id="mensaje-email">
                                  
                                </div>                                
                                <div class="form-group row">
                                  <div class="col-sm-12">
                                    <a class="btn btn-success btn-block" href="<?= base_url()?>" role="button">Retornar</a>
                                  </div>
                                </div>
                              </form>
                            </div>
                        </div>

                        <div class="radio col-xs-12">
                            <label>
                              <input type="radio" name="radios" class="track-order-change" id="secondRadio">
                              No recuerdo mi Código de Estudiante
                            </label>
                        </div>

                        <div class="col-xs-12 panel-collapse collapse in" id="no_codigo" style="">
                            <div class="card card-body">
                              El código se le entrega al momento de su inscripción, si no lo memorizó o no lo tiene guardado, solicite esta información en Secretaría de su carrera.
                            </div>
                        </div>

                        <div class="radio col-xs-12">
                            <label>
                              <input type="radio" name="radios" class="track-order-change" id="thirdRadio">
                              No recuerdo mi Correo Electrónico (e-mail).
                            </label>
                        </div>
                        <div class="col-xs-12 panel-collapse collapse in" id="no_email" style="">
                            <div class="card card-body">
                              Si no recuerda o no registró su Correo Electrónico, solicite esta información en la Secretaría de su carrera.
                            </div>
                        </div>
                          

                       
                    </div>
                    <div class="card-footer text-muted">
                    <a class="btn btn-info btn-block" href="<?= base_url()?>" role="button">Retornar</a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

<!-- jQuery -->
<script src="<?= base_url()?>plantillas/js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?= base_url()?>plantillas/js/bootstrap.min.js"></script>

<script >
var baseurl="<?=base_url();?>";
var email='';
var nombre='';
$(window).load(function(){
      
    $('input[name="radios"]').change( function() {
        
        if ($('#firstRadio').is(":checked")){

            $('#no_password').collapse('show');
            $('#no_codigo').collapse('hide');
            $('#no_email').collapse('hide');
        
        } else {
            
            $('#no_password').collapse('hide');
        }
        
        if ($('#secondRadio').is(":checked")){

            $('#no_codigo').collapse('show');
            $('#no_password').collapse('hide');
            $('#no_email').collapse('hide');
        
        } else {
            
            $('#no_password').collapse('hide');
        }
        
        if ($('#thirdRadio').is(":checked")){

            $('#no_email').collapse('show');
            $('#no_password').collapse('hide');
            $('#no_codigo').collapse('hide');
        }

  });
});

function solo_numeros(e) //controlamos que sea solo numero sin punto ni otros
{
    var keynum = window.event ? window.event.keyCode : e.which;
    if ( keynum == 8 ) return true;
    if ( keynum == 13 ) return true;
    return /\d/.test(String.fromCharCode(keynum));
}
function validar() {
    if(validar_element("cod_estudiante","vacio","Introduzca su CODIGO por favor.", "span_codigo"))
        return validar_element("cod_estudiante","tamaño_codigo","El Código introducido no cumple con el tamaño del Código asignado por el Instituto, verifique sus datos.", "span_codigo");
    else
        return false;
}
function validar_element(elemento,tipo,mensaje,span_error)
{
    if(tipo=="vacio")
    {
        valor=$("#"+elemento).val();
        if (valor!="")
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
    if(tipo=="tamaño_codigo")
    {
        valor=$("#"+elemento).val();
        if (valor.length==9)
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
    if(tipo=="no_valido")
    {
        {   
            $("#"+elemento).attr("class","form-control is-invalid");
            $("#"+span_error).text(mensaje).show();
            return false;
        }
    }   

}
$("#btn_continuar1").click(function(e){
    e.preventDefault();
    if(validar())
    {
        $("#btn_continuar1").attr('disabled',true); 
        $("#btn_continuar1").html('<span  class="fa fa-spinner fa-spin "></span >'); 

        $.post(baseurl+"perfil/forget_password/verificar_codigo",
            {   codigo:$("#cod_estudiante").val(),
            }, 
            function(data){
                if(data=='no_existe')
                {
                    validar_element("cod_estudiante","no_valido","El Código introducidos, no corresponden a un estudiante registrado, verifique sus datos.", "span_codigo");
                }
                else
                if(data==='no_email')
                    validar_element("cod_estudiante","no_valido","Usted no tiene registrado un Correo Electrónico en el sistema. Acerquese a la Secretaría de su carrera y registre uno.", "span_codigo");
                else
                {
                    lista = JSON.parse(data);
                    email=lista.email;
                    nombre=lista.nombre;
                    email_aux = lista.email.split('@');
                    e_mail = email_aux[0].substring(0, 4)+'****@'+email_aux[1];
                
                    $("#paso1").hide();
                    $("#paso2").show();
                    $("#email_get").html(e_mail); 


                }
                $("#btn_continuar1").html('Continuar'); 
                $("#btn_continuar1").attr('disabled',false); 
                    
            });
    }

});
$("#btn_continuar2").click(function(e){
    e.preventDefault();
        $("#btn_continuar2").attr('disabled',true); 
        $("#btn_continuar2").html('<span  class="fa fa-spinner fa-spin "></span >'); 

        $.post(baseurl+"perfil/forget_password/enviar",
            {   
                e_mail:email,
                e_mail_nombre:nombre,
                codigo:$('#cod_estudiante').val(),
            }, 
            function(data){
                $("#paso2").hide();
                $("#paso3").show();
                if(data==='error')
                   $("#mensaje-email").html('No se pudo enviar el mensaje. intentelo nuevamente o consulte en secretaría de su carrera.');
               else
                {
                   $("#mensaje-email").html('Se ha enviado un correo con la nueva contraseña, verifique su bandeja de entrada.'); 
                }
                
               
                $("#btn_continuar2").html('Enviar'); 
                $("#btn_continuar2").attr('disabled',false); 
                    
            });
});
</script>
</body>

</html>

