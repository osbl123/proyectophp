<?php
class Comunicados extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		if(!$this->session->userdata('username'))
		{
			redirect(base_url().'admin');
		}
		$usuario=$this->session->userdata('username');
		$data= array('titulo'=> 'Bienvenido');
		$this->load->view("administrador/head",$data);
		$data= array('user'=> $usuario);
		$this->load->view("administrador/nav", $data);
		$this->load->view("administrador/comunicados");
		$this->load->view("administrador/footer");
	}	
}
?>