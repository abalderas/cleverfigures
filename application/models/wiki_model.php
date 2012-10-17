<?php

//AVAILABLE METHODS
//	Wiki_model()
// 	name()
//    	connection()
//    	fetch()
//    	delete_wiki()


class Wiki_model extends CI_Model{
	
	//constructor
   	function Wiki_model(){
   	   	parent::__construct();
   	   	$this->load->helper('date');
   	   	$ci =& get_instance();
		$ci->load->model('connection_model');
   	}
   	
   	private function wconnection($wikiname){
   		$query = $this->db->query("select wiki_connection from wiki where wiki_name == $wikiname");
   		if($check->result()->num_rows() == 0)
   			return "connection(): ERR_NONEXISTENT";
   		else
   			foreach($check->result() as $row)
   				return $row->wiki_connection;
   	}
   	
   	function new_wiki($wikiname, $db_server, $db_name, $db_user, $db_password){
   		$my_con = $this->connection_model->new_connection($db_server, $db_name, $db_user, $db_password);
   		if(gettype($my_con) != "integer")
   			return "new_wiki(): $my_con";
   			
   		$check = $this->db->query("select * from wiki where wiki_name == $wikiname");
   		if($check->result()->num_rows() != 0)
   			return "new_wiki(): ERR_ALREADY_EXISTS";
   		else{
   			$sql = array('wiki_id' => "",
   				'wiki_name' => "$wikiname",
   				'wiki_connection' => "$my_con"
   				);
			$this->db->insert('wiki', $sql);
		
			if($this->db->affected_rows() != 1) 
				return "new_wiki(): ERR_AFFECTED_ROWS (".$this->db->affected_rows().")";
			else
				return  $this->db->insert_id();
		}
   	}
   	
   	function fetch_general_stats($wikiname){
   		//Establecemos conexión con la base de datos de la wiki
   		$link = $this->connection_model->connect($this->wconnection($wikiname));
   		
   		//Consultamos a la tabla de estadísticas
   		$result = $this->connection_model->query("SELECT * FROM site_stats") -> result();
   		
   		//Generamos un vector con los resultados.
   		foreach($result as $row){
   			$sql = array('wgen_id' => '',
   					'wgen_total_views' => "$row->ss_total_views",
   					'wgen_total_edits' => "$row->ss_total_edits",
   					'wgen_good_articles' => "$row->ss_good_articles",
   					'wgen_total_peges' => "$row->ss_total_pages",
   					'wgen_users' => "$row->ss_users",
   					'wgen_active_users' => "$row->ss_active_users",
   					'wgen_admins' => "$row->ss_admins",
   					'wgen_images' => "$row->ss_images",
   				);
			}
			
		//Lo insertamos en nuestro análisis
		$this->db->insert('wgeneral', $sql);
		
		//Comprobamos que la insertación se hizo con éxito
		if($this->db->affected_rows() != 1) 
			return "fetch_general_stats(): ERR_AFFECTED_ROWS (".$this->db->affected_rows().")";
		else 
			//Devuelve el id de la fila insertada para relacionarlo con la tabla análisis
			return $this->db->insert_id();
   	}
   	
   	function fetch_category_links($wikiname, $date_range_a => 'default', $date_range_b => 'default'){
   		//Establecemos conexión con la base de datos de la wiki
   		$link = $this->connection_model->connect($this->wconnection($wikiname));
   		
   		//Establecemos filtros de fecha
   		if($date_range_a == 'default'){
   			$initial_date = $this->connection_model->get_query($link, "SELECT rev_timestamp FROM revision ORDER BY rev_timestamp ASC LIMIT 1");
   			if($initial_date->num_rows() != 0)
   				foreach ($initial_date as $row)
   					$date_range_a = $row -> rev_timestamp;
   			else
   				return "fetch_linked_categories(): ERR_NONEXISTENT";
   		}
   		
   		if($date_range_b == 'default')
   			$date_range_b = date('Y-m-d H:i:s', now());
   		
   		//Consultamos
   		$result = $this->connection_model->query("SELECT cl_from, cl_to FROM categorylinks WHERE cl_from IN (SELECT DISTINCT rev_page FROM revision WHERE rev_timestamp >= $date_range_a and rev_timestamp <= $date_range_b)") -> result();
   		
   		//Generamos el vector a devolver
   		$data = array();
   		foreach ($result as $row)
   			$data[$row->cl_from][$row->cl_to] = true;
   		
   		//$data[1]['categoria1'] = true
   		//$data[45]['categoria1'] = true
   		//$data[32]['categoria2'] = true
   		//...
   		
   		//Devolvemos
   		return $data;
   		
   	}
   	
   	function fetch_categories($wikiname, $date_range_a => 'default', $date_range_b => 'default', $filter_page => 'total', $filter_user => 'total'){
   	
   		//Establecemos conexión con la base de datos de la wiki
   		$link = $this->connection_model->connect($this->wconnection($wikiname));
   		
   		//Establecemos filtros de fecha
   		if($date_range_a == 'default'){
   			$initial_date = $this->connection_model->get_query($link, "SELECT rev_timestamp FROM revision ORDER BY rev_timestamp ASC LIMIT 1");
   			if($initial_date->num_rows() != 0)
   				foreach ($initial_date as $row)
   					$date_range_a = $row -> rev_timestamp;
   			else
   				return "fetch_categories(): ERR_NONEXISTENT";
   		}
   		
   		if($date_range_b == 'default')
   			$date_range_b = date('Y-m-d H:i:s', now());
   		
   		//Establecemos filtros de usuario o página.
		if($filter_user != 'total'){
			$type = 'user';
			$filtername = $filter_user;
		}
		else if($filter_page != 'total'){
			$type = 'page';
			$filtername = $filter_page;
		}
		else{
			$type = 'total';
			$filtername = 'total';
		}
		
		
		if($type == 'page'){
			//Título de categoría, número de páginas y número de subcategorías para página en concreto
   			$cdata = $link->query("SELECT cat_title, cat_pages, cat_subcats FROM category, categorylinks WHERE cl_from == $filtername AND cl_to == cat_title AND $filtername IN (SELECT DISTINCT rev_page FROM revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b) ORDER BY cat_title ASC") -> result();
   			
   			//Número de ediciones, bytes y visitas para página en concreto
   			$cdata2 = $link->query("SELECT cl_to, count(rev_id) as edits, sum(page_len) as bytes, sum(page_counter) as visits FROM page, categorylinks, revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_page == page_id AND page_id == cl_from AND page_id == $filtername GROUP BY cl_to ORDER BY cl_to ASC") -> result();
   			
   			//Total de ediciones, bytes y visitas para página en concreto
   			$totals = $link->query("SELECT cl_to, count(rev_id) as totaledits, sum(page_len) as totalbytes, sum(page_counter) as totalvisits FROM page, categorylinks, revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_page == page_id AND page_id == cl_from AND page_id == $filtername ORDER BY cl_to ASC") -> result();
   		}
   		else if($type == 'user'){
   			//Título de categoría, número de páginas y número de subcategorías para usuario en concreto
			$cdata = $link->query("SELECT cat_title, cat_pages, cat_subcats FROM page, category WHERE page_id == cat_title AND page_namespace=14 AND page_id IN (SELECT DISTINCT rev_page FROM revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_user == $filtername)") -> result();
   		
   			//Número de ediciones, bytes y visitas para usuario en concreto
   			$cdata2 = $link->query("SELECT cl_to, count(rev_id) as edits, sum(page_len) as bytes, sum(page_counter) as visits FROM page, categorylinks, revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_page == page_id AND page_id == cl_from AND rev_user == $filtername GROUP BY cl_to ORDER BY cl_to ASC") -> result();
   			
   			//Total de ediciones, bytes y visitas para usuario en concreto
   			$totals = $link->query("SELECT cl_to, count(rev_id) as totaledits, sum(page_len) as totalbytes, sum(page_counter) as totalvisits FROM page, categorylinks, revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_page == page_id AND page_id == cl_from AND rev_user == $filtername ORDER BY cl_to ASC") -> result();
		}
		else{
			//Realizamos consultas según filtrado
			$cdata = $link->query("SELECT cat_title, cat_pages, cat_subcats FROM page, category WHERE page_id == cat_title AND page_namespace=14 AND page_id IN (SELECT DISTINCT rev_page FROM revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b)") -> result();
   		
   			//Número de ediciones, bytes y visitas
   			$cdata2 = $link->query("SELECT cl_to, count(rev_id) as edits, sum(page_len) as bytes, sum(page_counter) as visits FROM page, categorylinks, revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_page == page_id AND page_id == cl_from GROUP BY cl_to ORDER BY cl_to ASC") -> result();
   			
   			//Total de ediciones, bytes y visitas
   			$totals = $link->query("SELECT cl_to, count(rev_id) as totaledits, sum(page_len) as totalbytes, sum(page_counter) as totalvisits FROM page, categorylinks, revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_page == page_id AND page_id == cl_from ORDER BY cl_to ASC") -> result();
		}
   		
   		//Formamos los vectores a devolver con los datos de las consultas
   		foreach($cdata as $row){
   			$catpages[$row->cat_title] = $row->cat_pages;		//número de páginas
   			$catsubcats[$row->cat_title] = $row->cat_subcats;	//número de subcategorías
   		}
   		
   		foreach($cdata2 as $row){
   			$catedits[$row->cl_to] = $row->edits;			//número de ediciones
   			$catbytes[$row->cl_to] = $row->bytes;			//bytes
   			$catvisits[$row->cl_to] = $row->visits;			//número de visitas
   		}
   		
   		foreach($totals as $row){
   			$catedits_per[$row->cl_to] = $catedits[$row->cl_to]/$row->totaledits;		//porcentaje de ediciones sobre el total (depende del filtro)
   			$catbytes_per[$row->cl_to] = $catbytes[$row->cl_to]/$row->totalbytes;		//porcentaje de bytes sobre el total (depende del filtro)
   			$catvisits_per[$row->cl_to] = $catvisits[$row->cl_to]/$row->totalvisits;	//porcentaje de visitas sobre el total (depende del filtro)
   		}
   		
   		//Devolvemos conjunto de vectores con índices definidos
   		return array('catpages' => $catpages, 'catsubcats' => $catsubcats, 'catedits' => $catedits, 'catbytes' => $catbytes, 'catvisits' => $catvisits, 'catedits_per' => $catedits_per, 'catbytes_per' => $catbytes_per, 'catvisits_per' => $catvisits_per, 'cattype' => $type, 'catfiltername' => $filtername);
   	}
   	
   	function fetch_images($wikiname, $date_range_a => 'default', $date_range_b => 'default', $filter_page => 'total', $filter_user => 'total', $filter_category => 'total'){
   	
   		//Establecemos conexión con la base de datos de la wiki
   		$link = $this->connection_model->connect($this->wconnection($wikiname));
   		
   		//Establecemos filtros de fecha
   		if($date_range_a == 'default'){
   			$initial_date = $link->query("SELECT rev_timestamp FROM revision ORDER BY rev_timestamp ASC LIMIT 1");
   			if($initial_date->num_rows() != 0)
   				foreach ($initial_date as $row)
   					$date_range_a = $row -> rev_timestamp;
   			else
   				return "fetch_categories(): ERR_NONEXISTENT";
   		}
   		
   		if($date_range_b == 'default')
   			$date_range_b = date('Y-m-d H:i:s', now());
   		
   		//Establecemos filtros de usuario o página.
		if($filter_user != 'total'){
			$type = 'user';
			$filtername = $filter_user;
		}
		else if($filter_page != 'total'){
			$type = 'page';
			$filtername = $filter_page;
		}
		else if($filter_category != 'total'){
			$type = 'category';
			$filtername = $filter_category;
		}
		else{
			$type = 'total';
			$filtername = 'total';
		}
		
		//Realizamos consultas según filtrado
		if($type == 'page'){
			//nombre de imagen, descripcion, fecha y hora de subida, tamaño y usuario para página en concreto
   			$cdata = $link->query("SELECT img_name, img_user_text, img_timestamp, img_size, img_user FROM image, imagelinks WHERE img_name == il_to AND il_from == $filtername ORDER BY img_name ASC") -> result();
   		}
   		else if($type == 'user'){
   			//nombre de imagen, descripcion, fecha y hora de subida, tamaño y usuario para usuario en concreto
			$cdata = $link->query("SELECT img_name, img_user_text, img_timestamp, img_size, img_user FROM image WHERE img_user == $filtername ORDER BY img_name ASC") -> result();
		}
		else if($type == 'category'){
   			//nombre de imagen, descripcion, fecha y hora de subida, tamaño y usuario para categoría en concreto
			$cdata = $link->query("SELECT img_name, img_user_text, img_timestamp, img_size, img_user FROM image, imagelinks, categorylinks WHERE img_name == il_to AND il_from == cl_from AND cl_to == $filtername ORDER BY img_name ASC") -> result();
		}
		else{
			//nombre de imagen, descripcion, fecha y hora de subida, tamaño y usuario
			$cdata = $link->query("SELECT img_name, img_user_text, img_timestamp, img_size, img_user FROM image ORDER BY img_name ASC") -> result();
		}
   		
   		//Formamos los vectores a devolver con los datos de las consultas
   		foreach($cdata as $row){
   			$imgsizes[$row->img_name] = $row->img_size;
   			$imgtimes[$row->img_name] = $row->img_timestamp;	
   			$imgusers[$row->img_name] = $row->img_user;
   			$imgtexts[$row->img_name] = $row->img_user_text;
   		}
   		
   		//Devolvemos conjunto de vectores con índices definidos
   		return array('imgsizes' => $imgsizes, 'imgtimes' => $imgtimes, 'imgusers' => $imgusers, 'imgtexts' => $imgtexts);
   	}
   	
   	function fetch_users(){}/////////////////////////////////
   	
   	function delete_wiki(){
   		$check = $this->db->query("select * from Wiki where wiki_id == $this->wiki_id");
   		if($check->result()->num_rows() == 0)
   			die("delete_wiki(): Wiki $this->wiki_id doesn't exist.");
   		else
   		 	$this->db->delete('Wiki', array('wiki_id' => $this->wiki_id));
   	}
}

?> 
