<?php



class Horario_clases extends CI_Controller
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
		$this->load->view("academico/horario_clases",$data);
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
	
	function get_horario()
	{
		$cod_ceta=$_POST['cod_ceta'];
		$cod_pensum=$_POST['cod_pensum'];
		$gestion=$_POST['gestion'];		
		$resultado='';
		$sql="SELECT cod_curso, cod_inscrip, tipo_inscripcion FROM registro_inscripcion WHERE cod_ceta = $cod_ceta AND cod_pensum = '$cod_pensum' AND gestion = '$gestion' ORDER BY cod_inscrip";
		$get_curso=$this->consultas->consulta_SQL($sql);
		if(!is_null($get_curso))
		{
			foreach ($get_curso -> result() as $fila) 
			if($fila->tipo_inscripcion!='ARRASTRE')
			{ 
				$curso=$fila->cod_curso;
				$lu1=""; $Ma1=""; $Mi1=""; $Ju1=""; $Vi1=""; 
				$lud1=""; $Mad1=""; $Mid1=""; $Jud1=""; $Vid1="";
				$lu2=""; $Ma2=""; $Mi2=""; $Ju2=""; $Vi2="";
				$lud2=""; $Mad2=""; $Mid2=""; $Jud2="";$Vid2="";
				$p1="";	$p2="";
				$aula="";
				$sql="SELECT cod_grupo, hora_inicio, hora_fin, aula, dia, nombre_materia, nombre_corto,
						CASE WHEN dia='Lunes' THEN 1
            				 WHEN dia='Martes' THEN 2
							 WHEN dia='Miercoles' THEN 3
							 WHEN dia='Jueves' THEN 4
							 WHEN dia='Viernes' THEN 5
	            			 ELSE 0
       						 END AS orden
						FROM
						asignacion_docente
						INNER JOIN materia ON materia.sigla_materia = asignacion_docente.sigla_materia AND materia.cod_pensum = asignacion_docente.cod_pensum
						INNER JOIN docente ON docente.cod_docente = asignacion_docente.cod_docente
						WHERE
						gestion = '$gestion' AND cod_grupo = '$curso' AND asignacion_docente.cod_pensum='$cod_pensum' ORDER BY orden, hora_inicio ";
				$get_horario_clases=$this->consultas->consulta_SQL($sql);
				if(!is_null($get_horario_clases))
            	{
					foreach ($get_horario_clases -> result() as $horario) { 
						$aula=$horario->aula;
						if ($horario->dia=='Lunes') 
						{
							if ($lu1=="")
							{$lu1=$horario->nombre_materia; $lud1=$horario->nombre_corto; $p1=$horario->hora_inicio.' - '.$horario->hora_fin;}
							 else
							 {$lu2=$horario->nombre_materia; $lud2=$horario->nombre_corto;  $p2=$horario->hora_inicio.' - '.$horario->hora_fin;}
						}
						if ($horario->dia=='Martes') 
						{
							if ($Ma1=="")
							{$Ma1=$horario->nombre_materia; $Mad1=$horario->nombre_corto;}
							 else
							 {$Ma2=$horario->nombre_materia; $Mad2=$horario->nombre_corto;}
						}
						if ($horario->dia=='Miercoles') 
						{
							if ($Mi1=="")
							{$Mi1=$horario->nombre_materia; $Mid1=$horario->nombre_corto;}
							 else
							 {$Mi2=$horario->nombre_materia; $Mid2=$horario->nombre_corto;}
						}
						if ($horario->dia=='Jueves') 
						{
							if ($Ju1=="")
							{$Ju1=$horario->nombre_materia; $Jud1=$horario->nombre_corto;}
							 else
							 {$Ju2=$horario->nombre_materia; $Jud2=$horario->nombre_corto;}
						}
						if ($horario->dia=='Viernes') 
						{
							if ($Vi1=="")
							{$Vi1=$horario->nombre_materia; $Vid1=$horario->nombre_corto;}
							 else
							 {$Vi2=$horario->nombre_materia; $Vid2=$horario->nombre_corto;}
						}											
					}

					$resultado.='<div  style="padding-bottom: 5px;">';
					$resultado.='<table width="100%" border="1" align="center">';
                	$resultado.='	<tr>';
                    $resultado.='        <th width="10%" class="text-center" bgcolor="#000000"><font color="#FFFFFF">'.$curso.'</font></th>';
                    $resultado.='        <th colspan="5" class="text-center" bgcolor="#FF6633" >AULA "'.$aula.'"</th>';
                    $resultado.='  	</tr>';
                    $resultado.='    	<tr align="center" bgcolor="#ffc107">';
		            $resultado.='        	 <th>HORA</th>';
                    $resultado.='            <th width="18%">LUNES</th>';
                    $resultado.='            <th width="18%">MARTES</th>';
                    $resultado.='            <th width="18%">MIERCOLES</th>';
                    $resultado.='            <th width="18%">JUEVES</th>';
                    $resultado.='            <th width="18%">VIERNES</th>';
                    $resultado.='        </tr>';
                        $resultado.='    <tr align="center">';
                        $resultado.='        <th bgcolor="#CCFFFF">'.$p1.'</th>';
                        $resultado.='        <td>'.$lu1.'</td><td>'.$Ma1.'</td><td>'.$Mi1.'</td><td>'.$Ju1.'</td><td>'.$Vi1.'</td>';
                        $resultado.='    </tr>';
                        $resultado.='    <tr align="center">';
                        $resultado.='        <th bgcolor="#CCFFFF"> DOCENTE</th>';
                        $resultado.='        <td>'.$lud1.'</td><td>'.$Mad1.'</td><td>'.$Mid1.'</td><td>'.$Jud1.'</td><td>'.$Vid1.'</td>';
                        $resultado.='    </tr>';
                        $resultado.='     <tr class="verdana" align="center">';
                        $resultado.='         <td></td>';
                        $resultado.='        <td colspan="5" bgcolor="#66CC00">DESCANSO</td>';
                        $resultado.='    </tr>';
                        $resultado.='    <tr class="verdana" align="center">';
                        $resultado.='        <th bgcolor="#CCFFFF">'.$p2.'</th>';
                        $resultado.='        <td>'.$lu2.'</td><td>'.$Ma2.'</td><td>'.$Mi2.'</td><td>'.$Ju2.'</td><td>'.$Vi2.'</td>';
                        $resultado.='    </tr>';
                        $resultado.='    <tr class="verdana" align="center">';
                        $resultado.='        <th bgcolor="#CCFFFF"> DOCENTE</th>';
                        $resultado.='        <td>'.$lud2.'</td><td>'.$Mad2.'</td><td>'.$Mid2.'</td><td>'.$Jud2.'</td><td>'.$Vid2.'</td>';
                        $resultado.='    </tr>';
                    $resultado.='</table></div>';
            	}
            	else
         			$resultado.='<div class="alert alert-warning" role="alert"><center>No existe un horario asignado para el curso <strong>'.$curso.'</strong>.</center></div>';   		
			}
			else
			$resultado.='<div class="alert alert-info" role="alert"><center>El horario de las Materias de Nivelación o Arrastre deben ser consultadas en Administración.</center></div>';		
		}
		else
		{
			$resultado='<div class="alert alert-danger" role="alert"><center>No está registrado en ningún curso en la Gestión seleccionada. Comuníquese con el Administrador.</center></div>';
		}		
        echo $resultado;
	}
	
}
?>