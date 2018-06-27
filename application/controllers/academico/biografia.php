<?php



class Biografia extends CI_Controller
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
		$get_datos=$this->buscar_inf_estudiante($this->session->userdata('cod_est'));
		$data= array('fecha'=>$fechaF->FechaFormateada(),'cod_ceta'=> $this->session->userdata('cod_est'),'nombre_est'=> $this->session->userdata('est_namefull'),'datos'=>$get_datos,'onLoad'=>'');
		$this->load->view("head"); 	
		$this->load->view("nav", $data);
		$this->load->view("academico/biografia");
		$this->load->view("footer");
	}
	function buscar_inf_estudiante($cod_ceta)
	{		
		$resultado='';
		$today= date('Y-m-d');
		$sql="SELECT estudiante.cod_ceta, ap_paterno ||' '||  ap_materno ||' '|| nombres as nombre, fecha_nacimiento, ciudad, nombre_tutor, direccion, email, telf_fijo, telf_movil, telf_responsable, nombre_doc, numero_doc, procedencia, entregado, matricula FROM estudiante INNER JOIN doc_presentados ON doc_presentados.cod_ceta = estudiante.cod_ceta LEFT JOIN matricula_est ON matricula_est.cod_ceta =estudiante.cod_ceta WHERE estudiante.cod_ceta = $cod_ceta  ORDER BY nombre_doc ASC"; 
		$get_datos_estudiante=$this->consultas->consulta_SQL($sql);
		$contador=0;
		setlocale(LC_TIME, 'es_ES', 'esp_esp');

			if($get_datos_estudiante!=null)
			{
				foreach ($get_datos_estudiante -> result() as $fila) 
				{ 
					if($contador==0)
					{
					$fecha=strftime("%d de %B de %Y",strtotime($fila->fecha_nacimiento));
	 				$fecha=utf8_encode(ucfirst($fecha));
					$resultado.=' <tr >
								    <td class="out-line " width="40%"><strong>Codigo C.E.T.A.:</strong></td>
								    <td class="out-line">'.$fila->cod_ceta.'</td>
								  </tr>
								  <tr >
								    <td class="out-line "><strong>Matrícula:</strong></td>
								    <td class="out-line">'.$fila->matricula.'</td>
								  </tr>	
								  <tr >
								    <td class="out-line "><strong>Estudiante:</strong></td>
								    <td class="out-line">'.$fila->nombre.'</td>
								  </tr>
								  <tr >
								    <td class="out-line "><strong>Padres/Tutores:</strong></td>
								    <td class="out-line">'.$fila->nombre_tutor.'</td>
								  </tr>	
								  <tr >
								    <td class="out-line "><strong>Dirección:</strong></td>
								    <td class="out-line">'.$fila->direccion.'</td>
								  </tr>	
								  <tr >
								    <td class="out-line "><strong>Teléfonos:</strong></td>
								    <td class="out-line">Fijo:'.$fila->telf_fijo.' - Celular:'.$fila->telf_movil.' - Ref:'.$fila->telf_responsable.'</td>
								  </tr>	
								  <tr >
								    <td class="out-line "><strong>Fecha de Nacimiento:</strong></td>
								    <td class="out-line">'.$fecha.'</td>
								  </tr>	
								  <tr >
								    <td class="out-line "><strong>Lugar de Nacimiento:</strong></td>
								    <td class="out-line">'.$fila->ciudad.'</td>
								  </tr>	
								  <tr >
								    <td class="out-line "><strong>Correo Electrónico:</strong></td>
								    <td class="out-line">'.$fila->email.'</td>
								  </tr>';

					}
					if($fila->nombre_doc=='Carnet de identidad')
					{
						$resultado.='<tr >
									    <td class="out-line "><strong>Número CI:</strong></td>
									    <td class="out-line">'.$fila->numero_doc.'</td>
									  </tr>	
									  <tr >
									    <td class="out-line "><strong>Procedencia CI:</strong></td>
									    <td class="out-line">'.$fila->procedencia.'</td>
									  </tr>';
					}
					if($fila->nombre_doc=='Titulo de bachiller')
					{
						if($fila->procedencia=='No tiene')
							$diploma='No tiene - Capacitación';
						else
						if($fila->procedencia=='En trámite')
							$diploma='No entregó';
						else
							$diploma=$fila->numero_doc;
						$resultado.='<tr >
									    <td class="out-line "><strong>Diploma de Bachiller:</strong></td>
									    <td class="out-line">'.$diploma.'</td>
									  </tr>';
					}					
			        $contador++;
	    		}
			}
		return $resultado;
	}	
}
?>