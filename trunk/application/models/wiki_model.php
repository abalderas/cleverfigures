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
		
		$cf =& get_instance();
		$cf->load->model('filter_model');
   	}
   	
   	private function wconnection($wikiname){
   		//Consultamos la conexión
   		$query = $this->db->query("select wiki_connection from wiki where wiki_name = '$wikiname'");
   		
   		//Comprobamos que existe y devolvemos el id de conexión
   		if(!$query->result())
   			return "wconnection(): ERR_NONEXISTENT";
   		else
   			foreach($query->result() as $row)
   				return $row->wiki_connection;
   	}
   	
   	function get_wiki_list($username = 'default'){
		//Consultamos la conexión
   		$query = $this->db->query("select * from wiki, `user-wiki` where wiki.wiki_name = `user-wiki`.wiki_name and `user-wiki`.user_username = '$username'");
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
   		$check = $this->db->query("select * from wiki where wiki_name = '$wikiname'");
   		if($check->result())
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
		}
   	}
   	function fetch($wikiname, $filter = false, $datea = false, $dateb = false){
   	
		//Checking that we have reference dates. Two options: 
		//they come with the filter or they are manually 
		//specified as parameters
		if(!$filter && (!$datea || !$dateb)) return "fetch(): no dates specified.";
		
		echo "Connecting to database...</br>";
		//Connecting to the wiki database
   		$link = $this->connection_model->connect($this->wconnection($wikiname));
   		
   		echo "Applying filters...</br>";
   		//Applying filters
   		if($filter){
			//Setting filter parameters according to the specified filter
			$filteruser = $this->filter_model->user($filter)? $this->filter_model->user($filter) : false;
			$filterpage = $this->filter_model->page($filter)? $this->filter_model->page($filter) : false;
			$filtercategory = $this->filter_model->category($filter)? $this->filter_model->category($filter) : false;
			$fd = $this->filter_model->firstdate($filter);
			$ld = $this->filter_model->lastdate($filter);
   		}
   		else{
			$fd = $datea;
			$ld = $dateb;
   		}
   		
   		echo "Querying database for general information...</br>";
   		//Creating query string for the general query
   		$qstr = "select rev_id, rev_page, page_title, page_counter, page_namespace, user_name, user_real_name, user_email, user_registration, rev_timestamp, cl_to, cat_pages, rev_len from revision, user, page, categorylinks, category where rev_page = page_id and rev_user = user_id and page_id = cl_from and cl_to = cat_title";
   		
   		if(isset($filteruser))
			$qstr = $qstr . " and user_name = '$filteruser'";
		if(isset($filterpage))
			$qstr = $qstr . " and page_title = '$filterpage'";
		if(isset($filtercategory))
			$qstr = $qstr . " and cl_to = '$filtercategory'";
		
		$qstr = $qstr . " and rev_timestamp >= '$fd'";
		$qstr = $qstr . " and rev_timestamp <= '$ld'";
		$qstr = $qstr . " order by rev_timestamp asc";
		
		//Querying database
   		$query = $link->query($qstr);
   		
   		//If no results then return false
   		if(!$query->result()) 
			return false;
   		
   		echo "Storing information...</br>";
   		//Initializing arrays for storing information
   		foreach($query->result() as $row){
   		
			$catpages[$row->cl_to] = 0;
   			$catpages_per[$row->cl_to][$row->rev_timestamp] = 0;
   			$catedits[$row->cl_to][$row->rev_timestamp] = 0;
   			$catbytes[$row->cl_to][$row->rev_timestamp] = 0;
   			$catvisits[$row->cl_to] = 0;
   			$catedits_per[$row->cl_to][$row->rev_timestamp] = 0;
   			$catbytes_per[$row->cl_to][$row->rev_timestamp] = 0;
   			$catvisits_per[$row->cl_to] = 0;
   			
   			$useredits[$row->user_name][$row->rev_timestamp] = 0;
   			$userbytes[$row->user_name][$row->rev_timestamp] = 0;
   			$useredits_art[$row->user_name][$row->rev_timestamp] = 0;
   			$userbytes_art[$row->user_name][$row->rev_timestamp] = 0;
   			$useredits_per[$row->user_name][$row->rev_timestamp] = 0;
   			$userbytes_per[$row->user_name][$row->rev_timestamp] = 0;
   			$useredits_art_per[$row->user_name][$row->rev_timestamp] = 0;
   			$userbytes_art_per[$row->user_name][$row->rev_timestamp] = 0;
   			
			$pageedits[$row->page_title][$row->rev_timestamp] = 0;
   			$pagebytes[$row->page_title][$row->rev_timestamp] = 0;
   			$pagevisits[$row->page_title] = 0;
   			$pageedits_per[$row->page_title][$row->rev_timestamp] = 0;
   			$pagebytes_per[$row->page_title][$row->rev_timestamp] = 0;
   			
   			$totaledits[$row->rev_timestamp] = 0;
			$totalvisits = 0;
			$totalbytes[$row->rev_timestamp] = 0;
   		}
   			
   		
   		//Storing classified information in arrays
   		foreach($query->result() as $row){
   			//The query returns some repeated rows due to belonging to different categories, so when adding values we need to
   			//check that the array cell is not initialized yet, this is : if(!isset($array))...
   			
   			//Category iformation
			$catpages[$row->cl_to] = $row->cat_pages;
   			$catedits[$row->cl_to][$row->rev_timestamp] = array_sum($catedits[$row->cl_to]) + 1;
   			$catbytes[$row->cl_to][$row->rev_timestamp] = array_sum($catbytes[$row->cl_to]) + $row->rev_len;
   			$catvisits[$row->cl_to] += $row->page_counter;

			//User information
			$userrealname[$row->user_name] = $row->user_real_name;
   			$userreg[$row->user_name] = $row->user_registration;
   			if (!isset($useredits[$row->user_name][$row->rev_timestamp])) $useredits[$row->user_name][$row->rev_timestamp] = array_sum($useredits[$row->user_name]) + 1;
   			if (!isset($userbytes[$row->user_name][$row->rev_timestamp])) $userbytes[$row->user_name][$row->rev_timestamp] = array_sum($userbytes[$row->user_name]) + $row->rev_len;
   			if ($row->page_namespace == 0 && !isset($useredits_art[$row->user_name][$row->rev_timestamp])) $useredits_art[$row->user_name][$row->rev_timestamp] = array_sum($useredits_art[$row->user_name]) + 1;
   			if ($row->page_namespace == 0 && !isset($userbytes_art[$row->user_name][$row->rev_timestamp])) $userbytes_art[$row->user_name][$row->rev_timestamp] = array_sum($userbytes_art[$row->user_name]) + $row->rev_len;

			//Page information
			$pagenamespace[$row->page_title] = $row->page_namespace;
			if (!isset($pageedits[$row->page_title][$row->rev_timestamp])) $pageedits[$row->page_title][$row->rev_timestamp] = array_sum($pageedits[$row->page_title]) + 1;
   			if (!isset($pagebytes[$row->page_title][$row->rev_timestamp])) $pagebytes[$row->page_title][$row->rev_timestamp] = array_sum($pagebytes[$row->page_title]) + $row->rev_len;
   			$pagevisits[$row->page_title] = $row->page_counter;
	
			//Some auxiliar arrays to calculate total values
			$aux_edits[$row->rev_id] = 1;
			$aux_pages[$row->page_title] = 1;
			
			//Calculating total values
			$totaledits[$row->rev_timestamp] = array_sum($aux_edits);
			$totalvisits = array_sum($pagevisits);
			$totalpages[$row->rev_timestamp] = array_sum($aux_pages);
			$totalbytes[$row->rev_timestamp] = array_sum($totalbytes) + $row->rev_len;
			
   		}
   		
   		//Calculating percentages
   		foreach(array_keys($catpages) as $categorykey){
			foreach(array_keys($catedits[$categorykey]) as $datekey){
				$catpages_per[$categorykey][$datekey] = 
				$catpages[$categorykey] / $totalpages[$datekey];
				$catedits_per[$categorykey][$datekey] = 
				$catedits[$categorykey][$datekey] / $totaledits[$datekey];
				$catbytes_per[$categorykey][$datekey] = 
				$catbytes[$categorykey][$datekey] / $totalbytes[$datekey];
   			}
   		}
   		
   		foreach(array_keys($userrealname) as $userkey){
			foreach(array_keys($useredits[$userkey]) as $datekey){
				$useredits_per[$userkey][$datekey] = $useredits[$userkey][$datekey] / $totaledits[$datekey];
				$userbytes_per[$userkey][$datekey] = $userbytes[$userkey][$datekey] / $totalbytes[$datekey];
				$useredits_art_per[$userkey][$datekey] = $useredits_art[$userkey][$datekey] / $totaledits[$datekey];
				$userbytes_art_per[$userkey][$datekey] = $userbytes_art[$userkey][$datekey] / $totalbytes[$datekey];
   			}
   		}
   		
   		foreach(array_keys($pagenamespace) as $pagekey){
			foreach(array_keys($pageedits[$pagekey]) as $datekey){
				$pageedits_per[$pagekey][$datekey] = $pageedits[$pagekey][$datekey] / $totaledits[$datekey];
				$pagebytes_per[$pagekey][$datekey] = $pagebytes[$pagekey][$datekey] / $totalbytes[$datekey];
   			}
   		}
   		
   		echo "Querying database for uploads information...</br>";
   		//Creating query string for the uploads query
   		$qstr = "select img_name, user_name, img_timestamp, img_size, page_title, cl_to from image, page, user, imagelinks, categorylinks where img_name = il_to and il_from = page_id and page_id = cl_from and img_user = user_id";
   		
   		if(isset($filteruser))
			$qstr = $qstr . " and user_name = '$filteruser'";
		if(isset($filterpage))
			$qstr = $qstr . " and page_title = '$filterpage'";
		if(isset($filtercategory))
			$qstr = $qstr . " and cl_to = '$filtercategory'";
		
		$qstr = $qstr . " and img_timestamp >= '$fd'";
		$qstr = $qstr . " and img_timestamp <= '$ld'";
		$qstr = $qstr . " order by img_timestamp asc";
		
		//Querying database
		$query = $link->query($qstr);
		
		//If there is information about uploads
   		if($query->result()){
   		echo "Uploads found. Storing uploads information...</br>";
			//Initializing arrays
			foreach($query->result() as $row){
   		
				$userupsize[$row->user_name][$row->img_timestamp] = 0;
				$pageupsize[$row->page_title][$row->img_timestamp] = 0;
				$catupsize[$row->cl_to][$row->img_timestamp] = 0;
				$totaluploads[$row->img_timestamp] = 0;
				$totalupsize[$row->img_timestamp] = 0;
			}
			
			foreach($query->result() as $row){
   		
				$useruploads[$row->user_name][$row->img_timestamp] = $row->img_name;
				if(!isset($userupsize[$row->user_name][$row->img_timestamp])) $userupsize[$row->user_name][$row->img_timestamp] = array_sum($userupsize[$row->user_name]) + $row->img_size;
				
				$pageuploads[$row->page_title][$row->img_timestamp] = $row->img_name;		
				if(!isset($pageupsize[$row->page_title][$row->img_timestamp])) $pageupsize[$row->page_title][$row->img_timestamp] = array_sum($pageupsize[$row->page_title]) + $row->img_size;
				
				$catuploads[$row->cl_to][$row->img_timestamp] = $row->img_name;
				if(!isset($catupsize[$row->cl_to][$row->img_timestamp])) $catupsize[$row->cl_to][$row->img_timestamp] = array_sum($catupsize[$row->cl_to]) + $row->img_size;
				
				$aux_up[$row->img_name] = 1;
				$aux_upsize[$row->img_name] = $row->img_size;
				
				$totaluploads[$row->img_timestamp] = array_sum($aux_up);
				if($totalupsize[$row->img_timestamp] == 0) $totalupsize[$row->img_timestamp] = array_sum($aux_upsize);
			}
			
   			foreach(array_keys($useruploads) as $userkey){
				foreach(array_keys($useruploads[$userkey]) as $datekey){
					$useruploads_per[$userkey][$datekey] = $useruploads[$userkey][$datekey] / $totaluploads[$datekey];
					$userupsize_per[$userkey][$datekey] = $userupsize[$userkey][$datekey] / $totalupsize[$datekey];
				}
			}
			
			foreach(array_keys($pageuploads) as $pagekey){
				foreach(array_keys($pageuploads[$pagekey]) as $datekey){
					$pageuploads_per[$pagekey][$datekey] = $pageuploads[$pagekey][$datekey] / $totaluploads[$datekey];
					$pageupsize_per[$pagekey][$datekey] = $pageupsize[$pagekey][$datekey] / $totalupsize[$datekey];
				}
			}
			
			foreach(array_keys($catuploads) as $catkey){
				foreach(array_keys($catuploads[$catkey]) as $datekey){
					$catuploads_per[$catkey][$datekey] = $catuploads[$catkey][$datekey] / $totaluploads[$datekey];
					$catupsize_per[$catkey][$datekey] = $catupsize[$catkey][$datekey] / $totalupsize[$datekey];
				}
			}
			
			echo "Analisis completed.</br>";
			
			return array(	  'catpages' => $catpages
					, 'catpages_per' => $catpages_per
					, 'catedits' => $catedits
					, 'catedits_per' => $catedits_per
					, 'catbytes' => $catbytes
					, 'catbytes_per' => $catbytes_per
					, 'catvisits' => $catvisits
					, 'catvisits_per' => $catvisits_per
					, 'useredits' => $useredits
					, 'useredits_art' => $useredits_art
					, 'useredits_art_per' => $useredits_art_per
					, 'useredits_per' => $useredits_per
					, 'userbytes' => $userbytes
					, 'userbytes_art' => $userbytes_art
					, 'userbytes_art_per' => $userbytes_art_per
					, 'userbytes_per' => $userbytes_per
					, 'pageedits' => $pageedits
					, 'pageedits_per' => $pageedits_per
					, 'totaledits' => $totaledits
					, 'totalvisits' => $totalvisits
					, 'totalbytes' => $totalbytes
					, 'useruploads' => $useruploads
					, 'useruploads_per' => $useruploads_per
					, 'userupsize' => $userupsize
					, 'userupsize_per' => $userupsize_per
					, 'pageuploads' => $pageuploads
					, 'pageuploads_per' => $pageuploads_per
					, 'pageupsize' => $pageupsize
					, 'pageupsize_per' => $pageupsize_per
					, 'catuploads' => $catuploads
					, 'catuploads_per' => $catuploads_per
					, 'catupsize' => $catupsize
					, 'catupsize_per' => $catupsize_per
					, 'totaluploads' => $totaluploads
					, 'totalupsize' => $totalupsize
				);
   		}
   		
   		echo "Uploads not found.</br>";
   		echo "Analisis completed.</br>";
   		
   		return array(	  'catpages' => $catpages
				, 'catpages_per' => $catpages_per
				, 'catedits' => $catedits
				, 'catedits_per' => $catedits_per
				, 'catbytes' => $catbytes
				, 'catbytes_per' => $catbytes_per
				, 'catvisits' => $catvisits
				, 'catvisits_per' => $catvisits_per
				, 'useredits' => $useredits
				, 'useredits_art' => $useredits_art
				, 'useredits_art_per' => $useredits_art_per
				, 'useredits_per' => $useredits_per
				, 'userbytes' => $userbytes
				, 'userbytes_art' => $userbytes_art
				, 'userbytes_art_per' => $userbytes_art_per
				, 'userbytes_per' => $userbytes_per
				, 'pageedits' => $pageedits
				, 'pageedits_per' => $pageedits_per
				, 'totaledits' => $totaledits
				, 'totalvisits' => $totalvisits
				, 'totalbytes' => $totalbytes
			);
   		
   		
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