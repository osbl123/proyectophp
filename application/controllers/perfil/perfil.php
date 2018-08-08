<?php

class Perfil extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
        $this->load->library('image_lib');
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
		$this->load->view("perfil/perfil");
		$this->load->view("footer");
	}
	public function get_datos()
	{
		$codigo=$_POST['codigo'];
		$resultado='';
		$sql="SELECT email FROM estudiante WHERE cod_ceta = $codigo"; 
		$get_datos_estudiante=$this->consultas->consulta_SQL($sql);
		if($get_datos_estudiante!=null)
		$resultado=$get_datos_estudiante->row()->email;
		echo $resultado;
	}
	public function update_email()
	{
		$codigo=$_POST['codigo'];
		$email=$_POST['email'];
		$where =array(
						'cod_ceta'=>$codigo,						
						);
		$data =array(
			'email' =>$email,
		);
		if($this->consultas->update_table('estudiante',$data,$where))
			echo 'exito';
		else
			echo 'error';

	}
	
	function create_thumb_gallery($width_origen,$height_origen, $source_img, $new_img, $width, $height)
    {
        //Copy Image Configuration
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_img;
        $config['create_thumb'] = FALSE;
        $config['new_image'] = $new_img;
        $config['quality'] = '100%';
        
        
        $this->image_lib->initialize($config);
        
        if ( ! $this->image_lib->resize() )
        {
            echo $this->image_lib->display_errors();
        }
        else
        {
            //Images Copied
            //Image Resizing Starts
            $config['image_library'] = 'gd2';
            $config['source_image'] = $source_img;
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['quality'] = '100%';
            $config['new_image'] = $new_img;
            $config['overwrite'] = TRUE;
            $config['width'] = $width;
            $config['height'] = $height;
            $dim = (intval($width_origen) / intval($height_origen)) - ($config['width'] / $config['height']);
            $config['master_dim'] = ($dim > 0)? 'height' : 'width';
            // print_r($config);
            
            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            
            if ( ! $this->image_lib->resize())
            {
                echo $this->image_lib->display_errors();
            }
            else
            {
                //echo 'Thumnail Created';
                return true;
            }
        }
    }
	function crop()
    {
    	$codigo=$this->session->userdata('cod_est');
    	$img = $_POST['source_image'];
$data = base64_decode(explode(',', $img)[1]);
// $img = str_replace('data:image/png;base64,', '', $img);
		// $img = str_replace('data:image/jpeg;base64,', '', $img);
		// $img = str_replace(' ', '+', $img);
		// $data = base64_decode($img);
		$file = 'plantillas/gallery/'.$codigo.'.jpg';
		$file2 = 'plantillas/gallery/'.$codigo.'_tm.jpg';
		$success = file_put_contents($file, $data);

    	$X = $_POST['x'];
    	$Y = $_POST['y'];
    	$W = $_POST['w'];
    	$H = $_POST['h'];
    	// $file_decoded = base64_decode($img);
    	$size_info2 = getimagesizefromstring($data);
    	list($width, $height) = explode(" ", $size_info2[3]);
    	$width=explode("\"", $width)[1];
    	$height=explode("\"", $height)[1];
        

        $source_img = $_SERVER['DOCUMENT_ROOT'].'/proyectophp/'.$file;
        $source_img_tm = $_SERVER['DOCUMENT_ROOT'].'/proyectophp/'.$file2;
    	// echo $source_img;
        if($this->create_thumb_gallery($width,$height, $source_img, $source_img_tm, 480, 360)) //Creating Thumbnail for Gallery which keeps the original

        // if($this->input->post('x',TRUE))
        {
            $X = $this->input->post('x');
            $Y = $this->input->post('y');
            $W = $this->input->post('w');
            $H = $this->input->post('h');
            // echo $source_img;

            $config['image_library'] = 'gd2';
            $config['source_image'] = $source_img_tm;
            $config['new_image'] = $source_img;
            $config['quality'] = '100%';
            $config['maintain_ratio'] = FALSE;
            $config['width'] = $W;
            $config['height'] = $H;
            $config['x_axis'] = $X;
            $config['y_axis'] = $Y;

            $this->image_lib->clear();
            $this->image_lib->initialize($config);

            if (!$this->image_lib->crop())
            {
                echo $this->image_lib->display_errors();
            }
            else
            {
                echo 'exito';
            }
        }
        else
        	echo 'error_thumb';
    }
}
?>