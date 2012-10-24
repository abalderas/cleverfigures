<?php

//AVAILABLE METHODS
// 	new_color()
// 	fetch_evaluations()
// 	wconnection()
// 	delete_color()


class Color_model extends CI_Model{
	
	
   	function Color_model(){
   		//Llamamos al constructor heredado.
   	   	parent::__construct();
   	   	
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
   			$initial_date = $link->query($link, "SELECT rev_timestamp FROM revision ORDER BY rev_timestamp ASC LIMIT 1")->result();
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

?> 
