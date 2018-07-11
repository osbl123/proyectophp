<?php

class Blog extends CI_Controller {
    function __construct()
	{
		parent::__construct();
		$this->load->library('Fechas');
	}


    public function index() {
        if(!$this->session->userdata('cod_est'))
		{
			redirect(base_url().'index');
		}

		$fechaF = new Fechas();
        $data= array(
            'fecha'=>$fechaF->FechaFormateada()
            ,'cod_ceta'=> $this->session->userdata('cod_est')
            ,'nombre_est'=> $this->session->userdata('est_namefull')
            ,'onLoad'=>''
            ,'articulos'=>$this->consultas->get_list_post()
        );
        

		$this->load->view("head",$data); 	
		$this->load->view("nav");
		$this->load->view("list_post");
		$this->load->view("footer");
    }

    public function detail($enlace) {
        if(!$this->session->userdata('cod_est'))
		{
			redirect(base_url().'index');
		}

        $fechaF = new Fechas();
        $post = $this->consultas->get_post($enlace);
        $data= array(
            'fecha'=>$fechaF->FechaFormateada()
            ,'cod_ceta'=> $this->session->userdata('cod_est')
            ,'nombre_est'=> $this->session->userdata('est_namefull')
            ,'onLoad'=>''
            ,'detalle'=>$post
            ,'docente'=>$this->consultas->get_docente($post->cod_docente)
        );

        $this->load->view("head",$data); 	
		$this->load->view("nav");
		$this->load->view("post");
		$this->load->view("footer");
    }
}
