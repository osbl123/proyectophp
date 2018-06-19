<?php
/**
* 
*/

class Fechas
{
	
	function __construct()
	{
		$this->FechaStamp = time();
	}
	function FechaFormateada()
	{ 
	  $ano = date('Y',$this->FechaStamp);
	  $mes = date('n',$this->FechaStamp);
	  $dia = date('d',$this->FechaStamp);
	  $diasemana = date('w',$this->FechaStamp);
	  
	  $diassemanaN= array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"); 
	  $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	  return $diassemanaN[$diasemana].", ".$this->get_dia($dia)." de ". $mesesN[$mes] ." de $ano";
	}
	function Get_Fecha($FechaStamp)
	{ 
	  $ano = date('Y',$FechaStamp);
	  $mes = date('n',$FechaStamp);
	  $dia = date('d',$FechaStamp);
	  $diasemana = date('w',$FechaStamp);
	  
	  $diassemanaN= array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"); 
	  $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	  return $diassemanaN[$diasemana].", ".$this->get_dia($dia)." de ". $mesesN[$mes] ." de $ano";
	}
	function get_dia($dia='')
	{
		return '<img src="'.base_url().'plantillas/img/calendar'.$dia.'.png" width="30" height="30">';
	}
}

?>