<?php

// <<Copyright 2013 Alvaro Almagro Doello>>
// 
// This file is part of CleverFigures.
// 
// CleverFigures is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// CleverFigures is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with CleverFigures.  If not, see <http://www.gnu.org/licenses/>.


class Color_model extends CI_Model{
	
	
   	function Color_model(){
   		//Llamamos al constructor heredado.
   	   	parent::__construct();
   	   	$this->load->database();
   	   	
   	   	//Cargamos models necesarios
   	   	$ci =& get_instance();
		$ci->load->model('connection_model');
   	}
   	
   	private function array_avg($array){
		return array_sum($array) / count($array);
   	}
   	
   	private function standard_deviation($aValues, $bSample = false){
		$fMean = array_sum($aValues) / count($aValues);
		$fVariance = 0.0;
		foreach ($aValues as $i){
			$fVariance += pow($i - $fMean, 2);
		}
		$fVariance /= ( $bSample ? count($aValues) - 1 : count($aValues) );
		return (float) sqrt($fVariance);
	}
	
   	function countdim($array){
		if (is_array(reset($array)))
			$return = $this->countdim(reset($array)) + 1;
		else
			$return = 1;

		return $return;
	}
	
   	private function wconnection($colorname){
   		//Consultamos la conexión
   		$query = $this->db->query("select color_connection from color where color_name = '$colorname'");
   		//Comprobamos que existe y devolvemos el id de conexión
   		if(!$query->result())
   			return "wconnection(): ERR_NONEXISTENT";
   		else
   			foreach($query->result() as $row)
   				return $row->color_connection;
   	}
   	
   	function get_color_list($username){
		//Consultamos la conexión
   		$query = $this->db->query("select * from color, `user-color` where color.color_name = `user-color`.color_name and `user-color`.user_username = '$username'");
   		
   		//Comprobamos que existe y devolvemos el id de conexión
   		if(!$query->result())
   			return array();
   		else
   			foreach($query->result() as $row)
   				$colors[$row->color_name] = $row->color_name;
   				
   		return $colors;
   	}
   	
   	function new_color($colorname, $db_server, $db_name, $db_user, $db_password){
   		//Creamos una nueva conexión
   		$my_con = $this->connection_model->new_connection($db_server, $db_name, $db_user, $db_password);
   		
   		//Si hay error, devolvemos el mensaje de error
   		if(gettype($my_con) != "integer")
   			return "new_color(): $my_con";
   		
   		//Consultamos si la fuente ya existe, si es así devolvemos error
   		$check = $this->db->query("select * from color where color_name = '$colorname'");
   		if($check->result())
   			return "new_color(): ERR_ALREADY_EXISTS";
   		else{
   			//Creamos el array a insertar, con la info de la fuente e insertamos
   			$sql = array('color_id' => "",
   				'color_name' => "$colorname",
   				'color_connection' => $my_con
   				);
			$this->db->insert('color', $sql);
		
			//Si no hay error de inserción, devolvemos el id de la fuente
			if($this->db->affected_rows() != 1) 
				return "new_color(): ERR_AFFECTED_ROWS (".$this->db->affected_rows().")";
			else
				return  $this->db->insert_id();
		}
   	}
   	
   	function fetch($colorname, $analisis){
   	
		//Checking that we have reference dates. Two options: 
		//they come with the filter or they are manually 
		//specified as parameters
		
		echo ">> Assess analisis started.</br>";
		echo "Connecting to assess database...</br>";
		ob_flush(); flush();
		//Connecting to the wiki database
   		$link = $this->connection_model->connect($this->wconnection($colorname));
   		
   		echo "Querying database for assess information...";
		ob_flush(); flush();
   		//Creating query string
   		$qstr = "select eva_user, eva_revisor, eva_revision, ent_entregable, ee_nota, ee_comentario from entregables, evaluaciones, evaluaciones_entregables where evaluaciones_entregables.eva_id = evaluaciones.eva_id and evaluaciones_entregables.ent_id = entregables.ent_id order by eva_revision asc";
		
		//Querying database
   		$query = $link->query($qstr);
   		
   		//If no results then return false
   		if(!$query->result()) 
			return false;
			
		echo "done.</br>";
   		
   		echo "Storing assess information...";
		ob_flush(); flush();
   		//Storing classified information in arrays 
   		foreach($query->result() as $row){
   			
   			//USER INFORMATION
			
			$usermark	[$row->eva_user][$row->eva_revision] = $row->ee_nota;
			$useraverage	[$row->eva_user][$row->eva_revision] = $this->array_avg($usermark[$row->eva_user]);
			$userminvalue	[$row->eva_user][$row->eva_revision] = min($usermark[$row->eva_user]);
			$usermaxvalue	[$row->eva_user][$row->eva_revision] = max($usermark[$row->eva_user]);
			$usersd		[$row->eva_user][$row->eva_revision] = $this->standard_deviation($usermark[$row->eva_user]);
			$usercriteria	[$row->eva_user][$row->eva_revision] = $row->ent_entregable;
			$userrevisor	[$row->eva_user][$row->eva_revision] = $row->eva_revisor;
			$usercomment	[$row->eva_user][$row->eva_revision] = $row->ee_comentario;
			
			
			//CRITERIA INFORMATION
   			
   			$criteriamark	 [$row->ent_entregable][$row->eva_revision] = $row->ee_nota;
			$criteriaaverage [$row->ent_entregable][$row->eva_revision] = $this->array_avg($criteriamark[$row->ent_entregable]);
			$criteriamaxvalue[$row->ent_entregable][$row->eva_revision] = max($criteriamark[$row->ent_entregable]);
			$criteriaminvalue[$row->ent_entregable][$row->eva_revision] = min($criteriamark[$row->ent_entregable]);
			$criteriarevisor [$row->ent_entregable][$row->eva_revision] = $row->eva_revisor;
			$criteriacomment [$row->ent_entregable][$row->eva_revision] = $row->ee_comentario;
			$criteriauser	 [$row->ent_entregable][$row->eva_revision] = $row->eva_user;
			
			
			//REVISOR INFORMATION
			
			$revisormark	[$row->eva_revisor][$row->eva_revision] = $row->ee_nota;
			$revisoraverage [$row->eva_revisor][$row->eva_revision] = $this->array_avg($revisormark[$row->eva_revisor]);
			$revisormaxvalue[$row->eva_revisor][$row->eva_revision] = max($revisormark[$row->eva_revisor]);
			$revisorminvalue[$row->eva_revisor][$row->eva_revision] = min($revisormark[$row->eva_revisor]);
			$revisorcomment [$row->eva_revisor][$row->eva_revision] = $row->ee_comentario;
			$revisorcriteria[$row->eva_revisor][$row->eva_revision] = $row->ent_entregable;
			$revisoruser	[$row->eva_revisor][$row->eva_revision] = $row->eva_user;
			
			
			//TOTAL INFORMATION
			
			$totalmark	[$row->eva_revision] = $row->ee_nota;
			$totalaverage	[$row->eva_revision] = $this->array_avg($totalmark);
			$totalmaxvalue	[$row->eva_revision] = max($totalmark);
			$totalminvalue	[$row->eva_revision] = min($totalmark);
			$totaluser	[$row->eva_revision] = $row->eva_user;
			$totalcriteria	[$row->eva_revision] = $row->ent_entregable;
			$totalrevisor	[$row->eva_revision] = $row->eva_revisor;
   		}
   		
   		echo "done.</br>";
   		echo ">> Assess analisis accomplished.</br>";
		ob_flush(); flush();
   		
   		$analisis_data = array(	'usermark' => $usermark
				, 'useraverage' => $useraverage
				, 'usersd' => $usersd
				, 'usermaxvalue' => $usermaxvalue
				, 'userminvalue' => $userminvalue
				, 'usercriteria' => $usercriteria
				, 'userrevisor' => $userrevisor
				, 'usercomment' => $usercomment
				, 'criteriamark' => $criteriamark
				, 'criteriaaverage' => $criteriaaverage
				, 'criteriamaxvalue' => $criteriamaxvalue
				, 'criteriaminvalue' => $criteriaminvalue
				, 'criteriarevisor' => $criteriarevisor
				, 'criteriacomment' => $criteriacomment
				, 'criteriauser' => $criteriauser
				, 'revisormark' => $revisormark
				, 'revisoraverage' => $revisoraverage
				, 'revisormaxvalue' => $revisormaxvalue
				, 'revisorminvalue' => $revisorminvalue
				, 'revisorcomment' => $revisorcomment
				, 'revisorcriteria' => $revisorcriteria
				, 'revisoruser' => $revisoruser
				, 'totalmark' => $totalmark
				, 'totalaverage' => $totalaverage
				, 'totalmaxvalue' => $totalmaxvalue
				, 'totalminvalue' => $totalminvalue
				, 'totaluser' => $totaluser
				, 'totalcriteria' => $totalcriteria
				, 'totalrevisor' => $totalrevisor
			);
   		
				
		return $analisis_data;
   	}
   	
   	function delete_color($colorname){
   		//Comprobamos que existe y devuelve error si no
   		$check = $this->db->query("select * from color where color_name = '$colorname'");
   		if($check->result()->num_rows() == 0)
   			return "delete_color(): NONEXISTENT";
   		else
   			//Elimina la fuente de la base de datos
   		 	$this->db->delete('color', array('color_name' => $colorname));
   	}
}