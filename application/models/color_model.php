<?php

//AVAILABLE METHODS
// 	new_color()
// 	fetch_categories()
// 	wconnection()
// 	fetch_category_links()
// 	fetch_general_stats()
// 	fetch_images()
// 	fetch_pages()
// 	fetch_users()
// 	delete_color()


class Color_model extends CI_Model{
	
	
   	function Color_model(){
   		//Llamamos al constructor heredado.
   	   	parent::__construct();
   	   	
   	   	//Cargamos helpers
   	   	$this->load->helper('date');
   	   	
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
   	
   	function fetch_evaluations($colorname, $date_range_a => 'total', $date_range_b => 'total', $filter_user => 'total', $filter_page => 'total', $filter_category => 'total'){
   	
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
		if($filter_page != 'total'){
			$type = 'page';
			$filtername = $filter_page;
		}
		else if($filter_category != 'total'){
			$type = 'category';
			$filtername = $filter_category;
		}
		else if($filter_user != 'total'){
			$type = 'user';
			$filtername = $filter_category;
		}
		else{
			$type = 'total';
			$filtername = 'total';
		}
		
		
		if($type == 'page'){
			$cdata = $link->query("")->result();
   		}
   		else if($type == 'category'){
   			$cdata = $link->query("")->result();
   		}
   		else if($type == 'user'){
   			$cdata = $link->query("")->result();
   		}
		else{
			$cdata = $link->query("")->result();
   		}
   		
   		//Formamos los vectores a devolver con los datos de las consultas
   		foreach($cdata as $row){
   			$userrealname[$row->user_name] = $row->user_real_name;		//nombre real
   			$userreg[$row->user_name] = $row->user_registration;		//fecha de registro
   		}
   		
   		foreach($cdata2 as $row){
   			$useredits[$row->user_name] = $row->edits;			//número de ediciones
   			$userbytes[$row->user_name] = $row->bytes;			//bytes
   		}
   		
   		//Devolvemos conjunto de vectores con índices definidos
   		return array('userrealname' => $userrealname, 'userreg' => $userreg, 'useredits' => $useredits, 'userbytes' => $userbytes, 'useruploads' => $useruploads, 'useredits_per' => $useredits_per, 'userbytes_per' => $userbytes_per, 'useruploads_per' => $useruploads_per);
   	}
   	
   	function delete_color(){
   		//Comprobamos que existe y devuelve error si no
   		$check = $this->db->query("select * from color where color_id == $this->color_id");
   		if($check->result()->num_rows() == 0)
   			die("delete_color(): color $this->color_id doesn't exist.");
   		else
   			//Elimina la fuente de la base de datos
   		 	$this->db->delete('color', array('color_id' => $this->color_id));
   	}
}

?> 
