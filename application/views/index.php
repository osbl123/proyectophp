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
    <link href="<?= base_url()?>public/css/bootstrap.css" rel="stylesheet">
    <link href="<?= base_url()?>public/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="<?= base_url()?>public/js/jquery.min.js"></script>

        
</head>

<body  style="background-image: url(<?=base_url();?>plantillas/img/bg-2.jpg); background-size: cover; background-attachment: fixed; background-position: center; background-repeat: no-repeat;" >
    
    <div class="container" >
        <div class="col-md-4 offset-md-4 " align="center" >
        <img src="<?= base_url()?>plantillas/img/logo.png">        
        </div> 
    </div>

    <div class="main" >
        <div class="row" >
            <div class="col-lg-4 text-center">
                <img src="<?= base_url()?>plantillas/img/login.png" alt="Login" width="214" height="220">
            </div>
            <div class="col-lg-4" style="padding-bottom: 10px;">
                <div class="card bg-default">
                    <div class="card-header text-center bg-primary">
                        <b class="text-white">Bienvenido al Sistema de Información al Estudiante.</b>
                        <h2 class="card-title text-center" ><font color="white"><b>MECANICA AUTOMOTRIZ</b></font></h2> 
                    </div>
                    <div class="card-body">
                        <h5 class="text-center">Por favor identifiquese</h5>
                        <form>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" id="cod_estudiante" placeholder="Código CETA" autofocus >
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-asterisk"></i></span>
                                </div>
                                <input type="password" class="form-control" id="password" placeholder="Carnet de Identidad (C.I.)" >
                            </div>
                            <!-- <div class="alert alert-warning alert-dismissible" style="display: none;" id="show_error">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <h6 class="text-danger" id="mensaje_error"></h6>
                            </div> -->
                            <div  style="display: none;" class="text-center" id="show_error">
                                <h6 class="text-danger" id="mensaje_error"></h6>
                            </div>
                                <button class="btn btn-primary btn-block" id="btn_send">Iniciar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="col-lg-12 col-xl-8 offset-xl-2">
                    <div class="card ">                    
                        <div class="card-header bg-warning">
                            <h3 class="card-title text-center text-red"><strong>INSTRUCCIONES</strong></h3>
                        </div>
                        <div class="card-body">
                            <img src="<?= base_url()?>plantillas/img/llave.png" width="30" height="30">&nbsp;&nbsp;En el campo <strong>Código CETA</strong> debe ingresar su código de estudiante proporcionado por el Instituto al momento de su inscripción y consta de 9 digitos <br>
                            <img src="<?= base_url()?>plantillas/img/llave.png" alt="">&nbsp;&nbsp;En el campo <strong>C.I</strong> debe   ingresar el número de su Carnet de Identidad, si contiene literal, debe ingresarlo tambien, ejm: 1234567-i4.
                            <br>
                            <img src="<?= base_url()?>plantillas/img/llave.png" alt="">&nbsp;&nbsp;En caso de que tenga problemas al ingresar   a su cuenta de estudiante consulte con el Encargado de Sistemas de la Carrera 
                        </div>
                    </div>
                </div>
                                
            </div>
        </div>
        
    </div>

<!-- jQuery -->
<script src="<?= base_url()?>public/js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?= base_url()?>public/js/bootstrap.min.js"></script>

<script >
var baseurl="<?=base_url();?>";
$("#btn_send").click(function(e){
    e.preventDefault();
    $("#show_error").hide();
    habilitar(false);
    $("#btn_send").html('<span  class="fa fa-spinner fa-spin "></span >'); 
    
    $.post(baseurl+"index/login",
            {   codigo:$("#cod_estudiante").val(),
                password:$("#password").val(),            
            }, 
            function(data){
                if(data==='exito')
                 location.href =baseurl+"/main";
                else
                {
                    $("#show_error").show();
                    $("#btn_send").html('Iniciar Sesión'); 
                    habilitar(true);
                    $("#mensaje_error").html('El Código o Contraseña introducidos, no corresponden a un estudiante registrado, verifique sus datos.');
                }
            });
});
function habilitar(parametro)
{
    $("#cod_estudiante").attr('disabled',!parametro);
    $("#password").attr('disabled',!parametro);
    $("#btn_send").attr('disabled',!parametro); 
}

    </script>
</body>

</html>

