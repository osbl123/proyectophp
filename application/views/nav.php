<body <?=$onLoad;?> >
    <div style="background-image: url(<?=base_url();?>plantillas/img/header.png); background-repeat: no-repeat; height: 100px; background-color: #2727C7; justify-content: flex-end; ">       
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-blueceta" >
      <a class="navbar-brand mb-0 h1 text-white" href="<?= base_url()?>main">SGA CETA - Estudiantes</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon text-white"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-md-end" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link " href="<?= base_url()?>academico/biografia">Biografía</a>
          </li>
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Inf. Académica
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?= base_url()?>academico/historial">Historial Académico</a>
              <a class="dropdown-item" href="<?= base_url()?>academico/nota_semestral">Kardex Semestralizado</a>
             <!--  <a class="dropdown-item" href="<?= base_url()?>academico/horario_clases">Horario de clases</a>
              <a class="dropdown-item" href="<?= base_url()?>academico/evaluacion">Horario de evaluaciones</a> -->
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Horario
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?= base_url()?>academico/horario_clases">Horario de clases</a>
              <a class="dropdown-item" href="<?= base_url()?>academico/evaluacion">Horario de evaluaciones</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Material de Apoyo
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">TEMA 1</a>
              <a class="dropdown-item" href="#">Tema 2</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Tema 3</a>
            </div>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="<?=site_url('publicaciones/pagina/')?>"><i class="fa ti-notepad"></i> Blog</a>
          </li>          
         <!--  <li class="nav-item ">
            <a class="nav-link dropdown-toggle " href="<?= base_url()?>perfil">
              Modificar perfil
            </a>
          </li> -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-fw"></i>
              <?= $nombre_est;?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?= base_url()?>perfil/perfil">Modificar Perfil</a>
              <a class="dropdown-item" href="<?= base_url()?>perfil/contrasenia">Modificar Contraseña</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?=site_url('index/logout')?>">Salir</a>
            </div>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="<?=site_url('index/logout')?>"><i class="fa fa-user fa-fw"></i> Salir</a>
          </li> -->
        </ul>        
      </div>
    </nav>
<main role="main" class="bar_state">
<div class="row text-white bg-redceta" style="padding-right: 50px;">
    <div class="col col-md-auto"><strong>Estudiante: </strong><?= $nombre_est;?></div>
    <div class="col col-md-auto"><strong>Codigo CETA: </strong><span id="cod_ceta"><?= $cod_ceta;?></span></div>
    <div class="col col-md-auto"><strong>Carrera: </strong>Electricidad y Electrónica Automotriz</div>
    <div class="col col-md-auto" ><img src="<?= base_url()?>plantillas/img/watch2.png" width="32" height="32"><span id="Reloj"></span></div>
    <div class="col col-md-auto"><span id="Fecha"> <?= $fecha;?></span></div> 
</div>    
</main>
<main role="main" class="container">    
  <div class="row">   
      <div class="col col-md-9 col-sm-12 col-12 sombra_div">  


            