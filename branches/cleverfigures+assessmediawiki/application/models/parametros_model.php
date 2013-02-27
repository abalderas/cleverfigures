<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parametros_model extends CI_Model {

	private $valores_defecto = array(
		"categoria" => "",
		"fecha_inicio" => "19900101000000",
		"fecha_fin" => "29900101000000",
		"evaluaciones_por_alumno" => "10",
		"wiki_url" => "http://localhost"
		);

	/// Lee la categoría asignada desde la tabla de configuración
	function get_categoria ()
	{
		return $this->get_value('categoria');		
	}

	/// Asigna la categoría indicada
	function set_categoria ($value)
	{
		$this->set_value('categoria', $value);
	}

	function get_fecha_inicio()
	{
		return $this->get_value('fecha_inicio');
	}

	function set_fecha_inicio ($value)
	{
		$this->set_value('fecha_inicio', $value);
	}

	function get_fecha_fin()
	{
		return $this->get_value('fecha_fin');
	}

	function set_fecha_fin ($value)
	{
		$this->set_value('fecha_fin', $value);
	}

	function get_evaluaciones_por_alumno()
	{
		return intval($this->get_value('evaluaciones_por_alumno'));
	}

	function set_evaluaciones_por_alumno ($value)
	{
		$this->set_value('evaluaciones_por_alumno', $value);
	}

	function get_wiki_url()
	{
		return $this->get_value('wiki_url');
	}

	function set_wiki_url($value)
	{
		$this->set_value('wiki_url', $value);
	}

	/// Asigna el valor al parámetro indicado
	private function set_value ($parameter, $value)
	{
		$data = array('value' => $value);
		$this->db->where('parameter', $parameter);
		$this->db->update('config', $data);
	}
    
    /// Lee  el valor del parámetro indicado
	private function get_value ($parameter) 
	{
		// Selecciona el valor del parámetro indicado de la tabla config		
		$this->db->select('value');
		$this->db->from('config');
		$this->db->where('parameter', $parameter);

		// Realiza la llamada
		$query = $this->db->get();

		// Comprueba el resultado
		if ($query->num_rows() > 0) 
		{
			return $query->first_row()->value;
		}

		// Si no existe la clave en la base de datos, metemos un valor por defecto
		else
		{
			$this->db->insert('config', array("parameter" => $parameter, "value" => $this->valores_defecto[$parameter]));
			return $this->valores_defecto($parameter);
		}
	}
}
