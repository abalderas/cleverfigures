<?php
class Csv_model extends CI_Model {

	private $table = 'evaluaciones_entregables';

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	function datos($id)
	{
		$data['listado'] = array();
		$data['revisions'] = array();

		$sql = "SELECT eva_id, eva_revision " .
			"FROM evaluaciones " .
			"WHERE eva_user = $id";

		$i=0;
		$query = $this->db->query($sql);
			
		foreach ($query->result() as $row)
		{
			$data['listado'][$i] = $row->eva_id;
			$data['revisions'][$i] = $row->eva_revision;
			$i++;
		}

		return $data;
    	}

	function entregables($campo)
	{
		$entregables = array();

		$sql = "SELECT $campo " .
			"FROM entregables";

		$i=0;
		$query = $this->db->query($sql);
			
		foreach ($query->result() as $row)
		{
			$entregables[$i] = $row->$campo;
			$i++;
		}

		return $entregables;
	}

	function notas($ids)
	{
		$notas = array();

		$tot = count($ids);
		for ($i=0; $i<$tot; $i++)
		{
			$sql = "SELECT ent_id, ee_nota " .
			"FROM evaluaciones_entregables " .
			"WHERE eva_id = $ids[$i]";

			$query = $this->db->query($sql);
			foreach ($query->result() as $row)
			{
				$notas[$i][$row->ent_id] = $row->ee_nota;
			}
		}
		return $notas;		
	}

	function usuarios()
	{
		$users = array();

		$sql = "SELECT distinct eva_user " .
			"FROM evaluaciones " . 
			"ORDER BY eva_user ASC ";

		$i=0;
		$query = $this->db->query($sql);
			
		foreach ($query->result() as $row)
		{
			$users[$i] = $row->eva_user;
			$i++;
		}
		return $users;
	}

		
	function suma_notas($users, $competencies)
	{
		$sum = array();

		$total_users = count($users);
		$total_comp = count($competencies);

		for ($i=0; $i < $total_users; $i++)
			for ($j =0; $j < $total_comp; $j++)
			{
				$sql = "SELECT SUM(ee_nota) suma ".
					"FROM evaluaciones_entregables a, evaluaciones b " .
					"WHERE a.eva_id = b.eva_id " .
					"AND b.eva_user = $users[$i] ".
					"AND a.ent_id = $competencies[$j] ".
					"GROUP BY b.eva_user, a.ent_id ".
					"ORDER BY b.eva_user ";

				$query = $this->db->query($sql);

				foreach($query->result() as $row)
				{
					$sum[$users[$i]][$competencies[$j]] = $row->suma;
				}
			}
		return $sum;
	}


	function cuenta_notas($users, $competencies)
	{
		$sum = array();

		$total_users = count($users);
		$total_comp = count($competencies);

		for ($i=0; $i < $total_users; $i++)
			for ($j =0; $j < $total_comp; $j++)
			{
				$sql = "SELECT COUNT(ee_nota) cuenta ".
					"FROM evaluaciones_entregables a, evaluaciones b " .
					"WHERE a.eva_id = b.eva_id " .
					"AND b.eva_user = $users[$i] ".
					"AND a.ent_id = $competencies[$j] ".
					"GROUP BY b.eva_user, a.ent_id ".
					"ORDER BY b.eva_user ";

				$query = $this->db->query($sql);

				foreach($query->result() as $row)
				{
					$sum[$users[$i]][$competencies[$j]] = $row->cuenta;
				}
			}
		return $sum;
	}


	function resumen_notas($users, $competencies)
	{
		$sum = array();

		$total_users = count($users);
		$total_comp = count($competencies);

		for ($i=0; $i < $total_users; $i++)
			for ($j =0; $j < $total_comp; $j++)
			{
				$sql = "SELECT a.eva_id, a.ee_nota ".
					"FROM evaluaciones_entregables a, evaluaciones b " .
					"WHERE a.eva_id = b.eva_id " .
					"AND b.eva_user = $users[$i] ".
					"AND a.ent_id = $competencies[$j] ".
					"ORDER BY b.eva_user ";

				$query = $this->db->query($sql);
				$sum[$users[$i]][$competencies[$j]] = "";
				foreach($query->result() as $row)
				{
					$sum[$users[$i]][$competencies[$j]] .= "(". $row->eva_id . "," . $row->ee_nota . ")";
				}
			}
		return $sum;
	}

}
?>
