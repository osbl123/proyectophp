<?php



class Main extends CI_Controller
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
		$this->load->view("main");
		$this->load->view("footer");
	}	
}
?>