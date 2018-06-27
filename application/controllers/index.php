<?php



class Index extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Fechas');
	}

	public function index()
	{
		if($this->session->userdata('cod_est'))
		{
			redirect('main');
		}
		$this->load->view("index");
	}
	public function login()
	{
		$codigo=$_POST['codigo'];
		$password=$_POST['password'];
		$get_estudiante=$this->consultas->login_est($codigo,$password);
		if($get_estudiante!='')
		{
			$this->session->set_userdata('est_namefull',$get_estudiante);				
			$this->session->set_userdata('cod_est',$codigo);				
			echo 'exito';
		}
		else
			echo 'error';
		
	}	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('index');
	}
}
?>