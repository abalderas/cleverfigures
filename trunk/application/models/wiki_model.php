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
	
	private function time_php2sql($unixtime){
		return gmdate("YmdHis", $unixtime);
	}
	
	private function lang_date($date){
// 		if($this->session->userdata('language') == 'english' or $this->session->userdata('language') == 'german')
// 			return $date;
// 		else{
			list($day, $month, $year) = sscanf($date, '%d/%d/%d');
			return $month."/".$day."/".$year;
// 		}
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
   	
   	private function last_psize_sum($pagebytes, $catpage, $category){
		$res = 0;
		foreach(array_keys($catpage[$category]) as $page)
			$res += end($pagebytes[$page])?end($pagebytes[$page]):0;
		return $res;
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
			$filteruser = $this->filter_model->user($filter);
			$filterpage = $this->filter_model->page($filter);
			$filtercategory = $this->filter_model->category($filter);
			$fd = $this->filter_model->firstdate($filter);
			$ld = $this->filter_model->lastdate($filter);
   		}
   		else{
			$fd = $datea;
			$ld = $dateb;
   		}
   		
   		echo "Querying database for general information...</br>";
   		//Creating query string for the general query
   		$qstr = "select rev_id, rev_page, page_title, page_counter, page_namespace, page_is_new, user_id, user_name, user_real_name, user_email, user_registration, rev_timestamp, cl_to, cat_pages, rev_len from revision, user, page, categorylinks, category where rev_page = page_id and rev_user = user_id and page_id = cl_from and cl_to = cat_title";
   		
   		if(isset($filteruser) and $filteruser)
			$qstr = $qstr . " and user_name = '$filteruser'";
		if(isset($filterpage) and $filterpage)
			$qstr = $qstr . " and page_title = '$filterpage'";
		if(isset($filtercategory) and $filtercategory)
			$qstr = $qstr . " and cl_to = '$filtercategory'";
			
		$qstr = $qstr . " and rev_timestamp >= '".$this->time_php2sql(strtotime($this->lang_date($fd)))."'";
		$qstr = $qstr . " and rev_timestamp <= '".$this->time_php2sql(strtotime($this->lang_date($ld)))."'";
		$qstr = $qstr . " order by rev_timestamp asc";
		
		
		//Querying database
   		$query = $link->query($qstr);
   		
   		//If no results then return false
   		if(!$query->result()) 
			die ("ERROR");
			
   		echo "Storing information...</br>";
//    		//Initializing arrays for storing information
   		foreach($query->result() as $row){
    		
 			$usereditscount[$row->user_name] = 0;
			$userbytescount[$row->user_name] = 0;
			$usereditscount_art[$row->user_name] = 0;
			$userbytescount_art[$row->user_name] = 0;
			$pageeditscount[$row->page_title] = 0;
			$pagebytescount[$row->page_title] = 0;
			$pageeditscount_art[$row->page_title] = 0;
			$pagebytescount_art[$row->page_title] = 0;
			$cateditscount[$row->cl_to] = 0;
			$catbytescount[$row->cl_to] = 0;
			$totalbytescount = 0;
			$usercreationcount[$row->user_name] = 0;
			
			$pagebytes[$row->page_title] = array();
			$pagebytes_art[$row->page_title] = array();
			$userpage[$row->user_name] = array();
			$usercat[$row->user_name] = array();
			$pageuser[$row->page_title] = array();
			$pagecat[$row->page_title] = array();
			$catuser[$row->cl_to] = array();
			$catpage[$row->cl_to] = array();
			$totalbytes[$row->rev_timestamp] = array();
			$revbucket = array();
			$usercreatedpages[$row->user_name]= array();
   		}
   		
   		
   		//Storing classified information in arrays
   		
   		//This loop clasifies all the data contained in the query (which ignores uploads info) in arrays that will be returned at the end of the function. 
   		foreach($query->result() as $row){
   			
   			//USEFUL VARIABLES
   			
   			$LAST_PAGE_SIZE = ($row->page_is_new == 0) ? end($pagebytes[$row->page_title]) : 0;
   			$LAST_PAGEBYTES_ARRAY = $pagebytes;
   			
   			//RELATION ARRAYS
   			
   			$userpage[$row->user_name][$row->page_title] = true;
   			$usercat [$row->user_name][$row->cl_to] = true;
   			
   			$pageuser[$row->page_title][$row->user_name] = true;
   			$pagecat [$row->page_title][$row->cl_to] = true;
   			
   			$catuser [$row->cl_to][$row->user_name] = true;
   			$catpage [$row->cl_to][$row->page_title] = true;

			//USER INFORMATION
			
			if(!array_search($row->rev_id, $revbucket)){
			
				$userid			[$row->user_id] = $row->user_name;
				$iduser			[$row->user_name] = $row->user_id;
				$usereditscount		[$row->user_name] += 1;								// Counts the total editions per user
				$userbytescount		[$row->user_name] += $row->rev_len - $LAST_PAGE_SIZE;
				if($row->page_is_new == 1){
					$usercreationcount[$row->user_name] += 1;							// Counts number of pages created by the user
					$usercreatedpages[$row->user_name][] = $row->page_title;					// Strores pages created by the user
				}
				
				$userpagecount		[$row->user_name][$row->rev_timestamp] = count($userpage[$row->user_name]);	// Pages per user/date
				$usercatcount		[$row->user_name][$row->rev_timestamp] = count($usercat[$row->user_name]);	// Categories per user/date
				
				$useredits		[$row->user_name][$row->rev_timestamp] = $usereditscount[$row->user_name];	// Editions per user & date
				$userbytes		[$row->user_name][$row->rev_timestamp] = $userbytescount[$row->user_name];	// Bytes by user $ date
				
				$userrealname		[$row->user_name] = $row->user_real_name;					// Getting user real names
				$userreg		[$row->user_name] = $row->user_registration;					// Getting user registration dates
				
				if ($row->page_namespace == 0){											// If article
					$usereditscount_art	[$row->user_name] += 1;								// Counts total article editions per user
					$userbytescount_art	[$row->user_name] += $row->rev_len - $LAST_PAGE_SIZE;				// Counts total bytes per user 
					
					$useredits_art		[$row->user_name][$row->rev_timestamp] = $usereditscount_art[$row->user_name];	// Editions of article per user/date
					$userbytes_art		[$row->user_name][$row->rev_timestamp] = $userbytescount_art[$row->user_name];	// Bytes per user/date
				}
   			}
			
			
			//PAGE INFORMATION
			
			if(!array_search($row->rev_id, $revbucket)){
				$pageeditscount	[$row->page_title] += 1;							// Count of the total editions per page
				$pagebytescount	[$row->page_title] += $row->rev_len - $LAST_PAGE_SIZE;				// Count of the total bytes per page
				
				$pageusercount	[$row->page_title][$row->rev_timestamp] = count($pageuser[$row->page_title]);	// Users per page/date
				$pagecatcount	[$row->page_title][$row->rev_timestamp] = count($pagecat[$row->page_title]);	// Categories per page/date
				
				$pageedits	[$row->page_title][$row->rev_timestamp] = $pageeditscount[$row->page_title];	// Editions per page/date
				$pagebytes	[$row->page_title][$row->rev_timestamp] = $pagebytescount[$row->page_title];	// Bytes per page/date
				
				$pagenamespace	[$row->page_title] = $row->page_namespace;					// Getting namespaces per page
				$pagevisits	[$row->page_title] = $row->page_counter;					// Total visits per page
	
				if ($row->page_namespace == 0){												// If article
					$pageeditscount_art	[$row->page_title] += 1;								// Count total article editions per user
					$pagebytescount_art	[$row->page_title] += $row->rev_len - $LAST_PAGE_SIZE;
					
					$pageedits_art		[$row->page_title][$row->rev_timestamp] = $pageeditscount_art[$row->page_title];	// Editions of article per user/date
					$pagebytes_art		[$row->page_title][$row->rev_timestamp] = $pagebytescount_art[$row->page_title];	// Bytes per user/date
				}
   			}
   			
   			
			//CATEGORY INFORMATION
			
   			$cateditscount	[$row->cl_to] += 1;
   			
			$catpages	[$row->cl_to][$row->rev_timestamp] = count($catpage[$row->cl_to]);
			$catusers	[$row->cl_to][$row->rev_timestamp] = count($catuser[$row->cl_to]);
			
   			$catedits	[$row->cl_to][$row->rev_timestamp] = $cateditscount[$row->cl_to];
   			$catbytes	[$row->cl_to][$row->rev_timestamp] = $this->last_psize_sum($LAST_PAGEBYTES_ARRAY, $catpage, $row->cl_to);
   			
   			
			//TOTAL INFORMATION
			if(!array_search($row->rev_id, $revbucket)){
				$aux_edits [$row->rev_id] = 1;
				$aux_pages [$row->page_title] = 1;
				$aux_users [$row->user_name] = 1;
			
				$totalbytescount += $row->rev_len - $LAST_PAGE_SIZE;
			
				$totaledits[$row->rev_timestamp] = array_sum($aux_edits);
				$totalpages[$row->rev_timestamp] = array_sum($aux_pages);
				$totalusers[$row->rev_timestamp] = array_sum($aux_users);
				$totalbytes[$row->rev_timestamp] = $totalbytescount;
				$totalvisits = array_sum($pagevisits);
				$revisions[$row->rev_timestamp] = $row->rev_id;
			}
			
			
			//PERCENTAGES
			
			$catpages_per[$row->cl_to][$row->rev_timestamp] = $catpages[$row->cl_to][$row->rev_timestamp] / $totalpages[$row->rev_timestamp];
			$catusers_per[$row->cl_to][$row->rev_timestamp] = $catusers[$row->cl_to][$row->rev_timestamp] / $totalusers[$row->rev_timestamp];
			$catedits_per[$row->cl_to][$row->rev_timestamp] = $catedits[$row->cl_to][$row->rev_timestamp] / $totaledits[$row->rev_timestamp];
			$catbytes_per[$row->cl_to][$row->rev_timestamp] = $catbytes[$row->cl_to][$row->rev_timestamp] / $totalbytes[$row->rev_timestamp];
			
			if(!array_search($row->rev_id, $revbucket)){
				$useredits_per		[$row->user_name][$row->rev_timestamp] = $useredits	[$row->user_name][$row->rev_timestamp] / $totaledits[$row->rev_timestamp];
				$userbytes_per		[$row->user_name][$row->rev_timestamp] = $userbytes	[$row->user_name][$row->rev_timestamp] / $totalbytes[$row->rev_timestamp];
				if($row->page_namespace == 0){
					$useredits_art_per	[$row->user_name][$row->rev_timestamp] = $useredits_art	[$row->user_name][$row->rev_timestamp] / $totaledits[$row->rev_timestamp];
					$userbytes_art_per	[$row->user_name][$row->rev_timestamp] = $userbytes_art	[$row->user_name][$row->rev_timestamp] / $totalbytes[$row->rev_timestamp];
				}
			
				$pageedits_per[$row->page_title][$row->rev_timestamp] = $pageedits[$row->page_title][$row->rev_timestamp] / $totaledits[$row->rev_timestamp];
				$pagebytes_per[$row->page_title][$row->rev_timestamp] = $pagebytes[$row->page_title][$row->rev_timestamp] / $totalbytes[$row->rev_timestamp];
				if($row->page_namespace == 0){
					$pageedits_art_per	[$row->page_title][$row->rev_timestamp] = $pageedits_art	[$row->page_title][$row->rev_timestamp] / $totaledits[$row->rev_timestamp];
					$pagebytes_art_per	[$row->page_title][$row->rev_timestamp] = $pagebytes_art	[$row->page_title][$row->rev_timestamp] / $totalbytes[$row->rev_timestamp];
				}
			}
			
			
			//UPDATE REVISION BUCKET
			
			$revbucket[] = $row->rev_id;
   		}
   		
   		echo "Querying database for uploads information...</br>";
   		//Creating query string for the uploads query
   		$qstr = "select img_name, user_name, img_timestamp, img_size, page_title, cl_to from image, page, user, imagelinks, categorylinks where img_name = il_to and il_from = page_id and page_id = cl_from and img_user = user_id";
   		
   		if(isset($filteruser) and $filteruser)
			$qstr = $qstr . " and user_name = '$filteruser'";
		if(isset($filterpage) and $filterpage)
			$qstr = $qstr . " and page_title = '$filterpage'";
		if(isset($filtercategory) and $filtercategory)
			$qstr = $qstr . " and cl_to = '$filtercategory'";
		
		$qstr = $qstr . " and img_timestamp >= '".$this->time_php2sql(strtotime($this->lang_date($fd)))."'";
		$qstr = $qstr . " and img_timestamp <= '".$this->time_php2sql(strtotime($this->lang_date($ld)))."'";
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
				$useruploadscount[$row->user_name] = 0;
				$pageuploadscount[$row->page_title] = 0;
				$catuploadscount[$row->cl_to] = 0;
				$userupsizecount[$row->user_name] = 0;
				$pageupsizecount[$row->page_title] = 0;
				$catupsizecount[$row->cl_to] = 0;
				$totaluploadscount = 0;
				$totalupsizecount = 0;
				$imgbucket = array();
				
			}
			
			foreach($query->result() as $row){
				
				// USER UPLOAD INFORMATION
				if(!array_search($row->img_name, $imgbucket)){
					$useruploadscount[$row->user_name] += 1;
					$userupsizecount[$row->user_name] += $row->img_size;
				
					$useruploads[$row->user_name][$row->img_timestamp] = $useruploadscount[$row->user_name];
					$userimages[$row->user_name][$row->img_timestamp] = $row->img_name;
					$userupsize[$row->user_name][$row->img_timestamp] = $userupsizecount[$row->user_name];
				}
				
				//PAGE UPLOAD INFORMATION
				if(!array_search($row->img_name, $imgbucket)){
					$pageuploadscount[$row->page_title] += 1;
					$pageupsizecount[$row->page_title] += $row->img_size;
				
					$pageuploads[$row->page_title][$row->img_timestamp] = $pageuploadscount[$row->page_title];
					$pageimages[$row->page_title][$row->img_timestamp] = $row->img_name;		
					$pageupsize[$row->page_title][$row->img_timestamp] = $pageupsizecount[$row->page_title];
				}
				
				
				//CATEGORY UPLOAD INFORMATION
				$catuploadscount[$row->cl_to] += 1;
				$catupsizecount[$row->cl_to] += $row->img_size;
				
				$catuploads[$row->cl_to][$row->img_timestamp] = $catuploadscount[$row->cl_to];
				$catimages[$row->cl_to][$row->img_timestamp] = $row->img_name;
				$catupsize[$row->cl_to][$row->img_timestamp] = $catupsizecount[$row->cl_to];
				
				
				//TOTAL UPLOAD INFORMATION
				if(!array_search($row->img_name, $imgbucket)){
					$totaluploadscount += 1;
					$totalupsizecount += $row->img_size;
				
					$totaluploads[$row->img_timestamp] = $totaluploadscount;
					$totalimages[$row->img_timestamp] = $row->img_name;
					$totalupsize[$row->img_timestamp] = $totalupsizecount;
				}
				
				//PERCENTAGES
				if(!array_search($row->img_name, $imgbucket)){
					$useruploads_per[$row->user_name][$row->img_timestamp] = $useruploads[$row->user_name][$row->img_timestamp] / $totaluploads[$row->img_timestamp];
					$userupsize_per[$row->user_name][$row->img_timestamp] = $userupsize[$row->user_name][$row->img_timestamp] / $totalupsize[$row->img_timestamp];
				
					$pageuploads_per[$row->page_title][$row->img_timestamp] = $pageuploads[$row->page_title][$row->img_timestamp] / $totaluploads[$row->img_timestamp];
					$pageupsize_per[$row->page_title][$row->img_timestamp] = $pageupsize[$row->page_title][$row->img_timestamp] / $totalupsize[$row->img_timestamp];
				}
				
				$catuploads_per	[$row->cl_to][$row->img_timestamp] = $catuploads[$row->cl_to][$row->img_timestamp] / $totaluploads[$row->img_timestamp];
				$catupsize_per	[$row->cl_to][$row->img_timestamp] = $catupsize	[$row->cl_to][$row->img_timestamp] / $totalupsize [$row->img_timestamp];
				
				
				//UPDATE IMAGE BUCKET
				
				$imgbucket[] = $row->img_name;
			}
			
			echo "Analisis completed.</br>";
			
			return array(	  'catpages' => $catpages
					, 'catpages_per' => $catpages_per
					, 'catusers' => $catusers
					, 'catusers_per' => $catusers_per
					, 'catedits' => $catedits
					, 'catedits_per' => $catedits_per
					, 'catbytes' => $catbytes
					, 'catbytes_per' => $catbytes_per
					, 'useredits' => $useredits
					, 'useredits_art' => $useredits_art
					, 'useredits_art_per' => $useredits_art_per
					, 'useredits_per' => $useredits_per
					, 'userbytes' => $userbytes
					, 'userbytes_art' => $userbytes_art
					, 'userbytes_art_per' => $userbytes_art_per
					, 'userbytes_per' => $userbytes_per
					, 'usercreationcount' => $usercreationcount
					, 'usercreatedpages' => $usercreatedpages
					, 'userpagecount' => $userpagecount
					, 'usercatcount' => $usercatcount
					, 'pageedits' => $pageedits
					, 'pagebytes' => $pageedits
					, 'pagebytes_art' => $pageedits_art
					, 'pagebytes_per' => $pagebytes_per
					, 'pagebytes_art_per' => $pagebytes_art_per
					, 'pageedits_per' => $pageedits_per
					, 'pageedits_art_per' => $pageedits_art_per
					, 'pagenamespace' => $pagenamespace
					, 'pagevisits' => $pagevisits
					, 'totaledits' => $totaledits
					, 'totalpages' => $totalpages
					, 'totalusers' => $totalusers
					, 'totalvisits' => $totalvisits
					, 'totalbytes' => $totalbytes
					, 'useruploads' => $useruploads
					, 'useruploads_per' => $useruploads_per
					, 'userupsize' => $userupsize
					, 'userupsize_per' => $userupsize_per
					, 'userimages' => $userimages
					, 'pageuploads' => $pageuploads
					, 'pageuploads_per' => $pageuploads_per
					, 'pageupsize' => $pageupsize
					, 'pageupsize_per' => $pageupsize_per
					, 'pageimages' => $pageimages
					, 'pageusercount' => $pageusercount
					, 'pagecatcount' => $pagecatcount
					, 'catuploads' => $catuploads
					, 'catuploads_per' => $catuploads_per
					, 'catupsize' => $catupsize
					, 'catupsize_per' => $catupsize_per
					, 'catimages' => $catimages
					, 'totaluploads' => $totaluploads
					, 'totalupsize' => $totalupsize
					, 'totalimages' => $totalimages
					, 'revisions' => $revisions
					, 'userid' => $userid
					, 'iduser' => $iduser
				);
   		}
   		
   		echo "Uploads not found.</br>";
   		echo "Analisis completed.</br>";
   		
   		return array(	  'catpages' => $catpages
				, 'catpages_per' => $catpages_per
				, 'catusers' => $catusers
				, 'catusers_per' => $catusers_per
				, 'catedits' => $catedits
				, 'catedits_per' => $catedits_per
				, 'catbytes' => $catbytes
				, 'catbytes_per' => $catbytes_per
				, 'useredits' => $useredits
				, 'useredits_art' => $useredits_art
				, 'useredits_art_per' => $useredits_art_per
				, 'useredits_per' => $useredits_per
				, 'userbytes' => $userbytes
				, 'userbytes_art' => $userbytes_art
				, 'userbytes_art_per' => $userbytes_art_per
				, 'userbytes_per' => $userbytes_per
				, 'usercreationcount' => $usercreationcount
				, 'usercreatedpages' => $usercreatedpages
				, 'userpagecount' => $userpagecount
				, 'usercatcount' => $usercatcount
				, 'pageedits' => $pageedits
				, 'pagebytes' => $pageedits
				, 'pagebytes_art' => $pageedits_art
				, 'pagebytes_per' => $pagebytes_per
				, 'pagebytes_art_per' => $pagebytes_art_per
				, 'pageedits_per' => $pageedits_per
				, 'pageedits_art_per' => $pageedits_art_per
				, 'pagenamespace' => $pagenamespace
				, 'pagevisits' => $pagevisits
				, 'totaledits' => $totaledits
				, 'totalpages' => $totalpages
				, 'totalusers' => $totalusers
				, 'totalvisits' => $totalvisits
				, 'totalbytes' => $totalbytes
				, 'pageusercount' => $pageusercount
				, 'pagecatcount' => $pagecatcount
				, 'revisions' => $revisions
				, 'userid' => $userid
				, 'iduser' => $iduser
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