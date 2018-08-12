<?php



class Material_academico extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Fechas');
	}

	public function index()
	{
		if(!$this->session->userdata('cod_est'))
		{
			redirect(base_url().'index');
		}

		$fechaF = new Fechas();
		$get_datos=$this->buscar_material($this->session->userdata('cod_est'));
		$comunicados=$this->consultas->get_comunicados($this->session->userdata('cod_est'));
		$data= array('fecha'=>$fechaF->FechaFormateada(),'cod_ceta'=> $this->session->userdata('cod_est'),'nombre_est'=> $this->session->userdata('est_namefull'),'datos'=>$get_datos,'onLoad'=>'','comunicados'=>$comunicados);
		$this->load->view("head"); 	
		$this->load->view("nav", $data);
		$this->load->view("academico/material_academico");
		$this->load->view("footer");
	}
	function buscar_material($cod_ceta)
	{		
		$resultado='';
		$get_cursos=$this->consultas->get_curso_est($cod_ceta);
		if($get_cursos!=null)
		{
			foreach ($get_cursos->result() as $fila) 
			{ 
				$get_material=$this->consultas->get_material($fila->cod_curso,$fila->cod_pensum,$fila->gestion);
				if($get_material!=null)
				{
					foreach ($get_material->result() as $row) 
					{ 
						$url_download=str_replace('proyectophp/','',base_url()).'admin/plantillas/archivos/';
						$fecha_nueva= explode("-", $row->fecha);
                		$fecha=$fecha_nueva[2].'/'.$fecha_nueva[1].'/'.$fecha_nueva[0];
                
						if($row->nom_archivo=='')
							$url='';
						else
							$url='<strong>Archivo adjunto: </strong>'.$row->nom_archivo.' <a href="'.$url_download.$row->nom_archivo.'" class="btn btn-success btn-sm" role="button" target="_blank"><span class="fa fa-download"></span></a>';
						$resultado.='<div class="col-md">        
				          <div class="card ">
				            <div class="card-body">
				              <h4 class="card-title">'.$row->titulo.'</h4>
				              <p class="card-text">
				              	<strong>Materia: </strong>'.$row->cod_materia.' '.$row->nombre_materia.'<br>
				              	<strong>Docente: </strong>'.$row->nom_docente.'<br>
				              	<strong>Fecha de publicación: </strong>'.$fecha.'<br>
				              	<strong>Descripción: </strong>'.$row->contenido.'<br>'.$url.'
				              </p>
				              
				            </div>
				          </div>          
				      </div>';
		    		}
				}
    		}
		}
		if($resultado=='')
			$resultado='<div class="alert alert-info text-center">
  <strong>Atención: </strong> No existe material publicado
</div>';
		return $resultado;
	}	
}
?>