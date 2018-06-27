<?php



class Evaluacion extends CI_Controller
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
		$onload='onload="get_gestion();"';
		$fechaF = new Fechas();
		$pensum_estudiante=$this->get_carreras($this->session->userdata('cod_est'));
		$data= array('fecha'=>$fechaF->FechaFormateada(),'cod_ceta'=> $this->session->userdata('cod_est'),'nombre_est'=> $this->session->userdata('est_namefull'),'onLoad'=>$onload);
		$this->load->view("head"); 	
		$this->load->view("nav", $data);
		$data= array('carreras'=>$pensum_estudiante);
		$this->load->view("academico/evaluacion",$data);
		$this->load->view("footer");
	}
	public function get_carreras($cod_ceta)
	{
		$sql="SELECT DISTINCT nombre_carrera, pensum.cod_pensum, carrera.orden as orden_carrera, pensum.orden as orden_pensum
				FROM registro_inscripcion
				INNER JOIN pensum ON registro_inscripcion.cod_pensum =  pensum.cod_pensum
				INNER JOIN carrera ON carrera.cod_carrera = pensum.cod_carrera
				WHERE cod_ceta = $cod_ceta
				ORDER BY carrera.orden ASC, pensum.orden ASC";
		$pensum_estudiante=$this->consultas->consulta_SQL($sql);
		return $pensum_estudiante;
	}
	public function get_gestion()
	{
		$cod_ceta=$_POST['cod_ceta'];
		$cod_pensum=$_POST['cod_pensum'];
		$sql="SELECT DISTINCT gestion, cod_inscrip FROM registro_inscripcion WHERE cod_ceta = $cod_ceta and cod_pensum = '$cod_pensum' order by cod_inscrip desc";
		$gestion_estudiante=$this->consultas->consulta_SQL($sql);
		$control='';
		$resultado='';
		if(!is_null($gestion_estudiante))
			foreach ($gestion_estudiante -> result() as $fila) 
			{	
				if($control!=$fila->gestion)
				{
	            	$resultado.='<option value="'.$fila->gestion.'">'.$fila->gestion.'</option>';
	            	$control=$fila->gestion	;
	        	}
			}
		echo $resultado;
	}
	
	function get_evaluacion()
	{
		$cod_ceta=$_POST['cod_ceta'];
		$cod_pensum=$_POST['cod_pensum'];
		$gestion=$_POST['gestion'];		
		$parametro=$_POST['parametro'];		
		$resultado='';
		$sql="SELECT cod_curso, cod_inscrip, tipo_inscripcion FROM registro_inscripcion WHERE cod_ceta = $cod_ceta AND cod_pensum = '$cod_pensum' AND gestion = '$gestion' ORDER BY cod_inscrip";
		$get_curso=$this->consultas->consulta_SQL($sql);
		if(!is_null($get_curso))
		{
			foreach ($get_curso -> result() as $fila) 
			if($fila->tipo_inscripcion!='ARRASTRE')
			{ 
				$curso=$fila->cod_curso;				
				$sql="SELECT cronograma.sigla_materia, fecha, hora, aula, nombre_materia FROM cronograma INNER JOIN materia ON materia. sigla_materia = cronograma.sigla_materia AND materia.cod_pensum = cronograma.cod_pensum WHERE gestion = '$gestion' AND evaluacion = '$parametro' AND grupo = '$curso' ORDER BY fecha ASC, hora ASC";
				$get_horario_evaluacion=$this->consultas->consulta_SQL($sql);
				if(!is_null($get_horario_evaluacion))
            	{
            		$resultado.='	<table width="100%" class="table table-striped table-hover table-bordered table-sm">';
			        $resultado.='    	<thead>';
			        $resultado.='       <tr class="table-success">';
			        $resultado.='       	<th class="text-center">Nº</th>';
			        $resultado.='       	<th class="text-center">Materia</th>';
			        $resultado.='       	<th class="text-center">Sigla</th>';
			        $resultado.='       	<th class="text-center">Fecha</th>';
			        $resultado.='       	<th class="text-center">Hora</th>';
			        $resultado.='       	<th class="text-center">Aula</th>';
			        $resultado.='       </tr>';
			        $resultado.='    	</thead>';
		        	$resultado.='    	<tbody>';	
					$contador=1;
					foreach ($get_horario_evaluacion -> result() as $horario) { 
						$resultado.='			<tr class="small">';
				        $resultado.='            <td class="text-center">'.$contador.'</td>';
				        $resultado.='            <td class="text-center">'.$horario->nombre_materia.'</td>';
				        $resultado.='            <td class="text-center">'.$horario->sigla_materia.'</td>';
				        $resultado.='            <td class="text-center">'.$horario->fecha.'</td>';
				        $resultado.='            <td class="text-center">'.$horario->hora.'</td>';
				        $resultado.='            <td class="text-center">'.$horario->aula.'</td>';
					    $resultado.='       	</tr>';
					    $contador++;

					}
					$resultado.='    	</tbody>';
				    $resultado.='	</table>';
            	}
            	else
         			$resultado.='<div class="alert alert-warning" role="alert"><center>No existe fechas programadas para la evaluación seleccionada.</center></div>';   		
			}
			else
			$resultado.='<div class="alert alert-info" role="alert"><center>El horario de Evaluación de las Materias de Nivelación o Arrastre deben ser consultadas en Administración.</center></div>';		
		}
		else
		{
			$resultado='<div class="alert alert-danger" role="alert"><center>No existe fechas registradas para la evaluación seleccionada.</center></div>';
		}		
        echo $resultado;
	}
	
}
?>