<?php



class Nota_semestral extends CI_Controller
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
		$comunicados=$this->consultas->get_comunicados($this->session->userdata('cod_est'));
		$data= array('fecha'=>$fechaF->FechaFormateada(),'cod_ceta'=> $this->session->userdata('cod_est'),'nombre_est'=> $this->session->userdata('est_namefull'),'onLoad'=>$onload,'comunicados'=>$comunicados);
		$this->load->view("head"); 	
		$this->load->view("nav", $data);
		$data= array('carreras'=>$pensum_estudiante);
		$this->load->view("academico/nota_semestral",$data);
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
		$constrol='';
		$resultado='';
		if(!is_null($gestion_estudiante))
			foreach ($gestion_estudiante -> result() as $fila) 
	            if($control!=$fila->gestion)
				{
	            	$resultado.='<option value="'.$fila->gestion.'">'.$fila->gestion.'</option>';
	            	$control=$fila->gestion	;
	        	}
		echo $resultado;
	}
	
	function get_notas_semestre()
	{
		$cod_ceta=$_POST['cod_ceta'];
		$cod_pensum=$_POST['cod_pensum'];
		$gestion=$_POST['gestion'];		
		$sql="SELECT Max(parciales) as parciales FROM registro_inscripcion WHERE cod_pensum = '$cod_pensum' AND cod_ceta = $cod_ceta AND gestion = '$gestion' ";
		$get_max_parciales=$this->consultas->consulta_SQL($sql);
		if($get_max_parciales->first_row()->parciales!=null)
			$parciales=$get_max_parciales->first_row()->parciales;
		else
			$parciales=2;



		$sql="SELECT kardex, primer_parcial, segundo_parcial, tercer_parcial, examen_final, instancia, observacion, kardex_notas.sigla_materia, convalidado, registro_inscripcion.parciales, materia.nombre_materia, materia.nivel_materia FROM registro_inscripcion INNER JOIN kardex_notas ON kardex_notas.cod_ceta = registro_inscripcion.cod_ceta AND kardex_notas.cod_pensum = registro_inscripcion.cod_pensum AND kardex_notas.cod_inscrip = registro_inscripcion.cod_inscrip INNER JOIN materia ON materia.sigla_materia = kardex_notas.sigla_materia AND materia.cod_pensum = kardex_notas.cod_pensum WHERE registro_inscripcion.gestion = '$gestion' AND registro_inscripcion.cod_ceta = $cod_ceta AND registro_inscripcion.cod_pensum = '$cod_pensum' AND visible=TRUE ORDER BY registro_inscripcion.cod_inscrip ASC, cod_kardex ASC "; 
		$get_kardex=$this->consultas->consulta_SQL($sql);
		
		$cabecera='';
		$resultado='';
		$contador=1;
		$cabecera.='<table width="100%" class="table table-striped table-hover table-bordered table-sm" id="dataTables-notas_semestre">';
	        $cabecera.='    <thead>';
	        $cabecera.='         <tr class="table-info" style="font-size:14px">';
	        $cabecera.='            <th width="15">Nº</th>';
	        $cabecera.='            <th width="100">Semestre</th>';
	        $cabecera.='            <th width="80" nowrap>Código</th>';
	        $cabecera.='            <th class="text-center" >Asignatura</th>';
	        $cabecera.='            <th width="55">1er P.</th>';
	        $cabecera.='            <th width="55">2do P.</th>';
	        			if($parciales==3)
	        $cabecera.='            <th width="55">3er P.</th>';

	        			if($parciales==4)
	        			{
	        $cabecera.='            <th width="55">3er P.</th>';
	        $cabecera.='            <th width="55">4to P.</th>';
	        			}
	        $cabecera.='            <th width="55">Prom.</th>';
	        $cabecera.='            <th width="64" class="text-center">Prueba Recup.</th>';
	        $cabecera.='            <th class="text-center" colspan="2" width="80">Observaciones</th>';
	        $cabecera.='        </tr>';
	        $cabecera.='    </thead>';
	        $cabecera.='    <tbody >';
            	
            		if(!is_null($get_kardex))
            		{
    					foreach ($get_kardex -> result() as $fila) { 
    						$obs_aux='';
    						if($fila->kardex=='ARRASTRE')
    							$obs_aux='A';
    						if($fila->convalidado=='convalidado')
    							$obs_aux='C';
    						if($fila->convalidado=='homologado')
    							$obs_aux='H';



							if($parciales<$fila->parciales)
					        	$parciales=$fila->parciales;

					        $resultado.='			<tr class="small">';
					        $resultado.='            <td class="text-center">'.$contador.'</td>';
					        $resultado.='            <td nowrap="nowrap" >'.$fila->nivel_materia.'</td>';
					        $resultado.='            <td nowrap="nowrap" class="text-center">'.$fila->sigla_materia.'</td>';
					        $resultado.='            <td nowrap="nowrap" >'.$fila->nombre_materia.'</td>';
					        $resultado.='            <td class="text-center">'.$fila->primer_parcial.'</td>';
					        $resultado.='            <td class="text-center">'.$fila->segundo_parcial.'</td>';
					        if($parciales==3)
					        {
					        	if($fila->parciales==$parciales)
					        	$resultado.='            <td class="text-center">'.$fila->tercer_parcial.'</td>';
					        	else
					        	$resultado.='            <td class="text-center"></td>';

					        }
					        if($parciales==4)
					        {
					        	if($fila->parciales==$parciales)
						        {
						        	$resultado.='            <td class="text-center">'.$fila->tercer_parcial.'</td>';
						        	$resultado.='            <td class="text-center">'.$fila->cuarto_parcial.'</td>';
						        }
						        else
						        {
						        	$resultado.='            <td class="text-center">'.$fila->tercer_parcial.'</td>';
						        	$resultado.='            <td class="text-center">'.$fila->cuarto_parcial.'</td>';
						        }
					    	}
					        $resultado.='            <td class="text-center">'.round($fila->examen_final).'</td>';
					        $resultado.='            <td class="text-center">'.$fila->instancia.'</td>';
					        $resultado.='            <td class="text-center">'.$fila->observacion.'</td>';
					        $resultado.='            <td class="text-center">'.$obs_aux.'</td>';
					        $resultado.='        </tr>';
					        $contador++;
					        
	            		}
            		}
            	
        $resultado.='    </tbody>';
        $resultado.='</table>';
        echo $cabecera.$resultado;
	}
	
}
?>