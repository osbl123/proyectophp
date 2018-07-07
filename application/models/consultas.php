<?php  if(! defined('BASEPATH')) exit('No direct script access allowd');
/**
* 
*/
class Consultas extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function login_est($username,$password)
	{
		$sql="SELECT CONCAT(nombres,' ', ap_paterno,' ', ap_materno) as name FROM estudiante INNER JOIN  doc_presentados ON  doc_presentados.cod_ceta =  estudiante.cod_ceta WHERE estudiante.cod_ceta = $username AND numero_doc = '$password' AND nombre_doc = 'Carnet de identidad'";
		$q=$this->db->query($sql);
		if(is_null($q))
			return '';
		else
			return $q->row()->name;			
	}
	public function login_admin($username,$password)
	{
		$this->db->select('activo');
		$this->db->where('id_usuario',$username);//nombre del campo
		$this->db->where('pass',$password);
		$q=$this->db->get('usuario');//nombre de la tabla
		if($q->num_rows()>0)
		{
			$fila=$q->row();				
			if($fila->activo=='t')
			{
				$q=$this->db->query("SELECT nom_rol FROM asignacion_usuario WHERE id_usuario='".$username."'");	
				if($q->num_rows()>0)
				{
					$fila=$q->row();				
					return $fila->nom_rol;
				}
				else
				{
					return 'no_rol';
				}
			}
			else
				return 'false';	
		} 
		else
		{
			return null;
		}
	}
	public function consulta_SQL($sql)
	{
		$consulta=$this->db->query($sql);
		if($consulta->num_rows()>0)
		{
			return $consulta;
		}
		else
		{
			return null;
		}		
		
	}
	public function get_caja($username)
	{
		//$this->db->pg_select(connection, table_name, assoc_array)
		$this->db->select('monto,estado_caja');
		$this->db->where('usuario_asignado',$username);//nombre del campo
		$this->db->where('fecha',date('Y-m-d'));
		$q=$this->db->get('caja');//nombre de la tabla
		if($q->num_rows()>0)
		{
			$fila=$q->row();	
			return $fila->monto.'/'.$fila->estado_caja;			
		} 
		else
		{
			return null;
		}
	}
	public function abrir_caja($usuario)
	{
		$fecha=date('Y-m-d');
		$where = array(
			'usuario_asignado' =>$usuario, 
			'fecha' =>$fecha,
		);
		$hora_apertura=date('H:i:s');
		$data = array(	
			'hora_apertura' =>$hora_apertura,
			'estado_caja' =>'abierta',
		);
		if($this->config_model->update_table('caja',$data,$where))
				{ echo 'exito';}
			else
				{echo 'No se actualizaron los datos de la Dosificación!!!';}	
		
	}
	public function name_user($id_usuario)
	{	
		$sql="SELECT ap_paterno||' '||ap_materno||' '||nombre as name FROM usuario WHERE id_usuario = '".$id_usuario."'";
		$q=$this->db->query($sql);
		if(is_null($q))
			return '';
		else
			return $q->row()->name;
		echo $sql;
		echo $q;
	}
	// public function nombre_usuario($id_usuario)
	// {	
	// 	$sql="SELECT nombre||' '|| ap_paterno||' '||ap_materno as name FROM usuario WHERE id_usuario = '".$id_usuario."'";
	// 	$q=$this->db->query($sql);
	// 	if(is_null($q))
	// 		return '';
	// 	else
	// 		return $q->row()->name;
	// 	echo $sql;
	// 	echo $q;
	// }
}




?>