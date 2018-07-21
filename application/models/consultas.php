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

	public function get_list_post() {
		$this->db->order_by("id_entrada", "desc");
		$query = $this->db->get('entrada'); 
		
        
		if(is_null($query)) {
			return array();
		} else {
			return $query->result();
		}
	}

	public function get_post($enlace) {

		$this->db->where("enlace", $enlace);
		$query = $this->db->get('entrada'); 
        
		if(!is_null($query)) {
			return $query->row();
		}
	}

	public function get_docente($cod_docente) {
		$this->db->where("cod_docente",$cod_docente);
		$query = $this->db->get('docente'); 

		return $query->row();
	}
	public function get_comunicados($cod_ceta) {
		$sql="SELECT titulo, descripcion FROM est_avisos WHERE activo = 't' AND fecha_fin >= now() ORDER BY id_aviso";
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