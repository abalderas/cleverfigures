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




//AVAILABLE METHODS
// 	new_color()
// 	fetch_evaluations()
// 	wconnection()
// 	delete_color()


class Color_model extends CI_Model{
	
	
   	function Color_model(){
   		//Llamamos al constructor heredado.
   	   	parent::__construct();
   	   	$this->load->database();
   	   	
   	   	//Cargamos models necesarios
   	   	$ci =& get_instance();
		$ci->load->model('connection_model');
   	}
   	
   	private function wconnection($colorname){
   		//Consultamos la conexión
   		$query = $this->db->query("select color_connection from color where color_name == $colorname");
   		
   		//Comprobamos que existe y devolvemos el id de conexión
   		if($check->result()->num_rows() == 0)
   			return "wconnection(): ERR_NONEXISTENT";
   		else
   			foreach($check->result() as $row)
   				return $row->color_connection;
   	}
   	
   	function get_color_list($username){
		//Consultamos la conexión
   		$query = $this->db->get_where('color, user-color', array('color.color_name' => 'user-color.color_name', 'user-color.user_username' => $username));
   		
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
   		$check = $this->db->query("select * from color where color_name == $colorname");
   		if($check->result()->num_rows() != 0)
   			return "new_color(): ERR_ALREADY_EXISTS";
   		else{
   			//Creamos el array a insertar, con la info de la fuente e insertamos
   			$sql = array('color_id' => "",
   				'color_name' => "$colorname",
   				'color_connection' => "$my_con"
   				);
			$this->db->insert('color', $sql);
		
			//Si no hay error de inserción, devolvemos el id de la fuente
			if($this->db->affected_rows() != 1) 
				return "new_color(): ERR_AFFECTED_ROWS (".$this->db->affected_rows().")";
			else
				return  $this->db->insert_id();
		}
   	}
   	
   	function fetch_evaluations($colorname, $date_range_a = 'total', $date_range_b = 'total', $filter_user = 'total'){
   	
   		//Establecemos conexión con la base de datos de la fuente
   		$link = $this->connection_model->connect($this->wconnection($colorname));
   		
   		//Establecemos filtros de fecha
   		if($date_range_a == 'total'){
   			$initial_date = $link->query($link, "SELECT eva_time FROM evaluaciones ORDER BY rev_timestamp ASC LIMIT 1")->result();
   			if($initial_date->num_rows() != 0)
   				foreach ($initial_date as $row)
   					$date_range_a = $row -> rev_timestamp;
   			else
   				return "fetch_evaluations(): ERR_NONEXISTENT";
   		}
   		
   		if($date_range_b == 'total')
   			$date_range_b = date('Y-m-d H:i:s', now());
   		
   		//Establecemos filtros de página o categoría.
		if($filter_user != 'total'){
			$type = 'user';
			$filtername = $filter_category;
		}
		else{
			$type = 'total';
			$filtername = 'total';
		}
		
		//Aplicamos los filtros
		if($type == 'user'){
   			$cdata = $link->query("SELECT eva_user, count(eva_id) as neval FROM evaluaciones WHERE eva_user == $filtername AND eva_time >= $date_range_a AND eva_time <= $date_range_b LIMIT 1")->result();
   			$cdata2 = $link->query("SELECT eva_user, avg(ee_nota) as avg_mark FROM evaluaciones, evaluaciones-entregables WHERE evaluaciones-entregables.eva_id == evaluaciones.eva_id AND eva_user == $filtername AND eva_time >= $date_range_a AND eva_time <= $date_range_b LIMIT 1")->result();
   			$cdata3 = $link->query("SELECT eva_user, count(rep_id) as replies_in FROM evaluaciones, replies WHERE rep_id == eva_id AND eva_user == $filtername AND eva_time >= $date_range_a AND eva_time <= $date_range_b LIMIT 1")->result();
   			$cdata4 = $link->query("SELECT eva_user, count(rep_id) as replies_out FROM evaluaciones, replies WHERE rep_id == eva_id AND eva_revisor == $filtername AND eva_time >= $date_range_a AND eva_time <= $date_range_b LIMIT 1")->result();
   		}
   		else{
			$cdata = $link->query("SELECT eva_user, count(eva_id) as neval FROM evaluaciones WHERE eva_time >= $date_range_a AND eva_time <= $date_range_b GROUP BY eva_user")->result();
   			$cdata2 = $link->query("SELECT eva_user, avg(ee_nota) as avg_mark FROM evaluaciones, evaluaciones-entregables WHERE evaluaciones-entregables.eva_id == evaluaciones.eva_id AND eva_time >= $date_range_a AND eva_time <= $date_range_b GROUP BY eva_user")->result();
   			$cdata3 = $link->query("SELECT eva_user, count(rep_id) as replies_in FROM evaluaciones, replies WHERE rep_id == eva_id AND eva_time >= $date_range_a AND eva_time <= $date_range_b GROUP BY eva_user")->result();
   		}
   		
   		//Formamos las variables a devolver con los datos de las consultas y devolvemos los datos
   		foreach($cdata as $row)
   			$neval[$row->eva_user] = $row->neval;
   		
   		foreach($cdata2 as $row)
   			$avg_mark[$row->eva_user] = $row->avg_mark;
   		
   		foreach($cdata3 as $row)
   			$rep_in[$row->eva_user] = $row->replies_in;
   		
   		if(isset($cdata4)){
			foreach($cdata4 as $row)
				$rep_out[$row->eva_user] = $row->replies_out;
				
			return array('neval' => $neval, 'avg_mark' => $avg_mark, 'rep_in' => $rep_in, 'rep_out' => $rep_out);
		}
		else
			return array('neval' => $neval, 'avg_mark' => $avg_mark, 'rep_in' => $rep_in);
   		
   	}
   	
   	function fetch_quality_evolution($colorname, $filter_user = 'default'){
   	
   		//Establecemos conexión con la base de datos de la fuente
   		$link = $this->connection_model->connect($this->wconnection($colorname));
   		
   		if($filter_user != 'default'){
			$type = 'user';
			$filtername = $filter_category;
		}
		else{
			$type = 'default';
			$filtername = 'default';
		}
		
		//Aplicamos los filtros
		if($type == 'user'){
   			$cdata2 = $linkc->query("SELECT eva_revision, avg(ee_nota) as average FROM evaluaciones, evaluaciones_entregables WHERE eva_id == evaluaciones_entregables.eva_id AND eva_user == $filtername GROUP BY eva_revision") -> result();
   		}
   		else{
			$cdata2 = $linkc->query("SELECT eva_revision, avg(ee_nota) as average FROM evaluaciones, evaluaciones_entregables WHERE eva_id == evaluaciones_entregables.eva_id GROUP BY eva_revision") -> result();
   		}
   		
   		//Formamos las variables a devolver con los datos de las consultas y devolvemos los datos
   		foreach($cdata2 as $row)
			$qualityevolution[$row->eva_revision] = $row->average;
			
		return $qualityevolution;
   		
   	}
   	
   	function fetch_activity($colorname, $date_range_a = 'default', $date_range_b = 'default', $filter_user = 'default'/*, $filter_page = 'default', $filter_category = 'default'*/){
		//Establecemos conexión con las bases de datos
   		$link = $this->connection_model->connect($this->wconnection($colorname));
   		
   		//Establecemos filtros de fecha
   		if($date_range_a == 'default'){
   			$initial_date = $link->query("SELECT eva_time FROM evaluaciones ORDER BY eva_time ASC LIMIT 1")->result();
   			if($initial_date->num_rows() != 0)
   				foreach ($initial_date as $row)
   					$date_range_a = $row -> rev_timestamp;
   			else
   				return "fetch_activity(): ERR_NONEXISTENT";
   		}
   		
   		if($date_range_b == 'default')
   			$date_range_b = date('Y-m-d H:i:s', now());
   		
   		//Establecemos filtros de página o categoría.
		if($filter_user != 'default'){
			$type = 'user';
			$filtername = $filter_page;
		}/*
		else if($filter_page != 'default'){
			$type = 'page';
			$filtername = $filter_category;
		}
		else if($filter_category != 'default'){
			$type = 'category';
			$filtername = $filter_category;
		}*/
		else{
			$type = 'default';
			$filtername = 'default';
		}
		
		
		if($type == 'user'){
			//Fecha y bytes para un usuario concreto
   			$cdata = $link->query("SELECT eva_time FROM evaluaciones WHERE eva_user == $filtername AND eva_time >= $date_range_a AND eva_time <= $date_range_b ORDER BY eva_time ASC") -> result();
   		}/*
   		else if($type == 'page'){
			//Fecha y bytes para una página concreta
   			$cdata = $link->query("SELECT rev_timestamp FROM revision WHERE rev_page == $filtername AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY rev_timestamp ASC") -> result();
   			$cdata2 = false;
   			$cdata3 = false;
   		}
   		else if($type == 'category'){
			//Fecha y bytes para una categoría concreta
   			$cdata = $link->query("SELECT rev_timestamp FROM revision, categorylinks WHERE rev_page == cl_from AND cl_to ==  $filtername AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY rev_timestamp ASC") -> result();
   			$cdata2 = $link->query("SELECT rev_timestamp FROM revision, categorylinks, page WHERE rev_page == page_id AND page_namespace == 0 AND rev_page == cl_from AND cl_to ==  $filtername AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY rev_timestamp ASC") -> result();
   			$cdata2 = $link->query("SELECT rev_timestamp FROM revision, categorylinks, page WHERE rev_page == page_id AND page_namespace == 1 AND rev_page == cl_from AND cl_to ==  $filtername AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY rev_timestamp ASC") -> result();
   		}*/
		else{
			//Fecha y bytes totales
   			$cdata = $link->query("SELECT eva_time FROM evaluaciones WHERE eva_time >= $date_range_a AND eva_time <= $date_range_b ORDER BY eva_time ASC") -> result();
   		}
   		
   		//Formamos los vectores a devolver con los datos de las consultas
   		foreach($cdata as $row)
   			$totalactivity[] = $row->rev_timestamp;
   			
   		//Devolvemos conjunto de vectores con índices definidos
   		return $totalactivity;
   	}
   	
   	function delete_color($colorname){
   		//Comprobamos que existe y devuelve error si no
   		$check = $this->db->query("select * from color where color_name == $colorname");
   		if($check->result()->num_rows() == 0)
   			return "delete_color(): NONEXISTENT";
   		else
   			//Elimina la fuente de la base de datos
   		 	$this->db->delete('color', array('color_name' => $colorname));
   	}
}