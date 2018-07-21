
<!DOCTYPE html>
<html lang="sp">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="descripcion" content="Sistema de Información Estudiantil">
    <meta name="author" content="Ing. Bradley Jaillita B.">
    
    <title>Sistema SGA C.E.T.A.</title>
    
    <!-- jQuery -->
    <script src="<?= base_url()?>plantillas/js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url()?>plantillas/js/bootstrap.min.js"></script>
    <!-- <script src="<?= base_url()?>plantillas/js/autoscroll.min.js"></script> -->
    <script type="text/javascript" src="<?= base_url()?>plantillas/js/autoscroll.min.js"></script>

    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url()?>plantillas/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url()?>plantillas/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="<?= base_url()?>plantillas/css/estilos.css" rel="stylesheet" type="text/css">

    <link rel="icon" type="image/gif" href="<?=base_url()?>plantilla/img/favicon.gif">
<script type="text/javascript">
var Hoy = new Date("<?php echo date('d M Y G:i:s'); ?>");
function Reloj(){ 
    Hora = Hoy.getHours() ;
    Minutos = Hoy.getMinutes() ;
    Segundos = Hoy.getSeconds() ;
    if (Hora<=9) Hora = "0" + Hora ;
    if (Minutos<=9) Minutos = "0" + Minutos ;
    if (Segundos<=9) Segundos = "0" + Segundos ;
    var Dia = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"); 
    var Mes = new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
    var Anio = Hoy.getFullYear(); 
    var Fecha = Dia[Hoy.getDay()] + ", " + Hoy.getDate() + " de " + Mes[Hoy.getMonth()] + " de " + Anio + ", a las "; 
    var Script, Total ;
    
    Script = Hora + ":" + Minutos + ":" + Segundos ;
     
    Total = Script ;
    document.getElementById('Reloj').innerHTML = Total ;
    Hoy.setSeconds(Hoy.getSeconds() +1);
} 
    setInterval("Reloj()",1000) ;
</script>

</head>