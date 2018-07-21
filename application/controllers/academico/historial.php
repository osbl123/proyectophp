<?php



class Historial extends CI_Controller
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
		$sql="SELECT DISTINCT nombre_carrera, pensum.cod_pensum, carrera.orden as orden_carrera, pensum.orden as orden_pensum
				FROM registro_inscripcion
				INNER JOIN pensum ON registro_inscripcion.cod_pensum =  pensum.cod_pensum
				INNER JOIN carrera ON carrera.cod_carrera = pensum.cod_carrera
				WHERE cod_ceta = ".$this->session->userdata('cod_est')."
				ORDER BY carrera.orden ASC, pensum.orden ASC";
		$pensum_estudiante=$this->consultas->consulta_SQL($sql);
		$comunicados=$this->consultas->get_comunicados($this->session->userdata('cod_est'));
		$data= array('fecha'=>$fechaF->FechaFormateada(),'cod_ceta'=> $this->session->userdata('cod_est'),'nombre_est'=> $this->session->userdata('est_namefull'),'onLoad'=>'','comunicados'=>$comunicados);
		$this->load->view("head"); 	
		$this->load->view("nav", $data);
		$data= array('carreras'=>$pensum_estudiante);
		$this->load->view("academico/historial",$data);
		$this->load->view("footer");
	}
	function buscar_historial_academico()
	{	
		$cod_ceta=$this->session->userdata('cod_est');
		$cod_pensum=$_POST['cod_pensum'];

		$cant_inst=0;
		$cant_aprobados=0;
		$cant_reprobados=0;
		$prom_apro=0;
		$prom_repro=0;
		$prom_general=0;
		$alta=0;
		$baja=0;
		$cant_ceros=0;
		$cant_conv=0;
		$cant_arras=0;


		$sql="SELECT Max(parciales) as parciales FROM registro_inscripcion WHERE cod_pensum = '$cod_pensum' AND cod_ceta = $cod_ceta ";
		$get_max_parciales=$this->consultas->consulta_SQL($sql);
		if($get_max_parciales->first_row()->parciales!=null)
			$parciales=$get_max_parciales->first_row()->parciales;
		else
			$parciales=2;


		$sql="SELECT kardex_notas.cod_ceta,primer_parcial,segundo_parcial,tercer_parcial,examen_final,instancia,observacion,kardex_notas.sigla_materia, convalidado, kardex_notas.kardex, parciales, registro_inscripcion.gestion, nivel_materia, nombre_materia, cod_curso 
			FROM kardex_notas
			INNER JOIN registro_inscripcion ON registro_inscripcion.cod_ceta = kardex_notas.cod_ceta AND registro_inscripcion.cod_pensum = kardex_notas.cod_pensum AND registro_inscripcion.cod_inscrip = kardex_notas.cod_inscrip
			INNER JOIN materia ON materia.sigla_materia = kardex_notas.sigla_materia AND materia.cod_pensum = kardex_notas.cod_pensum
			WHERE
			registro_inscripcion.cod_pensum = '$cod_pensum' AND registro_inscripcion.cod_ceta = $cod_ceta AND visible=true
			ORDER BY kardex_notas.cod_inscrip ASC, nivel_materia ASC, orden ASC ";
		$get_kardex=$this->consultas->consulta_SQL($sql);
		
		$cabecera='';
		$resultado='';
		$contador=1;
		$cabecera.='<table width="100%" class="table table-striped table-hover table-bordered table-sm" id="dataTables-historial_academico" style="">';
	        $cabecera.='    <thead>';
	        $cabecera.='         <tr class="table-info" style="font-size:12px">';
	        $cabecera.='            <th width="15">Nº</th>';
	        $cabecera.='            <th width="50">Gestión</th>';
	        $cabecera.='            <th width="50" class="text-center">Semestre</th>';
	        $cabecera.='            <th width="50" nowrap class="text-center">Curso</th>';
	        $cabecera.='            <th width="110" class="text-center">Cod. Asignatura</th>';
	        $cabecera.='            <th >Nombre de Asignatura</th>';
	        $cabecera.='            <th width="52" nowrap>1er P.</th>';
	        $cabecera.='            <th width="52" nowrap>2do P.</th>';
	        			if($parciales==3)
	        $cabecera.='            <th width="52" nowrap>3er P.</th>';

	        			if($parciales==4)
	        			{
	        $cabecera.='            <th width="52" nowrap>3er P.</th>';
	        $cabecera.='            <th width="52" nowrap>4to P.</th>';
	        			}
	        $cabecera.='            <th width="52">Prom.</th>';
	        $cabecera.='            <th width="64" class="text-center">Prueba Recup.</th>';
	        $cabecera.='            <th class="text-center" colspan="2" width="60">Observaciones</th>';
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
					        $resultado.='            <td class="text-center">'.$fila->gestion.'</td>';
					        $resultado.='            <td nowrap="nowrap" >'.$fila->nivel_materia.'</td>';
					        $resultado.='            <td nowrap="nowrap" >'.$fila->cod_curso.'</td>';
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

        $sql="	SELECT count(*) as valor, 'aprobado' as item from kardex_notas where cod_ceta = $cod_ceta and cod_pensum = '$cod_pensum' and observacion = 'Aprobado' UNION
				select count(*) as valor, 'reprobado' as item  from kardex_notas where cod_ceta = $cod_ceta and cod_pensum = '$cod_pensum' and observacion = 'Reprobado' UNION
				select avg(examen_final) as valor, 'prom_aprobado' as item  from kardex_notas where cod_ceta = $cod_ceta and cod_pensum = '$cod_pensum' and observacion = 'Aprobado' UNION
				select avg(examen_final) as valor, 'prom_reprobado' as item  from kardex_notas where cod_ceta = $cod_ceta and cod_pensum = '$cod_pensum' and observacion = 'Reprobado' UNION
				select avg(examen_final) as valor, 'prom_general' as item  from kardex_notas where cod_ceta = $cod_ceta and cod_pensum = '$cod_pensum' UNION
				select max(examen_final) as valor, 'alta' as item  from kardex_notas where cod_ceta = $cod_ceta and cod_pensum = '$cod_pensum' UNION
				select min(examen_final) as valor, 'baja' as item  from kardex_notas where cod_ceta = $cod_ceta and cod_pensum = '$cod_pensum' and examen_final <> 0 UNION
				select count(*) as valor, 'ceros' as item from kardex_notas where cod_ceta = $cod_ceta and cod_pensum = '$cod_pensum' and observacion = 'Reprobado' and examen_final = 0 UNION
				select count(*) as valor, 'convalidados' as item from kardex_notas where cod_ceta = $cod_ceta and cod_pensum = '$cod_pensum' and observacion = 'Convalidado' UNION
				select count(*) as valor, 'arrastres' as item from kardex_notas where cod_ceta = $cod_ceta and cod_pensum = '$cod_pensum' and kardex = 'ARRASTRE' UNION
				select count(*) as valor, 'cantinst' as item from kardex_notas where cod_ceta = $cod_ceta and cod_pensum = '$cod_pensum' and instancia > 0";
		$get_resumen=$this->consultas->consulta_SQL($sql);
		foreach ($get_resumen -> result() as $fila) { 
			if ($fila->item=='aprobado') 
				$cant_aprobados=$fila->valor;
			else
			if ($fila->item=='reprobado') 
				$cant_reprobados=$fila->valor;
			else
			if ($fila->item=='prom_aprobado') 
			{
				if(!is_null($fila->valor))
					$prom_apro=round($fila->valor);
			}
			else
			if ($fila->item=='prom_reprobado') 
			{
				if(!is_null($fila->valor))
					$prom_repro=round($fila->valor);
			}
			else
			if ($fila->item=='prom_general') 
			{
				if(!is_null($fila->valor))
				$prom_general=round($fila->valor);
			}
			else
			if ($fila->item=='alta') 
			{
				if(!is_null($fila->valor))
					$alta=round($fila->valor);
			}
			else
			if ($fila->item=='baja') 
			{
				if(!is_null($fila->valor))
						$baja=round($fila->valor);
			}
			else
			if ($fila->item=='ceros') 
				$cant_ceros=$fila->valor;
			else
			if ($fila->item=='convalidados') 
				$cant_conv=$fila->valor;
			else
			if ($fila->item=='arrastres') 
				$cant_arras=$fila->valor;
			if ($fila->item=='cantinst') 
				$cant_inst=$fila->valor;
		}

        $arrayJS =array('tabla'=>$cabecera.$resultado, 'cant_aprobados'=>$cant_aprobados,'cant_reprobados'=>$cant_reprobados,'prom_apro'=>$prom_apro,'prom_repro'=>$prom_repro,'prom_general'=>$prom_general,'alta'=>$alta,'baja'=>$baja,'cant_ceros'=>$cant_ceros,'cant_conv'=>$cant_conv,'cant_arras'=>$cant_arras,'cant_inst'=>$cant_inst);
    	echo  json_encode($arrayJS);
       // echo $cabecera.$resultado;
	}
}
?>