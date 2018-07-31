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
		$sql="SELECT nombres||' '|| ap_paterno||' '|| ap_materno as name FROM estudiante 
		INNER JOIN  est_password ON  est_password.cod_ceta =  estudiante.cod_ceta WHERE estudiante.cod_ceta = $username AND est_password.password = md5('$password')";
		//$sql="SELECT CONCAT(nombres,' ', ap_paterno,' ', ap_materno) as name FROM estudiante INNER JOIN  doc_presentados ON  doc_presentados.cod_ceta =  estudiante.cod_ceta WHERE estudiante.cod_ceta = $username AND numero_doc = '$password' AND nombre_doc = 'Carnet de identidad'";
		$q=$this->db->query($sql);
		if($q->num_rows()>0)
			return $q->row()->name;			
		else
			return '';
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

	

	public function get_post($enlace) {

		$this->db->where("enlace", $enlace);
		$query = $this->db->get('est_post'); 
        
		if(!is_null($query)) {
			return $query->row();
		}
	}

	public function get_docente($cod_docente) {
		$this->db->where("cod_docente",$cod_docente);
		$query = $this->db->get('docente'); 

		return $query->row();
	}


	public function get_list_post($cod_ceta,$inicio = FALSE,$limite = FALSE) {

		$sql = "WITH datos AS (
			SELECT registro_inscripcion.cod_curso, semestre , registro_inscripcion.cod_pensum
			FROM registro_inscripcion 
			INNER JOIN gestion ON gestion.gestion = registro_inscripcion.gestion 
			INNER JOIN grupo ON grupo.gestion = gestion.gestion 
					AND grupo.cod_pensum = registro_inscripcion.cod_pensum 
					AND grupo.cod_grupo = registro_inscripcion.cod_curso 
			WHERE cod_ceta = '$cod_ceta' AND tipo_inscripcion='NORMAL' ORDER BY fecha_inicio DESC
		)
		, carreras as 
		(
			SELECT distinct cod_pensum  from datos
		)
		(SELECT ep.id_post, ep.carrera, ep.titulo, ep.tema,ep.enlace, 
				 ep.fecha,ep.activo,ep.permite_comentario,ep.contenido,ep.descripcion
		 FROM est_post as ep 
		 INNER JOIN est_post_poblacion as epp ON epp.id_post = ep.id_post 
			 WHERE activo = 't' and item = 'Todos'
			 and ep.carrera in (select cod_pensum from carreras)
		)
			UNION
		(SELECT ep.id_post, ep.carrera, ep.titulo, ep.tema,ep.enlace, 
				 ep.fecha,ep.activo,ep.permite_comentario,ep.contenido,ep.descripcion 
		 FROM est_post as ep 
		 INNER JOIN est_post_poblacion as epp ON epp.id_post = ep.id_post 		
		 WHERE activo = 't' AND item in (select semestre from datos where cod_pensum = ep.carrera)
			 and ep.carrera in (select cod_pensum from carreras)
		)	
			UNION
		(SELECT ep.id_post, ep.carrera, ep.titulo, ep.tema,ep.enlace, 
				 ep.fecha,ep.activo,ep.permite_comentario,ep.contenido,ep.descripcion
		 FROM est_post as ep 
		 INNER JOIN est_post_poblacion as epp ON epp.id_post = ep.id_post 
		 WHERE activo = 't' AND item in (select cod_curso from datos)
			 and ep.carrera in (select cod_pensum from carreras)
		)
		ORDER BY fecha desc";

		if($inicio !== FALSE && $limite !== FALSE) {
			$sql.=" LIMIT $limite OFFSET $inicio";
		}

		$consulta=$this->db->query($sql);

		if($consulta->num_rows()>0)
		{
			return $consulta->result();
		} else {
			return null;
		}
	}

	public function count_list_post($cod_ceta) {

		$sql = "WITH datos AS (
			SELECT registro_inscripcion.cod_curso, semestre , registro_inscripcion.cod_pensum
			FROM registro_inscripcion 
			INNER JOIN gestion ON gestion.gestion = registro_inscripcion.gestion 
			INNER JOIN grupo ON grupo.gestion = gestion.gestion 
					AND grupo.cod_pensum = registro_inscripcion.cod_pensum 
					AND grupo.cod_grupo = registro_inscripcion.cod_curso 
			WHERE cod_ceta = '$cod_ceta' AND tipo_inscripcion='NORMAL' ORDER BY fecha_inicio DESC
		)
		, carreras as 
		(
			SELECT distinct cod_pensum  from datos
		)
		(SELECT ep.id_post, ep.carrera, ep.titulo, ep.tema,ep.enlace, 
				 ep.fecha,ep.activo,ep.permite_comentario,ep.contenido,ep.descripcion
		 FROM est_post as ep 
		 INNER JOIN est_post_poblacion as epp ON epp.id_post = ep.id_post 
			 WHERE activo = 't' and item = 'Todos'
			 and ep.carrera in (select cod_pensum from carreras)
		)
			UNION
		(SELECT ep.id_post, ep.carrera, ep.titulo, ep.tema,ep.enlace, 
				 ep.fecha,ep.activo,ep.permite_comentario,ep.contenido,ep.descripcion 
		 FROM est_post as ep 
		 INNER JOIN est_post_poblacion as epp ON epp.id_post = ep.id_post 		
		 WHERE activo = 't' AND item in (select semestre from datos where cod_pensum = ep.carrera)
			 and ep.carrera in (select cod_pensum from carreras)
		)	
			UNION
		(SELECT ep.id_post, ep.carrera, ep.titulo, ep.tema,ep.enlace, 
				 ep.fecha,ep.activo,ep.permite_comentario,ep.contenido,ep.descripcion
		 FROM est_post as ep 
		 INNER JOIN est_post_poblacion as epp ON epp.id_post = ep.id_post 
		 WHERE activo = 't' AND item in (select cod_curso from datos)
			 and ep.carrera in (select cod_pensum from carreras)
		)
		ORDER BY fecha desc";

		$consulta=$this->db->query($sql);

		return $consulta->num_rows();
	}

	public function get_comunicados($cod_ceta) {
		$sql="SELECT registro_inscripcion.cod_curso, semestre FROM registro_inscripcion INNER JOIN gestion ON gestion.gestion = registro_inscripcion.gestion INNER JOIN grupo ON grupo.gestion = gestion.gestion AND grupo.cod_pensum = registro_inscripcion.cod_pensum AND grupo.cod_grupo = registro_inscripcion.cod_curso WHERE cod_ceta = $cod_ceta AND tipo_inscripcion='NORMAL' ORDER BY fecha_inicio DESC LIMIT 1";
		$consulta=$this->db->query($sql);
		if($consulta->num_rows()>0)
		{
			$grupo=$consulta->row()->cod_curso;
			$semestre=$consulta->row()->semestre;
			$sql="(SELECT est_avisos.id_aviso, prioridad, titulo, descripcion, item FROM est_avisos INNER JOIN est_avisos_poblacion ON est_avisos_poblacion.id_aviso = est_avisos.id_aviso WHERE habilitado = 't' AND fecha_fin >= now() AND item = 'Todos')
				UNION
				(SELECT est_avisos.id_aviso, prioridad, titulo, descripcion, item FROM est_avisos INNER JOIN est_avisos_poblacion ON est_avisos_poblacion.id_aviso = est_avisos.id_aviso WHERE habilitado = 't' AND fecha_fin >= now() AND item = '$semestre')
				UNION
				(SELECT est_avisos.id_aviso, prioridad, titulo, descripcion, item FROM est_avisos INNER JOIN est_avisos_poblacion ON est_avisos_poblacion.id_aviso = est_avisos.id_aviso WHERE habilitado = 't' AND fecha_fin >= now() AND item = '$grupo')
				ORDER BY  prioridad ASC,id_aviso ASC";
			$consulta=$this->db->query($sql);
			if($consulta->num_rows()>0)
				return $consulta;
			else
				return null;
		}
		else
		{
			return null;
		}			
		
	}

	public function get_post_autor($id_post) {

		$sql = "select ep.id_post,string_agg(d.nombre, ', ') as autor
			from est_post_autor as ep
			inner join (
				select concat(nombre|| ' '||apellido_p|| ' '||apellido_m) as nombre, cod_docente
				from docente
			) as d on d.cod_docente = ep.cod_docente

			where id_post='$id_post'
			group by ep.id_post";
		$consulta=$this->db->query($sql);
		return $consulta->row();
	}

	function get_comentarios($id_post) {

		$sql = "select epc.id_comentario,epc.id_post,e.nombre,epc.contenido,epc.fecha
		,(select count(*) as res from est_post_comentario where id_respuesta=epc.id_comentario)
		from est_post_comentario as epc
		inner join (
			select CONCAT(nombres||' '||ap_paterno||' '||ap_materno) as nombre, cod_ceta
			from estudiante
		) as e on epc.cod_ceta=e.cod_ceta
		where id_post = $id_post";
		$consulta=$this->db->query($sql);
		return $consulta->result();
		/*
        if ($consulta->num_rows() > 0) {
            foreach ($consulta->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
		}
		*/
	}
	
	function insert_table($tabla,$data)
	{
		if($this->db->insert($tabla,$data))
			{return true;}
		else
			{
				return false;
		}
	}

	function update_table($tabla,$data,$where)
	{
		$this->db->where($where);
		$this->db->update($tabla,$data);
		// if($this->db->update($tabla,$data))
		if($this->db->affected_rows()>0)
			{return true;}
		else
			{return false;}
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