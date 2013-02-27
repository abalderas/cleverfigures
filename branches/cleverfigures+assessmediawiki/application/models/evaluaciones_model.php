<?php
class Evaluaciones_model extends CI_Model {
    
	var $tabla = 'evaluaciones';
	var $tabla_entregables = 'evaluaciones_entregables';
	private $eva_id;
	private $eva_user;
	private $eva_revision;
	

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	/// Inserta una evaluación en la base de datos
	function insertar($datos)
	{

		// Inserta en la tabla la evaluación con los datos indicados
		$this->db->insert($this->tabla, $datos);

		// Guarda el ID de la evaluación recién insertada
		$this->eva_id = $this->db->insert_id();
		
		// Al insertar podemos comprobar si ya
		// existe corrección de dicho artículo para
		// no permitir una nueva.
	}
	
	// Inserta en la base de datos la información sobre los conceptos evaluados en una evaluación
	function insertar_entregables($entregables, $notas, $comentarios)
	{
		if (!empty($entregables))
		{
			foreach($entregables as $key => $value)
			{
				if (isset($value))
				{
					$datos['eva_id'] = $this->eva_id;
					$datos['ent_id'] = $key;
					$datos['ee_nota'] = $notas[$key];
					$datos['ee_comentario'] = $comentarios[$key];
					$this->db->insert($this->tabla_entregables, $datos);
				}
			}
		}
	}
	
	/// Devuelve el identificador de la última evaluación insertada en la BD
	function id()
	{
		return $this->eva_id;
	}
	
	/// Devuelve la información de los entregables relacionados con una evaluación particular
	function consultar_entregables($evaluacion)
	{

		// Leemos la evaluación correspondiente a la ID indicada
		$sql = 'SELECT eva_user, eva_revision, eva_revisor ' .
			' FROM evaluaciones ' .
			' where eva_id = ' . $evaluacion;
			
		// Lanzamos la consulta SQL
		$query = $this->db->query($sql);
			
		// TO-DO: añadir comprobación si la ID indicada no es correcta, usando $query->	num_rows

		// WTF? En teoría debería devolver un solo resultado
		foreach ($query->result() as $row)
		{
			$data['usuario'] = $row->eva_user;
			$data['entrada'] = $row->eva_revision;
			$data['revisor'] = $row->eva_revisor;
		}
		
		$sql = 'SELECT entregables.ent_id, ent_entregable, ee_nota, ee_comentario ' .
			' FROM evaluaciones_entregables, entregables ' .
			' where entregables.ent_id = evaluaciones_entregables.ent_id ' . 
			' and eva_id = ' . $evaluacion;
			
		$query = $this->db->query($sql);
		
		//$data['id_campo'] = array();
		$data['puntuacion'] = array();
		$data['comentarios'] = array();
		$data['entregables'] = array();
		foreach ($query->result() as $row)
		{
			//$data['id_campo'][$row->ent_id] = 1;
			$data['puntuacion'][$row->ent_id] = $row->ee_nota;
			$data['comentarios'][$row->ent_id] = $row->ee_comentario;
			$data['entregables'][$row->ent_id] = $row->ent_entregable;
		}
		
		return $data;
	}
	
	function evaluados($articulos)
	{
		$revisados = array();
		
		$sql = 'SELECT eva_id, eva_revision ' .
			' FROM evaluaciones ' .
			' where eva_revision IN (';
			
		foreach ($articulos as $valor)
			$sql .= $valor . ', ';
			
		$sql .= '-1)'; // -1 me sirve para salvar la  del final
		//echo $sql;	
		
		// remove replies from list.
		$sql .= ' AND eva_id NOT IN ' .
			'(SELECT rep_new FROM replies)';
		
		$query = $this->db->query($sql);
			
		foreach ($query->result() as $row)
		{
			$revisados[$row->eva_id] = $row->eva_revision;
		}
		
		return $revisados;
	}
	
	/// Devuelve una lista de revisiones de artículos ya evaluadas
	function listado()
	{
		$revisados = array();

		// Aislamos el campo con el número de revisión evaluada
		$this->db->select('eva_revision');

		// Leemos los datos de la BD
		$query = $this->db->get($this->tabla);

		// Por cada fila, metemos en el array el ID de la revisión
		foreach ($query->result() as $row)
			array_push($revisados, $row->eva_revision);
		
		return $revisados;
	}
    

}
?>
