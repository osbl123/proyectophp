<?php

class Blog extends CI_Controller {
    function __construct()
	{
		parent::__construct();
        $this->load->library('Fechas');
        $this->load->helper('date');
	}


    public function index($page = FALSE) {
        if(!$this->session->userdata('cod_est'))
		{
			redirect(base_url().'index');
        }

        $cod_ceta = $this->session->userdata('cod_est');
        $comunicados = $this->consultas->get_comunicados($cod_ceta);
/*
        $config['base_url'] = base_url() . 'publicaciones/pagina/';
        $config['total_rows'] =$this->consultas->count_list_post($cod_ceta);//Numero total de filas
        $config['per_page'] = $limite;//Numero de entradas por pagina
        $config['use_page_numbers'] = TRUE;
        //$config['first_url'] = $config['base_url'];
        $config['num_links'] = 3; //permite configurar el numero de  enlaces que se muetra

        
        // $config['first_link'] = 'Primero';
        // $config['last_link'] = 'Ultimo';
        // $config['next_link'] = '&gt;';
        // $config['prev_link'] = '&lt;';

        $config['full_tag_open'] = '<ul class="paginador">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open']  = '<li>';
        $config['cur_tag_close']  = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
*/
		$fechaF = new Fechas();
        $data= array(
            'fecha'=>$fechaF->FechaFormateada()
            ,'cod_ceta'=> $this->session->userdata('cod_est')
            ,'nombre_est'=> $this->session->userdata('est_namefull')
            ,'onLoad'=>''
            ,'comunicados'=>$comunicados
        );
        
        $this->load->view("head",$data); 	
        $this->load->view("blog/list_post_header");
		$this->load->view("nav");
		$this->load->view("blog/list_post");
		$this->load->view("footer");
    }

    public function detail($enlace) {
        if(!$this->session->userdata('cod_est'))
		{
			redirect(base_url().'index');
        }
        $cod_est = $this->session->userdata('cod_est');
        $comunicados=$this->consultas->get_comunicados($cod_est);
        $bloqueado = $this->consultas->is_blocked_est($cod_est);
        $comunicados = $this->consultas->get_comunicados($cod_est);

        $fechaF = new Fechas();
        $post = $this->consultas->get_post($enlace);
        $autores = $this->consultas->get_post_autor($post->id_post);
        $comentarios = $this->consultas->get_comentarios($post->id_post);
        $total_comentarios = 0;
        $data= array(
            'fecha'=>$fechaF->FechaFormateada()
            ,'cod_ceta'=> $this->session->userdata('cod_est')
            ,'nombre_est'=> $this->session->userdata('est_namefull')
            ,'onLoad'=>''
            ,'detalle'=>$post
            ,'docente'=> $autores->autor
            ,'comentarios'=>$comentarios
            ,'total_comentarios'=>$total_comentarios
            ,'bloqueado'=>$bloqueado
            ,'comunicados'=>$comunicados
        );

        $this->load->view("head",$data); 	
		$this->load->view("nav");
		$this->load->view("blog/post");
		$this->load->view("footer");
    }

    //insertamos el nuevo comentario y lo validamos
    function nuevo_comentario() {
        //$this->output->enable_profiler(TRUE);
        $this->form_validation->set_rules('comentario', 'mensaje', 'trim|required|min_length[5]');
        $this->form_validation->set_message('required', 'El %s es obligatorio');
        $this->form_validation->set_message('min_length', 'El %s debe tener al menos %s carácteres');
        if ($this->form_validation->run() == FALSE) {
            echo 'error de validacion';
        } else {
            if($this->session->userdata('cod_est')) {
                $id_respuesta = null;
                $data = array(
                    'id_post' => $this->input->post('id_post'),
                    'cod_ceta' => $this->session->userdata('cod_est'),
                    'contenido' => $this->input->post('comentario'),
                    'fecha' => date('Y-m-d H:i:s'),
                    'id_respuesta' => $id_respuesta
                );
                $this->consultas->insert_table('est_post_comentario',$data);
            }
            //$this->db->set($data)->get_compiled_insert('entrada');
            echo 'ok todo bien';
        }
    }

    function nueva_respuesta() {
        $this->form_validation->set_rules('respuesta-text', 'respuesta', 'trim|required|min_length[5]');
        $this->form_validation->set_message('required', 'La %s es obligatoria');
        $this->form_validation->set_message('min_length', 'La %s debe tener al menos %s carácteres');
        if($this->session->userdata('cod_est')) {
            $id_respuesta = null;
            if($this->input->post('id_respuesta')) {
                $id_respuesta  = $this->input->post('id_respuesta');
            }
            $data = array(
                'id_post' => $this->input->post('id_post_respuesta'),
                'cod_ceta' => $this->session->userdata('cod_est'),
                'contenido' => $this->input->post('respuesta-text'),
                'fecha' => date("Y-m-d H:i:s"),
                'id_respuesta' => $id_respuesta
            );
            $this->consultas->insert_table('est_post_comentario',$data);
        }
    }

    //mostramos los comentarios con ajax con esta función
    function get_comentarios_ajax() {
        if($this->input->post('id_post')) {
            $id_post = $this->input->post('id_post');
            $comentarios = $this->consultas->get_comentarios($id_post);
            if (!$comentarios) {
                ?>
                <div id="sinComentarios">Sé el primero en publicar un comentario</div>
                <?php
            } else {
                ?>
                <div class="titulo-comentario">
                    <h5><?= count($comentarios) ?> Comentarios</h5>
                </div>
                <ul class="list-unstyled msg_list">    
                <?php
                foreach ($comentarios as $comentario) {
                                //1140153693
                    //$post_date = $comentario->fecha->getTimestamp(); ///error por que es string
                    $post_date = strtotime($comentario->fecha);
                    //$post_date = strtotime('2018-07-30 19:39:40');
                    $now = time();
                    ?>
                <li class="">
                    <div class="d-flex mt-3">
                        <div class="mr-3">
                            <span >
                                <img class="imagen-sm" src="<?= base_url(); ?>plantillas/img/usuario2.png" alt="imagen estudiante" />
                            </span>
                        </div>
                        <div class="w-100">
                            <div>
                                <span><strong><?= $comentario->nombre ?></strong></span>
                                <span class="text-muted ml-1">Hace <?= timespan($post_date, $now)  ?></span>
                            </div>
                            <div name="respuestaComentario" class="mt-1"><?= $comentario->contenido ?></div>
                            <div class="mt-1">
                                <div>
                                    <button type="button" id="btn_responder" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" onclick="setIdRespuesta(<?= $comentario->id_comentario ?>)">Responder</button>
                                    <?php
                                    $respuesta = intval($comentario->res);
                                    if($respuesta>0)
                                    {
                                    ?>

                                    <button type="button" class="btn btn-link" onclick="cargarRespueta(<?=$comentario->id_comentario?>)">
                                        <strong>Ver las <?= $respuesta ?> respuesta</strong>
                                        <span class="fa fa-chevron-right" ></span>
                                    </button>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div id="mostrar_respuesta<?= $comentario->id_comentario ?>" ></div>
                            </div>
                        </div>
                    </div>
                </li>
                    <?php
                }
                ?>
                    
                </ul>
                <?php
            }
        }
    } 
    //Creo que esta funcion no se utiliza revisar y eliminar si no se utiliza
    function get_resuestas_ajax() {
        $id_comentario = $this->input->post('id_comentario');
        ?>
        <h6><?= 'la debe mostrar comentario:'.$id_comentario; ?></h6>     
        <?php
    }

    function actualizar_comentarios() {
        $id_post = $this->input->post('id_post');
        $data = $this->input->post('com');
        $string = '';


        $datos = array();
        foreach ($data as $item ) {
            $array = array();
            $id_padre = $item['id_padre'];
            $cantidad = $item['cantidad'];
            $mostrar = $item['mostrar'] === 'true' ?TRUE:FALSE;

            if($mostrar) {
                $array['id_padre'] = $id_padre;
                $array['nuevos_comentarios'] = $this->consultas->get_comentarios_by_idP($id_post,$id_padre,$cantidad);
                $array['respuestas'] = $this->consultas->get_respuestas_by_idP($id_post,$id_padre,$cantidad);

                $datos[] = $array;
            }
        }

        echo json_encode($datos);
    }

    function registrar_denuncia() {
        if($this->session->userdata('cod_est')) {
            $id_comentario = $this->input->post('id_comentario');
            $data = array(
                'id_comentario' => $id_comentario,
                'cod_ceta' => $this->session->userdata('cod_est'),
                'descripcion' => $this->input->post('respuesta-text'),
            );
            $this->consultas->insert_table('est_comentario_denuncia',$data);

            $data = array(
                'denuncia' => TRUE
            );
            $success = $this->consultas->update_table('est_post_comentario',$data,'id_comentario='.$id_comentario);
            if($success) {
                echo 'exito al bloquear al estudiante';
            } else {
                echo 'fallo al bloquear al estudiante';
            }
        }
    }

    function get_list_post() {
        $cod_est = $this->session->userdata('cod_est');
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$search = $this->input->post('search')['value'];
		$column  = $this->input->post('order')[0]['column'];
		$dir = $this->input->post('order')[0]['dir'];

		$array_res = $this->consultas->get_list_post_table($start,$length,$search,$column,$dir,$cod_est);
		$total_datos = $array_res['numDataTotal'];
		$resultado = $array_res['datos'];

		$datos = array();
		foreach ($resultado->result_array() as $row) {
			$array = array();
            $array['id_post'] = $row['id_post'];
            $array['carrera'] = $row['carrera'];
            $array['titulo'] = $row['titulo'];
            $array['tema'] = $row['tema'];
            $array['fecha'] = timespan(strtotime($row['fecha']), time(), 2);
            $array['permite_comentario'] = $row['permite_comentario'];
            $array['enlace'] = $row['enlace'];
            $array['descripcion'] = $row['descripcion'];

			$datos[] = $array;
		}
		
		$total_datos_obtenidos = $resultado->num_rows();

		$json_data = array(
			"draw" 				=>intval($this->input->post('draw')),	//
			"problems" 				=>$column.'-'.$dir,                 //Utilizo para pasar algun dato cuando exista problemas
			"recordsTotal"		=>intval($total_datos_obtenidos),	 	//Cantidad de registros obtenido   
			"recordsFiltered"	=>intval($total_datos),					//Cantidad de registros Permite dibujar paginacion
			"data"				=>$datos						//Pasa los datos en si
		);
        echo json_encode($json_data);
    }
}
