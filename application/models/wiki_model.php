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
// 	new_wiki()
// 	fetch_categories()
// 	wconnection()
// 	fetch_category_links()
// 	fetch_general_stats()
// 	fetch_images()
// 	fetch_pages()
// 	fetch_users()
// 	delete_wiki()


class Wiki_model extends CI_Model{
	
	
   	function Wiki_model(){
   		//Llamamos al constructor heredado.
   	   	parent::__construct();
   	   	$this->load->database();
   	   	
   	   	//Cargamos models necesarios
   	   	$ci =& get_instance();
		$ci->load->model('connection_model');
   	}
   	
   	private function wconnection($wikiname){
   		//Consultamos la conexión
   		$query = $this->db->query("select wiki_connection from wiki where wiki_name == $wikiname");
   		
   		//Comprobamos que existe y devolvemos el id de conexión
   		if(!$query->result())
   			return "connection(): ERR_NONEXISTENT";
   		else
   			foreach($check->result() as $row)
   				return $row->wiki_connection;
   	}
   	
   	function get_wiki_list($username){
		//Consultamos la conexión
   		$query = $this->db->get_where('wiki, user-wiki', array('wiki.wiki_name' => 'user-wiki.wiki_name', 'user-wiki.user_username' => $username));
   		//Comprobamos que existe y devolvemos el id de conexión
   		if(!$query->result())
   			return array();
   		else
   			foreach($query->result() as $row)
   				$wikis[$row->wiki_name] = $row->wiki_name;
   				
   		return $wikis;
   	}
   	
   	function new_wiki($wikiname, $db_server, $db_name, $db_user, $db_password){
   		//Creamos una nueva conexión
   		$my_con = $this->connection_model->new_connection($db_server, $db_name, $db_user, $db_password);
   		
   		//Si hay error, devolvemos el mensaje de error
   		if(gettype($my_con) != "integer")
   			return "new_wiki(): $my_con";
   		
   		//Consultamos si la wiki ya existe, si es así devolvemos error
   		$check = $this->db->query("select * from wiki where wiki_name == $wikiname");
   		if($check->result()->num_rows() != 0)
   			return "new_wiki(): ERR_ALREADY_EXISTS";
   		else{
   			//Creamos el array a insertar, con la info de la wiki e insertamos
   			$sql = array('wiki_id' => "",
   				'wiki_name' => "$wikiname",
   				'wiki_connection' => "$my_con"
   				);
			$this->db->insert('wiki', $sql);
		
			//Si no hay error de inserción, devolvemos el id de la wiki
			if($this->db->affected_rows() != 1) 
				return "new_wiki(): ERR_AFFECTED_ROWS (".$this->db->affected_rows().")";
			else
				return  $this->db->insert_id();
		}
   	}
   	
   	function fetch_categories($wikiname, $date_range_a = 'default', $date_range_b = 'default', $filter_page = 'total', $filter_user = 'total'){
   	
   		//Establecemos conexión con la base de datos de la wiki
   		$link = $this->connection_model->connect($this->wconnection($wikiname));
   		
   		//Establecemos filtros de fecha
   		if($date_range_a == 'default'){
   			$initial_date = $link->query($link, "SELECT rev_timestamp FROM revision ORDER BY rev_timestamp ASC LIMIT 1")->result();
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
   			$cdata = $link->query("SELECT cat_title, cat_pages, cat_subcats FROM category, categorylinks, revision WHERE cl_from = $filtername AND cl_to = cat_title AND $filtername IN (SELECT DISTINCT rev_page FROM revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b) ORDER BY cat_title ASC") -> result();
   			
   			$cdata1 = $link->query("SELECT cat_title, sum(cat_pages) as totalpages FROM category, categorylinks, revision WHERE cl_from = $filtername AND cl_to = cat_title AND $filtername IN (SELECT DISTINCT rev_page FROM revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b) GROUP BY cat_title") -> result();
   			
   			//Número de ediciones, bytes y visitas para página en concreto
   			$cdata2 = $link->query("SELECT cl_to, count(rev_id) as edits, page_len as bytes, page_counter as visits FROM page, categorylinks, revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_page = page_id AND page_id = cl_from AND page_id = $filtername GROUP BY cl_to ORDER BY cl_to ASC") -> result();
   			
   			//Total de ediciones, bytes y visitas para página en concreto
   			$totals = $link->query("SELECT cl_to, count(rev_id) as totaledits, sum(page_len) as totalbytes, sum(page_counter) as totalvisits FROM revision, categorylinks, page WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND page_id = rev_page AND  rev_page = cl_from AND cl_to in (SELECT cl_to FROM categorylinks WHERE cl_from = $filtername) GROUP BY cl_to ORDER BY cl_to ASC") -> result();
   		}
   		else if($type == 'user'){
   			//Título de categoría, número de páginas y número de subcategorías para usuario en concreto
			$cdata = $link->query("SELECT DISTINCT cat_title, cat_pages, cat_subcats FROM categorylinks, category, revision WHERE cl_to = cat_title AND cl_from IN (SELECT DISTINCT rev_page FROM revision WHERE rev_user = $filtername AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b)") -> result();
			
			$cdata1 = $link->query("SELECT cat_title, sum(cat_pages) as totalpages FROM category WHERE $filtername IN (SELECT DISTINCT rev_user FROM revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b) GROUP BY cat_title") -> result();
   		
   			//Número de ediciones, bytes y visitas para usuario en concreto
   			$cdata2 = $link->query("SELECT cl_to, count(rev_id) as edits, page_len as bytes, page_counter as visits FROM categorylinks, revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_user = $filtername AND rev_page = cl_from GROUP BY cl_to ORDER BY cl_to ASC") -> result();
   			
   			//Total de ediciones, bytes y visitas para usuario en concreto
   			$totals = $link->query("SELECT cl_to, count(rev_id) as totaledits, sum(page_len) as totalbytes, sum(page_counter) as totalvisits FROM revision, categorylinks WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_user = $filtername AND cl_from = rev_page AND cl_to GROUP BY cl_to ORDER BY cl_to ASC") -> result();
		}
		else{
			//Realizamos consultas según filtrado
			$cdata = $link->query("SELECT DISTINCT cat_title, cat_pages, cat_subcats FROM categorylinks, category, revision WHERE cl_to = cat_title AND cl_from IN (SELECT DISTINCT rev_page FROM revision WHERE rev_user = $filtername AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b)") -> result();
			
			$cdata1 = $link->query("SELECT cat_title, sum(cat_pages) as totalpages FROM category, categorylinks, revision WHERE cl_to == cat_title AND cl_from IN (SELECT DISTINCT rev_page FROM revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b) GROUP BY cat_title") -> result();
   		
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
   		
   		foreach($cdata1 as $row){
   			$catpages_per[$row->cl_to] = $catpages[$row->cl_to] / $row->totalpages;
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
   		return array('catpages_per' => $catpages_per, 'catpages' => $catpages, 'catsubcats' => $catsubcats, 'catedits' => $catedits, 'catbytes' => $catbytes, 'catvisits' => $catvisits, 'catedits_per' => $catedits_per, 'catbytes_per' => $catbytes_per, 'catvisits_per' => $catvisits_per, 'filtertype' => $type, 'filtername' => $filtername);
   	}
   	
   	function fetch_images($wikiname, $date_range_a = 'default', $date_range_b = 'default', $filter_page = 'total', $filter_user = 'total', $filter_category = 'total'){
   	
   		//Establecemos conexión con la base de datos de la wiki
   		$link = $this->connection_model->connect($this->wconnection($wikiname));
   		
   		//Establecemos filtros de fecha
   		if($date_range_a == 'default'){
   			$initial_date = $link->query($link, "SELECT rev_timestamp FROM revision ORDER BY rev_timestamp ASC LIMIT 1")->result();
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
   		return array('imgsizes' => $imgsizes, 'imgtimes' => $imgtimes, 'imgusers' => $imgusers, 'imgtexts' => $imgtexts, 'filtertype' => $type, 'filtername' => $filtername);
   	}
   	
   	function fetch_users($wikiname, $date_range_a = 'default', $date_range_b = 'default', $filter_page = 'total', $filter_category = 'total'){
   	
   		//Establecemos conexión con la base de datos de la wiki
   		$link = $this->connection_model->connect($this->wconnection($wikiname));
   		
   		//Establecemos filtros de fecha
   		if($date_range_a == 'default'){
   			$initial_date = $link->query($link, "SELECT rev_timestamp FROM revision ORDER BY rev_timestamp ASC LIMIT 1")->result();
   			if($initial_date->num_rows() != 0)
   				foreach ($initial_date as $row)
   					$date_range_a = $row -> rev_timestamp;
   			else
   				return "fetch_users(): ERR_NONEXISTENT";
   		}
   		
   		if($date_range_b == 'default')
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
		else{
			$type = 'total';
			$filtername = 'total';
		}
		
		
		if($type == 'page'){
			//Nombre de usuario, nombre real y fecha de registro para una página en concreto
   			$cdata = $link->query("SELECT user_name, user_real_name, user_registration FROM user, revision WHERE user_id == rev_user AND rev_page == $filtername AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY user_name ASC") -> result();
   			
   			//Número de ediciones y bytes para página en concreto
   			$cdata2 = $link->query("SELECT user_name, count(rev_id) as edits, sum(rev_len) as bytes FROM user, revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_page == $filtername AND rev_user == user_id GROUP BY user_name ORDER BY user_name ASC") -> result();
   			
   			//Este no se usará, lo creamos para poder incluirlo en el resultado y mantener la estructura del array devuelto
   			$cdata22 = array();
   			
   			//Número de uploads para página en concreto
   			$cdata3 = $link->query("SELECT user_name, count(img_id) FROM user, image, imagelinks WHERE user_id == img_user AND img_name == il_to AND il_from == $filtername AND img_timestamp>=$date_range_a AND img_timestamp<=$date_range_b GROUP BY user_name ORDER BY user_name ASC") -> result();
   			
   			//Total de ediciones y bytes para página en concreto
   			$totals = $link->query("SELECT user_name, count(rev_id) as totaledits, page_len as totalbytes FROM user, page, revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_page == page_id AND page_id == $filtername AND rev_user == user_id ORDER BY user_name LIMIT 1") -> result();
   			
   			//Número de uploads para página en concreto
   			$totaluploads = $link->query("SELECT count(img_id) as totalimages FROM page, image, imagelinks WHERE img_timestamp>=$date_range_a AND img_timestamp<=$date_range_b AND img_name == il_to AND il_from == $filtername LIMIT 1") -> result();
   		}
   		else if($type == 'category'){
			//Nombre de usuario, nombre real y fecha de registro para una categoría en concreto
   			$cdata = $link->query("SELECT user_name, user_real_name, user_registration FROM user, revision, categorylinks WHERE user_id == rev_user AND rev_page == cl_from AND cl_to == $filtername AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY user_name ASC") -> result();
   			
   			//Número de ediciones y bytes para categoría en concreto
   			$cdata2 = $link->query("SELECT user_name, count(rev_id) as edits, sum(rev_len) as bytes FROM user, revision, categorylinks WHERE rev_user == user_id AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_page == cl_from AND cl_to == $filtername GROUP BY user_name ORDER BY user_name ASC") -> result();
   			
   			//Número de ediciones y bytes de artículos para categoría en concreto
   			$cdata22 = $link->query("SELECT user_name, count(rev_id) as edits, sum(rev_len) as bytes FROM user, revision, categorylinks, page WHERE rev_user == user_id AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_page == cl_from AND cl_to == $filtername AND rev_page == page_id AND page_namespace == 0 GROUP BY user_name ORDER BY user_name ASC") -> result();
   			
   			$cdata22 = $link->query("SELECT user_name, count(rev_id) as edits, sum(rev_len) as bytes FROM user, revision, page WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_page == $filtername AND rev_user == user_id AND rev_page == page_id AND page_namespace == 0 GROUP BY user_name ORDER BY user_name ASC") -> result();
   			
   			//Número de uploads para categoría en concreto
   			$cdata3 = $link->query("SELECT user_name, count(img_id) FROM user, image, imagelinks, categorylinks, revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_user == user_id AND user_id == img_user AND img_name == il_to AND il_from == cl_from AND cl_to == $filtername AND img_timestamp>=$date_range_a AND img_timestamp<=$date_range_b GROUP BY user_name ORDER BY user_name ASC") -> result();
   			
   			//Total de ediciones y bytes para categoría en concreto
   			$totals = $link->query("SELECT user_name, count(rev_id) as totaledits, sum(page_len) as totalbytes FROM user, page, revision, categorylinks WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_page == page_id AND page_id == cl_from AND cl_to == $filtername AND rev_user == user_id ORDER BY user_name LIMIT 1") -> result();
   			
   			//Número de uploads para categoría en concreto
   			$totaluploads = $link->query("SELECT user_name, count(img_id) as totalimages FROM user, categorylinks, image, imagelinks, revision WHERE img_name == il_to AND il_from == cl_from AND cl_to == $filtername AND img_timestamp>=$date_range_a AND img_timestamp<=$date_range_b AND img_user == user_id  LIMIT 1") -> result();
   		}
		else{
			//Nombre de usuario, nombre real y fecha de registro
   			$cdata = $link->query("SELECT user_name, user_real_name, user_registration FROM user, revision WHERE user_id == rev_user AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY user_name ASC") -> result();
   			
   			//Número de ediciones y bytes
   			$cdata2 = $link->query("SELECT user_name, count(rev_id) as edits, sum(rev_len) as bytes FROM user, revision WHERE rev_user == user_id AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b GROUP BY user_name ORDER BY user_name ASC") -> result();
   			
   			//Número de ediciones y bytes de artículos
   			$cdata22 = $link->query("SELECT user_name, count(rev_id) as edits, sum(rev_len) as bytes FROM user, revision, page WHERE rev_user == user_id AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b GROUP BY user_name AND rev_page == page_id AND page_namespace == 0 ORDER BY user_name ASC") -> result();
   			
   			//Número de uploads
   			$cdata3 = $link->query("SELECT user_name, count(img_id) as images FROM user, image WHERE user_id == img_user AND img_timestamp>=$date_range_a AND img_timestamp<=$date_range_b GROUP BY user_name ORDER BY user_name ASC") -> result();
   			
   			//Total de ediciones y bytes
   			$totals = $link->query("SELECT user_name, count(rev_id) as totaledits, sum(page_len) as totalbytes FROM user, page, revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_page == page_id AND rev_user == user_id ORDER BY user_name") -> result();
   			
   			//Número de uploads
   			$totaluploads = $link->query("SELECT user_name, count(img_id) as totalimages FROM user, image WHERE img_timestamp>=$date_range_a AND img_timestamp<=$date_range_b AND img_user == user_id ORDER BY user_name") -> result();
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
   		
   		foreach($cdata22 as $row){
   			$useredits_art[$row->user_name] = $row->edits;			//número de ediciones de artículos
   			$userbytes_art[$row->user_name] = $row->bytes;			//bytes de artículos
   		}
   		
   		foreach($cdata3 as $row){
   			$useruploads[$row->user_name] = $row->images;			//número de visitas
   		}
   		
   		foreach($totals as $row){
   			$useredits_per[$row->user_name] = $useredits[$row->user_name]/$row->totaledits;			//porcentaje de ediciones sobre el total (depende del filtro)
   			$userbytes_per[$row->user_name] = $userbytes[$row->user_name]/$row->totalbytes;			//porcentaje de bytes sobre el total (depende del filtro)
   			$useredits_art_per[$row->user_name] = $useredits_art[$row->user_name]/$row->totaledits;		//porcentaje de ediciones sobre el total (depende del filtro)
   			$userbytes_art_per[$row->user_name] = $userbytes_art[$row->user_name]/$row->totalbytes;		//porcentaje de bytes sobre el total (depende del filtro)
   		}
   		
   		foreach($totaluploads as $row){
   			$useruploads_per[$row->user_name] = $useruploads[$row->user_name]/$row->totalimages;	//porcentaje de uploads sobre el total (depende del filtro)
   		}
   		
   		//Devolvemos conjunto de vectores con índices definidos
   		return array('userrealname' => $userrealname, 'userreg' => $userreg, 'useredits' => $useredits, 'userbytes' => $userbytes, 'useruploads' => $useruploads, 'useredits_per' => $useredits_per, 'userbytes_per' => $userbytes_per, 'useredits_art' => $useredits_art, 'userbytes_art' => $userbytes_art, 'useredits_art_per' => $useredits_art_per, 'userbytes_art_per' => $userbytes_art_per, 'useruploads_per' => $useruploads_per, 'filtertype' => $type, 'filtername' => $filtername);
   	}
   	
   	function fetch_pages($wikiname, $date_range_a = 'default', $date_range_b = 'default', $filter_user = 'total'){
   	
   		//Establecemos conexión con la base de datos de la wiki
   		$link = $this->connection_model->connect($this->wconnection($wikiname));
   		
   		//Establecemos filtros de fecha
   		if($date_range_a == 'default'){
   			$initial_date = $link->query($link, "SELECT rev_timestamp FROM revision ORDER BY rev_timestamp ASC LIMIT 1")->result();
   			if($initial_date->num_rows() != 0)
   				foreach ($initial_date as $row)
   					$date_range_a = $row -> rev_timestamp;
   			else
   				return "fetch_pages(): ERR_NONEXISTENT";
   		}
   		
   		if($date_range_b == 'default')
   			$date_range_b = date('Y-m-d H:i:s', now());
   		
   		//Establecemos filtros de página o categoría.
		if($filter_user != 'total'){
			$type = 'user';
			$filtername = $filter_user;
		}
		else{
			$type = 'total';
			$filtername = 'total';
		}
		
		
		if($type == 'user'){
			//Nombre de página y namespace para un usuario en concreto
   			$cdata = $link->query("SELECT page_title, page_namespace FROM revision, page WHERE $filtername == rev_user AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_page == page_id ORDER BY page_title") -> result();
   			
   			//Número de ediciones, bytes y visitas para usuario en concreto
   			$cdata2 = $link->query("SELECT page_title, count(rev_id) as edits, sum(rev_len) as bytes, sum(page_counter) as visits FROM revision, page WHERE rev_user == $filtername AND rev_page == page_id AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b GROUP BY page_title ORDER BY page_title") -> result();
   			
   			//Número de uploads para usuario en concreto
   			$cdata3 = $link->query("SELECT page_title, count(img_id) as uploads FROM revision, image, page, imagelinks WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_user == img_user AND img_user == $filtername AND img_name == il_to AND il_from == page_id GROUP BY page_title ORDER BY page_title") -> result();
   			
   			//Total de ediciones, bytes y visitas
   			$totals = $link->query("SELECT page_title, count(rev_id) as edits, sum(rev_len) as bytes, sum(page_counter) as visits FROM revision, page WHERE rev_user == $filtername AND rev_page == page_id AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b LIMIT 1") -> result();
   			
   			//Total de uploads
   			$totaluploads = $link->query("SELECT page_title, count(img_id) as totaluploads FROM revision, image, page, imagelinks WHERE img_name == il_to AND il_from == page_id AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND rev_page == page_id AND rev_user == $filtername LIMIT 1") -> result();
   		}
		else{
			//Nombre de página y namespace para un usuario en concreto
   			$cdata = $link->query("SELECT page_title, page_namespace FROM revision, page WHERE rev_page == page_id AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY page_title") -> result();
   			
   			//Número de ediciones, bytes y visitas para usuario en concreto
   			$cdata2 = $link->query("SELECT page_title, count(rev_id) as edits, page_len as bytes, page_counter as visits FROM revision, page WHERE rev_page == page_id AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b GROUP BY page_title ORDER BY page_title") -> result();
   			
   			//Número de uploads para usuario en concreto
   			$cdata3 = $link->query("SELECT page_title, count(img_id) as uploads FROM revision, image, page, imagelinks WHERE rev_page == page_id AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b AND il_from == page_id AND il_to == img_name GROUP BY page_title ORDER BY page_title") -> result();
   			
   			//Total de ediciones, bytes y visitas
   			$totals = $link->query("SELECT page_title, count(rev_id) as totaledits, sum(page_len) as totalbytes, sum(page_counter) as totalvisits FROM revision, page WHERE rev_page == page_id AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY page_title") -> result();
   			
   			//Total de uploads
   			$totaluploads = $link->query("SELECT page_title, count(img_id) as totaluploads FROM image, imagelinks, revision WHERE rev_page == page_id AND page_id == il_from AND il_to == img_name AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY page_title") -> result();
   		}
   		
   		//Formamos los vectores a devolver con los datos de las consultas
   		foreach($cdata as $row){
   			$pagenamespace[$row->page_name] = $row->page_namespace;		//nombre real
   		}
   		
   		foreach($cdata2 as $row){
   			$pageedits[$row->page_name] = $row->edits;			//número de ediciones
   			$pagebytes[$row->page_name] = $row->bytes;			//bytes
   			$pagevisits[$row->page_name] = $row->visits;			//número de visitas
   		}
   		
   		foreach($cdata3 as $row){
   			$pageuploads[$row->page_name] = $row->uploads;			//número de uploads
   		}
   		
   		foreach($totals as $row){
   			$pageedits_per[$row->page_name] = $pageedits[$row->page_name]/$row->totaledits;		//porcentaje de ediciones sobre el total (depende del filtro)
   			$pagebytes_per[$row->page_name] = $pagebytes[$row->page_name]/$row->totalbytes;		//porcentaje de bytes sobre el total (depende del filtro)
   		}
   		
   		foreach($totaluploads as $row){
   			$pageuploads_per[$row->page_name] = $pageuploads[$row->page_name]/$row->totalvisits;	//porcentaje de visitas sobre el total (depende del filtro)
   		}
   		
   		//Devolvemos conjunto de vectores con índices definidos
   		return array('pagenamespace' => $pagenamespace, 'pageedits' => $pageedits, 'pagebytes' => $pagebytes, 'pagevisits' => $pagevisits, 'pageuploads' => $pageuploads, 'pageedits_per' => $pageedits_per, 'pagebytes_per' => $pagebytes_per, 'pageuploads_per' => $pageuploads_per, 'filtertype' => $type, 'filtername' => $filtername);
   	}
   	
   	
   	function fetch_content_evolution($wikiname, $date_range_a = 'default', $date_range_b = 'default', $filter_user = 'total', $filter_page = 'default', $filter_category = 'default'){
		//Establecemos conexión con las bases de datos
   		$link = $this->connection_model->connect($this->wconnection($wikiname));
   		
   		//Establecemos filtros de fecha
   		if($date_range_a == 'default'){
   			$initial_date = $link->query($link, "SELECT rev_timestamp FROM revision ORDER BY rev_timestamp ASC LIMIT 1")->result();
   			if($initial_date->num_rows() != 0)
   				foreach ($initial_date as $row)
   					$date_range_a = $row -> rev_timestamp;
   			else
   				return "fetch_content_evolution(): ERR_NONEXISTENT";
   		}
   		
   		if($date_range_b == 'default')
   			$date_range_b = date('Y-m-d H:i:s', now());
   		
   		//Establecemos filtros de página o categoría.
		if($filter_user != 'default'){
			$type = 'user';
			$filtername = $filter_page;
		}
		else if($filter_page != 'default'){
			$type = 'page';
			$filtername = $filter_category;
		}
		else if($filter_category != 'default'){
			$type = 'category';
			$filtername = $filter_category;
		}
		else{
			$type = 'default';
			$filtername = 'default';
		}
		
		
		if($type == 'user'){
			//Fecha y bytes para un usuario concreto
   			$cdata = $link->query("SELECT rev_timestamp, rev_len FROM revision WHERE rev_user == $filtername AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY rev_timestamp ASC") -> result();
   		}
   		else if($type == 'page'){
			//Fecha y bytes para una página concreta
   			$cdata = $link->query("SELECT rev_timestamp, rev_len FROM revision WHERE rev_page == $filtername AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY rev_timestamp ASC") -> result();
   		}
   		else if($type == 'category'){
			//Fecha y bytes para una categoría concreta
   			$cdata = $link->query("SELECT rev_timestamp, rev_len FROM revision, categorylinks WHERE rev_page == cl_from AND cl_to ==  $filtername AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY rev_timestamp ASC") -> result();
   		}
		else{
			//Fecha y bytes totales
   			$cdata = $link->query("SELECT rev_timestamp, rev_len FROM revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY rev_timestamp ASC") -> result();
   		}
   		
   		//Formamos los vectores a devolver con los datos de las consultas
   		foreach($cdata as $row)
   			$contentevolution[$row->rev_timestamp] = $row->rev_len;
   			
   		//Devolvemos conjunto de vectores con índices definidos
   		return $contentevolution;
   	}  	
   	
   	function fetch_activity($wikiname, $date_range_a = 'default', $date_range_b = 'default', $filter_user = 'default', $filter_page = 'default', $filter_category = 'default'){
		//Establecemos conexión con las bases de datos
   		$link = $this->connection_model->connect($this->wconnection($wikiname));
   		
   		//Establecemos filtros de fecha
   		if($date_range_a == 'default'){
   			$initial_date = $link->query($link, "SELECT rev_timestamp FROM revision ORDER BY rev_timestamp ASC LIMIT 1")->result();
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
		}
		else if($filter_page != 'default'){
			$type = 'page';
			$filtername = $filter_category;
		}
		else if($filter_category != 'default'){
			$type = 'category';
			$filtername = $filter_category;
		}
		else{
			$type = 'default';
			$filtername = 'default';
		}
		
		
		if($type == 'user'){
			//Fecha y bytes para un usuario concreto
   			$cdata = $link->query("SELECT rev_timestamp FROM revision WHERE rev_user == $filtername AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY rev_timestamp ASC") -> result();
   			$cdata2 = $link->query("SELECT rev_timestamp FROM revision, page WHERE rev_user == $filtername AND rev_page == page_id AND page_namespace == 0 AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY rev_timestamp ASC") -> result();
   			$cdata3 = $link->query("SELECT rev_timestamp FROM revision, page WHERE rev_user == $filtername AND rev_page == page_id AND page_namespace == 1 AND rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY rev_timestamp ASC") -> result();
   		}
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
   		}
		else{
			//Fecha y bytes totales
   			$cdata = $link->query("SELECT rev_timestamp FROM revision WHERE rev_timestamp>=$date_range_a AND rev_timestamp<=$date_range_b ORDER BY rev_timestamp ASC") -> result();
   		}
   		
   		//Formamos los vectores a devolver con los datos de las consultas
   		foreach($cdata as $row)
   			$totalactivity[] = $row->rev_timestamp;
   		
   		if($cdata2)
			foreach($cdata2 as $row)
				$articleactivity[] = $row->rev_timestamp;
   			
   		if($cdata3)
			foreach($cdata3 as $row)
				$talkactivity[] = $row->rev_timestamp;
   			
   		//Devolvemos conjunto de vectores con índices definidos
   		return array('totalactivity' => $totalactivity, 'articleactivity' => $articleactivity, 'talkactivity' => $talkactivity);
   	}  	
   	
   	function delete_wiki($wikiname){
   		//Comprobamos que existe y devuelve error si no
   		$check = $this->db->query("select * from wiki where wiki_name == $wikiname");
   		if($check->result()->num_rows() == 0)
   			return "delete_wiki(): NONEXISTENT";
   		else
   			//Elimina la wiki de la base de datos
   		 	$this->db->delete('wiki', array('wiki_name' => $wikiname));
   	}
}