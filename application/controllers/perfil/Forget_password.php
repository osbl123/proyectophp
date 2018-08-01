<?php



class Forget_password extends CI_Controller
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
		$this->load->view("perfil/forget_password");
	}
	public function verificar_codigo()
	{
		$codigo=$_POST['codigo'];
		$sql="SELECT email, ap_paterno||' '||ap_materno ||' '||nombres as nombre FROM estudiante WHERE cod_ceta = $codigo";
		$get_estudiante=$this->consultas->consulta_SQL($sql);
		if($get_estudiante!=null)
		{	
			$email=$get_estudiante->row()->email;
			$nombre=$get_estudiante->row()->nombre;
			if(strlen($email)>0)
			{
				// $arrayJS =array('email'=>$email,'nombre'=>$nombre);
		    	echo  json_encode(array('email'=>$email,'nombre'=>$nombre));
		    	// echo $email;
			}
			else
			echo 'no_email';
		}
		else
			echo 'no_existe';
		
	}	
	
	public function enviar(){
		$codigo=$_POST['codigo'];
		$e_mail=$_POST['e_mail'];
		$e_mail_nombre=$_POST['e_mail_nombre'];

     	$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);

        $this->email->from('webmaster@ceta.edu.bo', 'Web Master CETA');
      	$this->email->to($e_mail, $e_mail_nombre);
         
        $this->email->subject("Reset Contraseña");
        $contrasenia_nueva=rand(100000000, 999999999).'Ceta';
        $this->registrar_contraseña($codigo,$contrasenia_nueva);
        $this->email->message(
                "Su nueva contraseña para ingresar al Sistema de Instituto CETA es : <strong> ". $contrasenia_nueva. 
                "</strong>.<br>Una vez ingresado al Sistema, cambie la contraseña por una nueva."
                );
        if($this->email->send()){
            echo 'exito';
        }else{
            echo 'error';
        }
         
   } 
   public function registrar_contraseña($codigo,$contrasenia)
      {
      	$where =array(
						'cod_ceta'=>$codigo,						
						);
		$data =array(
			'password' =>md5($contrasenia),
		);
		$this->consultas->update_table('est_password',$data,$where);
      }   
}
?>