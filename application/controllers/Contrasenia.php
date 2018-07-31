<?php

class Contrasenia extends CI_Controller
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
		$comunicados=$this->consultas->get_comunicados($this->session->userdata('cod_est'));
		$data= array('fecha'=>$fechaF->FechaFormateada(),'cod_ceta'=> $this->session->userdata('cod_est'),'nombre_est'=> $this->session->userdata('est_namefull'),'onLoad'=>'','comunicados'=>$comunicados);
		$this->load->view("head"); 	
		$this->load->view("nav", $data);
		$this->load->view("contrasenia");
		$this->load->view("footer");
	}
	public function login()
	{
		$codigo=$_POST['codigo'];
		$password=$_POST['password'];
		$get_estudiante=$this->consultas->login_est($codigo,$password);
		if($get_estudiante!='')
		{					
			echo 'exito';
		}
		else
			echo 'error';		
	}
	public function get_datos()
	{
		echo $get_datos=$this->buscar_inf_estudiante($this->session->userdata('cod_est'));
		# code...
	}
	public function update_password()
	{
		$codigo=$_POST['codigo'];
		$password=$_POST['password1'];
		$where =array(
						'cod_ceta'=>$codigo,						
						);
		$data =array(
			'password' =>md5($password),
		);
		if($this->consultas->update_table('est_password',$data,$where))
			echo 'exito';
		else
			echo 'error';

	}
	function buscar_inf_estudiante($cod_ceta)
	{		
		$resultado=' <form>
					  <div class="form-group row">
					    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
					    <div class="col-sm-10">
					      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
					    <div class="col-sm-10">
					      <input type="password" class="form-control" id="inputPassword" placeholder="Password">
					    </div>
					  </div>
					</form>';



			
		return $resultado;
	}	
}
?>