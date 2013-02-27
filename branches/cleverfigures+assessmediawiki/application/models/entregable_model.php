<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entregable_model extends CI_Model 
{

	// Títulos de los entregables
    var $entregables = array();

    // Descripciones de los entregables
    var $descriptions = array();

    private $table = 'entregables';

    /// Lee de la BD todos los entregables y los vuelca en la BD
    function __construct()
    {
        // Llama al constructor del padre
        parent::__construct();

        // Pedimos todos los entregables de la base de datos
		$query = $this->db->get($this->table);

		// Volcamos el contenido de la BD en las dos arrays				
		foreach ($query->result() as $row)
		{
			$this->entregables[$row->ent_id] = $row->ent_entregable;
			$this->descriptions[$row->ent_id] = $row->ent_description;
		}
	}
    
    /// Borra el entregable con el ID indicado
	function delete($id)
	{
		$this->db->delete($this->table, array('ent_id' => $id));
	}

	/// Devuelve el entregable con el ID indicado
	function get($id)
	{
		$query = $this->db->get_where($this->table, array('ent_id' => $id));
		return $query->first_row();
	}

	/// Edita el entregable con los datos indicados
	function update($data)
	{		
		log_message('error','ID: ' . $data['ent_id']);
		$this->db->where('ent_id', $data['ent_id']);
		log_message('error',$this->db->update($this->table, $data));
	}

	/// Inserta el entregable con los datos indicados
	function insert($data)
	{
		$this->db->insert($this->table, $data); 
	}
}

