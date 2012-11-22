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
	
	private function mwtime_to_unix($mwtime){
		list($year, $month, $day, $hour, $min, $sec) = sscanf($mwtime, "%4d%2d%2d%2d%2d%2d");
		return mktime($hour, $min, $sec, $month, $day, $year);
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
   	
   	function displayTree($array) {
		$output = "";
		$newline = "<br>";
		foreach($array as $key => $value) {    //cycle through each item in the array as key => value pairs
			if (is_array($value) || is_object($value)) {        //if the VALUE is an array, then
				//call it out as such, surround with brackets, and recursively call displayTree.
				$value = "Array()" . $newline . "(<ul>" . $this->displayTree($value) . "</ul>)" . $newline;
			}
			//if value isn't an array, it must be a string. output its' key and value.
			$output .= "[".$key."] => " . $value . $newline;
		}
		return $output;
	}
   	
   	private function last_psize_sum($pagebytes, $catpage, $category){
		$res = 0;
		foreach(array_keys($catpage[$category]) as $page)
			$res += end($pagebytes[$page])?end($pagebytes[$page]):0;
		return $res;
   	}
   	
   	function array_back_sum($array, $limit){
		$res = 0;
		foreach(array_keys($array) as $key)
			if($key <= $limit) $res += $array[$key];
		
		return $res;
   	}
   	
   	function countdim($array){
		if (is_array(reset($array)))
			$return = $this->countdim(reset($array)) + 1;
		else
			$return = 1;

		return $return;
	}
   	
   	function fetch($wikiname, $analisis){
		
		//Creating directory to store data
		
		mkdir("analisis/$analisis");
		
		//Starting the analisis
		echo ">> Analisis started. </br>";
		echo "Connecting to database...</br>";
		ob_flush(); flush();
		
		//Connecting to the wiki database
   		$link = $this->connection_model->connect($this->wconnection($wikiname));
   		
   		echo "Querying database for general information...</br>";
   		ob_flush(); flush();
   		
   		//Creating query string for the general query
   		$qstr = "select rev_id, rev_page, page_title, page_counter, page_namespace, page_is_new, user_id, user_name, user_real_name, user_email, user_registration, rev_timestamp, rev_len from revision, user, page where rev_page = page_id and rev_user = user_id order by rev_timestamp asc";		
		
		//Querying database
   		$query = $link->query($qstr);
   		
   		//If no results then return false
   		if(!$query->result()) 
			return false;
			
   		echo "Storing information...</br>";
   		ob_flush(); flush();
   		
   		//Initializing arrays for storing information
   		foreach($query->result() as $row){
			
 			$usereditscount[$row->user_name] = 0;
			$userbytescount[$row->user_name] = 0;
			$usereditscount_art[$row->user_name] = 0;
			$userbytescount_art[$row->user_name] = 0;
			$pageeditscount[$row->page_title] = 0;
			$pagebytescount[$row->page_title] = 0;
			$pageeditscount_art[$row->page_title] = 0;
			$pagebytescount_art[$row->page_title] = 0;
			$totalbytescount = 0;
			$usercreationcount[$row->user_name] = 0;
			$useractivityhour[$row->user_name][date('H', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$useractivitywday[$row->user_name][date('w', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$useractivityweek[$row->user_name][date('W', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$useractivitymonth[$row->user_name][date('m', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$useractivityyear[$row->user_name][date('Y', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$pageactivityhour[$row->page_title][date('H', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$pageactivitywday[$row->page_title][date('w', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$pageactivityweek[$row->page_title][date('W', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$pageactivitymonth[$row->page_title][date('m', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$pageactivityyear[$row->page_title][date('Y', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$totalactivityhour[date('H', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$totalactivitywday[date('D', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$totalactivityweek[date('W', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$totalactivitymonth[date('M', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$totalactivityyear[date('Y', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			
			
			$pagebytes[$row->page_title] = array();
			$pagebytes_art[$row->page_title] = array();
			$userpage[$row->user_name] = array();
			$pageuser[$row->page_title] = array();
			$totalbytes[$this->mwtime_to_unix($row->rev_timestamp)] = array();
			$revbucket = array();
			$usercreatedpages[$row->user_name]= array();
   		}
   		
   		
   		//Storing classified information in arrays
   		
   		//This loop clasifies all the data contained in the query (which ignores uploads info) in arrays. 
   		foreach($query->result() as $row){
   			
   			//USEFUL VARIABLES
   			
   			$LAST_PAGE_SIZE = ($row->page_is_new == 0) ? end($pagebytes[$row->page_title]) : 0;
   			$LAST_PAGEBYTES_ARRAY = $pagebytes;
   			
   			//RELATION ARRAYS
   			
   			$userpage[$row->user_name][$row->page_title] = true;
   			$pageuser[$row->page_title][$row->user_name] = true;

			//USER INFORMATION
			
			$userid			[$row->user_id] = $row->user_name;
			$iduser			[$row->user_name] = $row->user_id;
			$usereditscount		[$row->user_name] += 1;								// Counts the total editions per user
			$userbytescount		[$row->user_name] += $row->rev_len - $LAST_PAGE_SIZE;
			if($row->page_is_new == 1){
				$usercreationcount[$row->user_name] += 1;							// Counts number of pages created by the user
				$usercreatedpages[$row->user_name][] = $row->page_title;					// Strores pages created by the user
			}
				
			$userpagecount		[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = count($userpage[$row->user_name]);	// Pages per user/date
			
			$useredits		[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $usereditscount[$row->user_name];	// Editions per user & date
			$userbytes		[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $userbytescount[$row->user_name];	// Bytes by user $ date
			
			$userrealname		[$row->user_name] = $row->user_real_name;					// Getting user real names
			$userreg		[$row->user_name] = $row->user_registration;					// Getting user registration dates
				
			if ($row->page_namespace == 0){											// If article
				$usereditscount_art	[$row->user_name] += 1;								// Counts total article editions per user
				$userbytescount_art	[$row->user_name] += $row->rev_len - $LAST_PAGE_SIZE;				// Counts total bytes per user 
					
				$useredits_art		[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $usereditscount_art[$row->user_name];	// Editions of article per user/date
				$userbytes_art		[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $userbytescount_art[$row->user_name];	// Bytes per user/date
			}
				
			$useractivityhour[$row->user_name][date('H', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$useractivitywday[$row->user_name][date('w', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$useractivityweek[$row->user_name][date('W', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$useractivitymonth[$row->user_name][date('m', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$useractivityyear[$row->user_name][date('Y', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			
			
			//PAGE INFORMATION
			
			$pageeditscount	[$row->page_title] += 1;							// Count of the total editions per page
			$pagebytescount	[$row->page_title] += $row->rev_len - $LAST_PAGE_SIZE;				// Count of the total bytes per page
				
			$pageusercount	[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] = count($pageuser[$row->page_title]);	// Users per page/date
				
			$pageedits	[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] = $pageeditscount[$row->page_title];	// Editions per page/date
			$pagebytes	[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] = $pagebytescount[$row->page_title];	// Bytes per page/date
				
			$pagenamespace	[$row->page_title] = $row->page_namespace;					// Getting namespaces per page
			$pagevisits	[$row->page_title] = $row->page_counter;					// Total visits per page
	
			if ($row->page_namespace == 0){												// If article
				$pageeditscount_art	[$row->page_title] += 1;								// Count total article editions per user
				$pagebytescount_art	[$row->page_title] += $row->rev_len - $LAST_PAGE_SIZE;
					
				$pageedits_art		[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] = $pageeditscount_art[$row->page_title];	// Editions of article per user/date
				$pagebytes_art		[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] = $pagebytescount_art[$row->page_title];	// Bytes per user/date
			}
				
			$pageactivityhour[$row->page_title][date('H', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$pageactivitywday[$row->page_title][date('w', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$pageactivityweek[$row->page_title][date('W', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$pageactivitymonth[$row->page_title][date('m', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$pageactivityyear[$row->page_title][date('Y', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
   			
   			
			//TOTAL INFORMATION
			$aux_edits [$row->rev_id] = 1;
			$aux_pages [$row->page_title] = 1;
			$aux_users [$row->user_name] = 1;
			
			$totalbytescount += $row->rev_len - $LAST_PAGE_SIZE;
			
			$totaledits[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_edits);
			$totalpages[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_pages);
			$totalusers[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_users);
			$totalbytes[$this->mwtime_to_unix($row->rev_timestamp)] = $totalbytescount;
			$totalvisits = array_sum($pagevisits);
			$revisiondate[$row->rev_id] = $this->mwtime_to_unix($row->rev_timestamp);
				
			$totalactivityhour[date('H', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$totalactivitywday[date('D', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$totalactivityweek[date('W', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$totalactivitymonth[date('M', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$totalactivityyear[date('Y', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			
			
			//PERCENTAGES
			
			$useredits_per		[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $useredits	[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] / $totaledits[$this->mwtime_to_unix($row->rev_timestamp)];
			$userbytes_per		[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $userbytes	[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] / $totalbytes[$this->mwtime_to_unix($row->rev_timestamp)];
			if($row->page_namespace == 0){
				$useredits_art_per	[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $useredits_art	[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] / $totaledits[$this->mwtime_to_unix($row->rev_timestamp)];
				$userbytes_art_per	[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $userbytes_art	[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] / $totalbytes[$this->mwtime_to_unix($row->rev_timestamp)];
			}
			
			$pageedits_per[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] = $pageedits[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] / $totaledits[$this->mwtime_to_unix($row->rev_timestamp)];
			$pagebytes_per[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] = $pagebytes[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] / $totalbytes[$this->mwtime_to_unix($row->rev_timestamp)];
			if($row->page_namespace == 0){
				$pageedits_art_per	[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] = $pageedits_art	[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] / $totaledits[$this->mwtime_to_unix($row->rev_timestamp)];
				$pagebytes_art_per	[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] = $pagebytes_art	[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] / $totalbytes[$this->mwtime_to_unix($row->rev_timestamp)];
			}
   		}
   		
   		echo "Querying database for category information...</br>";
   		
   		$qstr = "select rev_id, rev_page, page_title, page_counter, page_namespace, page_is_new, user_id, user_name, user_real_name, user_email, user_registration, rev_timestamp, cl_to, cat_pages, rev_len from revision, user, page, categorylinks, category where rev_page = page_id and rev_user = user_id and page_id = cl_from and cl_to = cat_title order by rev_timestamp asc";		
		
		//Querying database
   		$query = $link->query($qstr);
   		
   		//If no results then return false
   		if(!$query->result()) 
			die ("ERROR");
			
   		echo "Storing category information...</br>";
   		ob_flush(); flush();
   		
   		//Initializing arrays for storing information
   		foreach($query->result() as $row){
			
 			$cateditscount[$row->cl_to] = 0;
			$catbytescount[$row->cl_to] = 0;
			$catactivityhour[$row->cl_to][date('H', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$catactivitywday[$row->cl_to][date('w', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$catactivityweek[$row->cl_to][date('W', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$catactivitymonth[$row->cl_to][date('m', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$catactivityyear[$row->cl_to][date('Y', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			
			
			$usercat[$row->user_name] = array();
			$pagecat[$row->page_title] = array();
			$catuser[$row->cl_to] = array();
			$catpage[$row->cl_to] = array();
		}
   		
   		
   		//Storing classified information in arrays
   		
   		//This loop clasifies categories data contained in the query (which ignores uploads info) in arrays. 
   		foreach($query->result() as $row){
   			
   			//USEFUL VARIABLES
   			
   			$LAST_PAGE_SIZE = ($row->page_is_new == 0) ? end($pagebytes[$row->page_title]) : 0;
   			$LAST_PAGEBYTES_ARRAY = $pagebytes;
   			
   			//RELATION ARRAYS
   			
   			$usercat [$row->user_name][$row->cl_to] = true;
   			$pagecat [$row->page_title][$row->cl_to] = true;
   			$catuser [$row->cl_to][$row->user_name] = true;
   			$catpage [$row->cl_to][$row->page_title] = true;

			//USER INFORMATION
			
			$usercatcount[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = count($usercat[$row->user_name]);	// Categories per user/date
			
			
			//PAGE INFORMATION
			
			$pagecatcount	[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] = count($pagecat[$row->page_title]);	// Categories per page/date   			
   			
			//CATEGORY INFORMATION
			
   			$cateditscount	[$row->cl_to] += 1;
   			
			$catpages	[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] = count($catpage[$row->cl_to]);
			$catusers	[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] = count($catuser[$row->cl_to]);
			
   			$catedits	[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] = $cateditscount[$row->cl_to];
   			$catbytes	[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] = $this->last_psize_sum($LAST_PAGEBYTES_ARRAY, $catpage, $row->cl_to);
   			
   			$catactivityhour[$row->cl_to][date('H', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$catactivitywday[$row->cl_to][date('w', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$catactivityweek[$row->cl_to][date('W', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$catactivitymonth[$row->cl_to][date('m', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$catactivityyear[$row->cl_to][date('Y', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			
			
			//PERCENTAGES
			
			$catpages_per[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] = $catpages[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] / $totalpages[$this->mwtime_to_unix($row->rev_timestamp)];
			$catusers_per[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] = $catusers[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] / $totalusers[$this->mwtime_to_unix($row->rev_timestamp)];
			$catedits_per[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] = $catedits[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] / $totaledits[$this->mwtime_to_unix($row->rev_timestamp)];
			$catbytes_per[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] = $catbytes[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] / $totalbytes[$this->mwtime_to_unix($row->rev_timestamp)];
   		}
   		
   		
   		echo "Querying database for uploads information...</br>";
   		ob_flush(); flush();
   		
   		//Creating query string for the uploads query
   		$qstr = "select img_name, user_name, img_timestamp, img_size, page_title from image, page, user, imagelinks where img_name = il_to and il_from = page_id and img_user = user_id order by img_timestamp asc";
		
		//Querying database
		$query = $link->query($qstr);
		
		//If there is information about uploads
   		if($query->result()){
   		echo "Uploads found. Storing uploads information...</br>";
   		ob_flush(); flush();
   		
			//Initializing arrays
			foreach($query->result() as $row){
			
				$userupsize[$row->user_name][$this->mwtime_to_unix($row->img_timestamp)] = 0;
				$pageupsize[$row->page_title][$this->mwtime_to_unix($row->img_timestamp)] = 0;
				$totaluploads[$this->mwtime_to_unix($row->img_timestamp)] = 0;
				$totalupsize[$this->mwtime_to_unix($row->img_timestamp)] = 0;
				$useruploadscount[$row->user_name] = 0;
				$pageuploadscount[$row->page_title] = 0;
				$userupsizecount[$row->user_name] = 0;
				$pageupsizecount[$row->page_title] = 0;
				$totaluploadscount = 0;
				$totalupsizecount = 0;
				
			}
			
			foreach($query->result() as $row){
				
				// USER UPLOAD INFORMATION
				$useruploadscount[$row->user_name] += 1;
				$userupsizecount[$row->user_name] += $row->img_size;
				
				$useruploads[$row->user_name][$this->mwtime_to_unix($row->img_timestamp)] = $useruploadscount[$row->user_name];
				$userimages[$row->user_name][$this->mwtime_to_unix($row->img_timestamp)] = $row->img_name;
				$userupsize[$row->user_name][$this->mwtime_to_unix($row->img_timestamp)] = $userupsizecount[$row->user_name];
				
				//PAGE UPLOAD INFORMATION
				$pageuploadscount[$row->page_title] += 1;
				$pageupsizecount[$row->page_title] += $row->img_size;
				
				$pageuploads[$row->page_title][$this->mwtime_to_unix($row->img_timestamp)] = $pageuploadscount[$row->page_title];
				$pageimages[$row->page_title][$this->mwtime_to_unix($row->img_timestamp)] = $row->img_name;		
				$pageupsize[$row->page_title][$this->mwtime_to_unix($row->img_timestamp)] = $pageupsizecount[$row->page_title];
				
				
				//TOTAL UPLOAD INFORMATION
				$totaluploadscount += 1;
				$totalupsizecount += $row->img_size;
				
				$totaluploads[$this->mwtime_to_unix($row->img_timestamp)] = $totaluploadscount;
				$totalimages[$this->mwtime_to_unix($row->img_timestamp)] = $row->img_name;
				$totalupsize[$this->mwtime_to_unix($row->img_timestamp)] = $totalupsizecount;
				
				//PERCENTAGES
				$useruploads_per[$row->user_name][$this->mwtime_to_unix($row->img_timestamp)] = $useruploads[$row->user_name][$this->mwtime_to_unix($row->img_timestamp)] / $totaluploads[$this->mwtime_to_unix($row->img_timestamp)];
				$userupsize_per[$row->user_name][$this->mwtime_to_unix($row->img_timestamp)] = $userupsize[$row->user_name][$this->mwtime_to_unix($row->img_timestamp)] / $totalupsize[$this->mwtime_to_unix($row->img_timestamp)];
				
				$pageuploads_per[$row->page_title][$this->mwtime_to_unix($row->img_timestamp)] = $pageuploads[$row->page_title][$this->mwtime_to_unix($row->img_timestamp)] / $totaluploads[$this->mwtime_to_unix($row->img_timestamp)];
				$pageupsize_per[$row->page_title][$this->mwtime_to_unix($row->img_timestamp)] = $pageupsize[$row->page_title][$this->mwtime_to_unix($row->img_timestamp)] / $totalupsize[$this->mwtime_to_unix($row->img_timestamp)];
			}
			
			
			echo "Querying database for uploads information in categories...</br>";
			
			$qstr = "select img_name, user_name, img_timestamp, img_size, page_title, cl_to from image, page, user, imagelinks, categorylinks where img_name = il_to and il_from = page_id and page_id = cl_from and img_user = user_id order by img_timestamp asc";
			
			//Querying database
			$query = $link->query($qstr);
			if($query->result()){
				echo "Uploads found. Storing uploads information in categories...</br>";
				ob_flush(); flush();
			
				//Initializing arrays
				foreach($query->result() as $row){
			
					$catupsize[$row->cl_to][$this->mwtime_to_unix($row->img_timestamp)] = 0;
					$catuploadscount[$row->cl_to] = 0;
					$catupsizecount[$row->cl_to] = 0;
				}
			
				foreach($query->result() as $row){
				
					//CATEGORY UPLOAD INFORMATION
					$catuploadscount[$row->cl_to] += 1;
					$catupsizecount[$row->cl_to] += $row->img_size;
				
					$catuploads[$row->cl_to][$this->mwtime_to_unix($row->img_timestamp)] = $catuploadscount[$row->cl_to];
					$catimages[$row->cl_to][$this->mwtime_to_unix($row->img_timestamp)] = $row->img_name;
					$catupsize[$row->cl_to][$this->mwtime_to_unix($row->img_timestamp)] = $catupsizecount[$row->cl_to];
				
				
					//PERCENTAGES
					$catuploads_per	[$row->cl_to][$this->mwtime_to_unix($row->img_timestamp)] = $catuploads[$row->cl_to][$this->mwtime_to_unix($row->img_timestamp)] / $totaluploads[$this->mwtime_to_unix($row->img_timestamp)];
					$catupsize_per	[$row->cl_to][$this->mwtime_to_unix($row->img_timestamp)] = $catupsize	[$row->cl_to][$this->mwtime_to_unix($row->img_timestamp)] / $totalupsize [$this->mwtime_to_unix($row->img_timestamp)];
				}
				
				$analisis_data = array(	  'catpages' => $catpages
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
						, 'userrealname' => $userrealname
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
						, 'revisiondate' => $revisiondate
						, 'userid' => $userid
						, 'iduser' => $iduser
						, 'useractivityhour' => $useractivityhour
						, 'useractivitywday' => $useractivitywday
						, 'useractivityweek' => $useractivityweek
						, 'useractivitymonth' => $useractivitymonth
						, 'useractivityyear' => $useractivityyear
						, 'pageactivityhour' => $pageactivityhour
						, 'pageactivitywday' => $pageactivitywday
						, 'pageactivityweek' => $pageactivityweek
						, 'pageactivitymonth' => $pageactivitymonth
						, 'pageactivityyear' => $pageactivityyear
						, 'catactivityhour' => $catactivityhour
						, 'catactivitywday' => $catactivitywday
						, 'catactivityweek' => $catactivityweek
						, 'catactivitymonth' => $catactivitymonth
						, 'catactivityyear' => $catactivityyear
						, 'totalactivityhour' => $totalactivityhour
						, 'totalactivitywday' => $totalactivitywday
						, 'totalactivityweek' => $totalactivityweek
						, 'totalactivitymonth' => $totalactivitymonth
						, 'totalactivityyear' => $totalactivityyear
					);
					
				foreach(array_keys($analisis_data) as $key){
					if(gettype($analisis_data[$key]) == 'integer')
						$this->csv_model->array_to_dim0($analisis, $key, $analisis_data[$key]);
					else if($this->countdim($analisis_data[$key]) == 1)
						$this->csv_model->array_to_dim1($analisis, $key, $analisis_data[$key], 'X', 'Y');
					else if ($this->countdim($analisis_data[$key]) == 2)
						$this->csv_model->array_to_dim2($analisis, $key, $analisis_data[$key], 'X', 'Y');
				}
				
				echo ">> Wiki analisis accomplished.</br>";
				ob_flush(); flush();
				
				return true;
			}
			
			echo "Uploads information in categories not found.</br>";
			ob_flush(); flush();
   		
			$analisis_data = array(	  'catpages' => $catpages
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
					, 'userrealname' => $userrealname
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
					, 'totaluploads' => $totaluploads
					, 'totalupsize' => $totalupsize
					, 'totalimages' => $totalimages
					, 'revisiondate' => $revisiondate
					, 'userid' => $userid
					, 'iduser' => $iduser
					, 'useractivityhour' => $useractivityhour
					, 'useractivitywday' => $useractivitywday
					, 'useractivityweek' => $useractivityweek
					, 'useractivitymonth' => $useractivitymonth
					, 'useractivityyear' => $useractivityyear
					, 'pageactivityhour' => $pageactivityhour
					, 'pageactivitywday' => $pageactivitywday
					, 'pageactivityweek' => $pageactivityweek
					, 'pageactivitymonth' => $pageactivitymonth
					, 'pageactivityyear' => $pageactivityyear
					, 'catactivityhour' => $catactivityhour
					, 'catactivitywday' => $catactivitywday
					, 'catactivityweek' => $catactivityweek
					, 'catactivitymonth' => $catactivitymonth
					, 'catactivityyear' => $catactivityyear
					, 'totalactivityhour' => $totalactivityhour
					, 'totalactivitywday' => $totalactivitywday
					, 'totalactivityweek' => $totalactivityweek
					, 'totalactivitymonth' => $totalactivitymonth
					, 'totalactivityyear' => $totalactivityyear
				);
				
			foreach(array_keys($analisis_data) as $key){
				if(gettype($analisis_data[$key]) == 'integer')
					$this->csv_model->array_to_dim0($analisis, $key, $analisis_data[$key]);
				else if($this->countdim($analisis_data[$key]) == 1)
					$this->csv_model->array_to_dim1($analisis, $key, $analisis_data[$key], 'X', 'Y');
				else if ($this->countdim($analisis_data[$key]) == 2)
					$this->csv_model->array_to_dim2($analisis, $key, $analisis_data[$key], 'X', 'Y');
			}
				
			echo ">> Wiki analisis accomplished.</br>";
			ob_flush(); flush();
				
			return true;
		}
   		
   		echo "Uploads not found.</br>";
   		ob_flush(); flush();
   		
   		$analisis_data = array(	  'catpages' => $catpages
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
				, 'userrealname' => $userrealname
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
				, 'revisiondate' => $revisiondate
				, 'userid' => $userid
				, 'iduser' => $iduser
				, 'useractivityhour' => $useractivityhour
				, 'useractivitywday' => $useractivitywday
				, 'useractivityweek' => $useractivityweek
				, 'useractivitymonth' => $useractivitymonth
				, 'useractivityyear' => $useractivityyear
				, 'pageactivityhour' => $pageactivityhour
				, 'pageactivitywday' => $pageactivitywday
				, 'pageactivityweek' => $pageactivityweek
				, 'pageactivitymonth' => $pageactivitymonth
				, 'pageactivityyear' => $pageactivityyear
				, 'catactivityhour' => $catactivityhour
				, 'catactivitywday' => $catactivitywday
				, 'catactivityweek' => $catactivityweek
				, 'catactivitymonth' => $catactivitymonth
				, 'catactivityyear' => $catactivityyear
				, 'totalactivityhour' => $totalactivityhour
				, 'totalactivitywday' => $totalactivitywday
				, 'totalactivityweek' => $totalactivityweek
				, 'totalactivitymonth' => $totalactivitymonth
				, 'totalactivityyear' => $totalactivityyear
			);
			
		foreach(array_keys($analisis_data) as $key){
			if(gettype($analisis_data[$key]) == 'integer')
				$this->csv_model->array_to_dim0($analisis, $key, $analisis_data[$key]);
			else if($this->countdim($analisis_data[$key]) == 1)
				$this->csv_model->array_to_dim1($analisis, $key, $analisis_data[$key], 'X', 'Y');
			else if ($this->countdim($analisis_data[$key]) == 2)
				$this->csv_model->array_to_dim2($analisis, $key, $analisis_data[$key], 'X', 'Y');
		}
				
		echo ">> Wiki analisis accomplished.</br>";
		ob_flush(); flush();
			
		return true;
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