<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CETA Admin - Administrador de Contenidos</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url()?>plantillas/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?= base_url()?>plantillas/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= base_url()?>plantillas/vendor/dist/css/sb-admin-2.css" rel="stylesheet">
    <link rel="icon" type="image/gif" href="<?=base_url()?>plantillas/img/favicon.ico">

    <!-- Custom Fonts -->
    <!-- <link href="<?= base_url()?>plantillas/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div class="container" >
        <div class="col-md-4 col-md-offset-4 " align="center" >
        <img src="<?= base_url()?>plantillas/img/logo.png">        
        </div> 
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <?php                
                    if(($n_user!='')&&($habilitado==''))
                    {
                        echo '<div class="alert alert-danger">Nombre de usuario o contraseña incorrectos...</div>';
                    }
                    if(($n_user!='')&&($habilitado=='false'))
                    {
                        echo '<div class="alert alert-danger">Su cuenta se encuentra deshabilitada. Por favor comuníquese con el Administrador para poder habilitarle su cuenta.</div>';
                    }
                ?>
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Por favor Identifíquese</h3>
                    </div>
                    
                    <div class="panel-body">
                       
                        <?php echo form_open("",array("id" =>"login_form")); ?>
                            <fieldset>
                                <div class="form-group">
                                    <div class="input-group"> 
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input class="form-control" placeholder="Usuario" name="n_user" type="text" autofocus value="<?= $n_user; ?>" required>
                                    </div>
                                </div>
                                <h6 class="text-danger"><p><?= form_error('n_user');?></p></h6>
                                <div class="form-group">
                                    <div class="input-group"> 
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                        <input class="form-control" placeholder="Contraseña" name="contrasenia" type="password" value="" required>
                                    </div>
                                </div>                                
                                <input type="submit" value="Iniciar Sesión" id="bt_form" class="btn btn-primary btn-block">
                            </fieldset>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?= base_url()?>plantillas/js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url()?>plantillas/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?= base_url()?>plantillas/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?= base_url()?>plantillas/vendor/dist/js/sb-admin-2.js"></script>

</body>

</html>
