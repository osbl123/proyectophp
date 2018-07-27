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
        $cod_ceta = $this->session->userdata('cod_est');
        $comunicados=$this->consultas->get_comunicados($cod_ceta);

		$fechaF = new Fechas();
        $data= array(
            'fecha'=>$fechaF->FechaFormateada()
            ,'cod_ceta'=> $this->session->userdata('cod_est')
            ,'nombre_est'=> $this->session->userdata('est_namefull')
            ,'onLoad'=>''
            ,'articulos'=>$this->consultas->get_list_post($cod_ceta)
            ,'comunicados'=>$comunicados
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
        $comunicados=$this->consultas->get_comunicados($this->session->userdata('cod_est'));

        $fechaF = new Fechas();
        $post = $this->consultas->get_post($enlace);
        $autores = $this->consultas->get_post_autor($post->id_post);
        $data= array(
            'fecha'=>$fechaF->FechaFormateada()
            ,'cod_ceta'=> $this->session->userdata('cod_est')
            ,'nombre_est'=> $this->session->userdata('est_namefull')
            ,'onLoad'=>''
            ,'detalle'=>$post
            ,'docente'=> $autores->autor
            ,'comunicados'=>$comunicados
        );

        $this->load->view("head",$data); 	
		$this->load->view("nav");
		$this->load->view("post");
		$this->load->view("footer");
    }

    public function add_comment() {
        $data = array (
            'id_entrada' => $this->input->post('id_entrada'),
            'autor' => $this->input->post('autor'),
            'contenido' => $this->input->post('contenido'),
            'fecha' => date('Y:m:d'),
            'id_respuesta' => $this->input->post('id_respuesta')
        );
        $this->consultas->insert('comentario',$data);
    }
}
