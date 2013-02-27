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
		$ct =& get_instance();
		$ct->load->model('system_model');
		$ci->load->helper('file');
		/*
		$cf =& get_instance();
		$cf->load->model('filter_model');*/
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
	
	private function get_base_url($wikiname){
		$result = $this->db->query("select wiki_baseurl from wiki where wiki_name = $wikiname")->result();
		
		foreach($result as $row){
			return $row->wiki_baseurl;
		}
		
		return false;
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
   	
   	function new_wiki($wikiname, $db_server, $db_name, $db_user, $db_password, $wiki_baseurl){
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
   				'wiki_connection' => "$my_con",
   				'wiki_baseurl' => "$wiki_baseurl"
   				);
			$this->db->insert('wiki', $sql);
		
			//Si no hay error de inserción, devolvemos el id de la wiki
			if($this->db->affected_rows() != 1) 
				return "new_wiki(): ERR_AFFECTED_ROWS (".$this->db->affected_rows().")";
		}
   	}
   	
   	
   	
   	function student_login($uname, $pass){
		$wikis = $this->db->query("select wiki_name from wiki")->result();
		
		foreach($wikis as $wiki){
			$link = $this->connection_model->connect($this->wconnection($wiki));
			
			$link -> from('user') 
			-> where('user_name = ' . "'" . $uname . "'") 
			-> where('user_password = ' . "'" . MD5($pass) . "'") 
			-> limit(1);
   
			$query = $link -> get();
       
			if($query->result()){
				foreach($query->result() as $row) 
					$sess_array = array('username' => $row -> user_name,
        						'language' => 'english',
        						'is_student' => 1,
        						'student_wiki' => $wiki,
        						'realname' => $row -> user_real_name
        						); 
				$this -> session -> set_userdata($sess_array);
				$this->update_last_session($uname);
				return true;
			}
		}
		
		return false;
   	}
   	
   	private function namespacestring($ns){
		switch($ns){
			case 0: return "Article";
			case 1: return "Talk";
			case 2: return "User";
			case 3: return "User Talk";
			case 6: return "File";
			case 10: return "Template";
			case 14: return "Category";
			default: return "Other";
		}
   	}
   	
   	function fetch($wikiname, $analisis){
		
		//Starting the analisis
		echo ">> Analisis started. </br>";
		echo "Connecting to database...</br>";
		ob_flush(); flush();
		
		//Connecting to the wiki database
   		$link = $this->connection_model->connect($this->wconnection($wikiname));
   		
   		echo "Querying database for general information...";
   		ob_flush(); flush();
   		
   		//Creating query string for the general query
   		$qstr = "select rev_id, rev_page, page_id, page_title, page_counter, page_namespace, page_is_new, user_id, user_name, user_real_name, user_email, user_registration, rev_timestamp, rev_len from revision, user, page where rev_page = page_id and rev_user = user_id order by rev_timestamp asc";		
		
		//Querying database
   		$query = $link->query($qstr);
   		
   		//If no results then return false
   		if(!$query->result()){
			echo "fail.</br>";
			return false;
		}
		else
			echo "done.</br>";
			
		$analisis_data = array();
		
   		echo "Storing information...";
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
			$totalactivityhour_art[date('H', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$totalactivitywday[date('D', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$totalactivityweek[date('W', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$totalactivitymonth[date('M', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$totalactivityyear[date('Y', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$totalactivitywday_art[date('D', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$totalactivityweek_art[date('W', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$totalactivitymonth_art[date('M', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$totalactivityyear_art[date('Y', $this->mwtime_to_unix($row->rev_timestamp))] = 0;
			$totalbytes[$this->mwtime_to_unix($row->rev_timestamp)] = 0;
			$totalbytes_art[$this->mwtime_to_unix($row->rev_timestamp)] = 0;
			$totalbytes_talk[$this->mwtime_to_unix($row->rev_timestamp)] = 0;
			$totalbytes_us[$this->mwtime_to_unix($row->rev_timestamp)] = 0;
			$totalbytes_ustalk[$this->mwtime_to_unix($row->rev_timestamp)] = 0;
			$totalbytes_file[$this->mwtime_to_unix($row->rev_timestamp)] = 0;
			$totalbytes_temp[$this->mwtime_to_unix($row->rev_timestamp)] = 0;
			$totalbytes_cat[$this->mwtime_to_unix($row->rev_timestamp)] = 0;
			
			
			$pagebytes[$row->page_title] = array();
			$pagebytes_art[$row->page_title] = array();
			$userpage[$row->user_name] = array();
			$pageuser[$row->page_title] = array();
			$usercreatedpages[$row->user_name]= array();
			$pageusereditscount[$row->page_title][$row->user_name] = 0;
			$pageuserbytescount[$row->page_title][$row->user_name] = 0;
   		}
   		
   		$aux_edits_art = array();
		$aux_edits_talk = array();
		$aux_edits_us = array();
		$aux_edits_ustalk = array();
		$aux_edits_file = array();
		$aux_edits_temp = array();
		$aux_edits_cat = array();
		
		$aux_pages_art = array();
		$aux_pages_talk = array();
		$aux_pages_us = array();
		$aux_pages_ustalk = array();
		$aux_pages_file = array();
		$aux_pages_temp = array();
		$aux_pages_cat = array();
			
		$totalbytescount = 0;
		$totalbytesartcount = 0;
		$totalbytestalkcount = 0;
		$totalbytesuscount = 0;
		$totalbytesustalkcount = 0;
		$totalbytesfilecount = 0;
		$totalbytestempcount = 0;
		$totalbytescatcount = 0;
		
   		//Storing classified information in arrays
   		
   		//This loop clasifies all the data contained in the query (which ignores uploads info) in arrays. 
   		foreach($query->result() as $row){
   			
   			//USEFUL VARIABLES
   			
   			$LAST_PAGE_SIZE = ($row->page_is_new == 0) ? end($pagebytes[$row->page_title]) : 0;
   			$LAST_PAGEBYTES_ARRAY = $pagebytes;
   			$tamdiff = $row->rev_len - $LAST_PAGE_SIZE;
   			
   			//RELATION ARRAYS
   			
   			$userpage[$row->user_name][$row->page_title] = true;
   			$pageuser[$row->page_title][$row->user_name] = true;

			//USER INFORMATION
			
			$userid			[$row->user_name] = $row->user_id;
			$iduser			[$row->user_id] = $row->user_name;
			$usereditscount		[$row->user_name] += 1;								// Counts the total editions per user
			$userbytescount		[$row->user_name] += $tamdiff;
			
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
				$userbytescount_art	[$row->user_name] += $tamdiff;							// Counts total bytes per user 
					
				$useredits_art		[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $usereditscount_art[$row->user_name];	// Editions of article per user/date
				$userbytes_art		[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $userbytescount_art[$row->user_name];	// Bytes per user/date
			}
				
			$useractivityhour[$row->user_name][date('H', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$useractivitywday[$row->user_name][date('w', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$useractivityweek[$row->user_name][date('W', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$useractivitymonth[$row->user_name][date('m', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$useractivityyear[$row->user_name][date('Y', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			
			$revisionuser[$row->rev_id] = $row->user_name;
			
			
			//PAGE INFORMATION
			
			$pageid			[$row->page_title] = $row->page_id;
			$pageeditscount		[$row->page_title] += 1;							// Count of the total editions per page
			$pageusereditscount	[$row->page_title][$row->user_name] += 1;					// Count of the total editions per page & user
			$pagebytescount		[$row->page_title] += $tamdiff;							// Count of the total bytes per page
			$pageuserbytescount	[$row->page_title][$row->user_name] += $tamdiff;				// Count of the total bytes per page & user
				
			$pageusercount	[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] = count($pageuser[$row->page_title]);						// Users per page/date
				
			$pageedits	[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] = $pageeditscount[$row->page_title];						// Editions per page/date
			$pageuseredits	[$row->page_title][$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $pageusereditscount[$row->page_title][$row->user_name];	// Count of editions per page & user
			$pagebytes	[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] = $pagebytescount[$row->page_title];						// Bytes per page/date
			$pageuserbytes	[$row->page_title][$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $pageuserbytescount[$row->page_title][$row->user_name];	// Bytes per page/date
				
			$pagenamespace	[$row->page_title] = $this->namespacestring($row->page_namespace);		// Getting namespaces per page
			$pagevisits	[$row->page_title] = $row->page_counter;					// Total visits per page
				
			$pageactivityhour	[$row->page_title][date('H', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$pageactivitywday	[$row->page_title][date('w', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$pageactivityweek	[$row->page_title][date('W', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$pageactivitymonth	[$row->page_title][date('m', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			$pageactivityyear	[$row->page_title][date('Y', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			
			$revisionpage	[$row->page_title][$row->rev_id] = true; 
   			
   			
			//TOTAL INFORMATION
			$aux_edits [$row->rev_id] = 1;
			if($row->page_namespace == 0) 
				$aux_edits_art [$row->rev_id] = 1;
			if($row->page_namespace == 1) 
				$aux_edits_talk [$row->rev_id] = 1;
			if($row->page_namespace == 2) 
				$aux_edits_us [$row->rev_id] = 1;
			if($row->page_namespace == 3) 
				$aux_edits_ustalk [$row->rev_id] = 1;
			if($row->page_namespace == 6) 
				$aux_edits_file [$row->rev_id] = 1;
			if($row->page_namespace == 10) 
				$aux_edits_temp [$row->rev_id] = 1;
			if($row->page_namespace == 14) 
				$aux_edits_cat [$row->rev_id] = 1;
				
			$aux_pages [$row->page_title] = 1;
			if($row->page_namespace == 0) 
				$aux_pages_art [$row->page_title] = 1;
			if($row->page_namespace == 1) 
				$aux_pages_talk [$row->page_title] = 1;
			if($row->page_namespace == 2) 
				$aux_pages_us [$row->page_title] = 1;
			if($row->page_namespace == 3) 
				$aux_pages_ustalk [$row->page_title] = 1;
			if($row->page_namespace == 6) 
				$aux_pages_file [$row->page_title] = 1;
			if($row->page_namespace == 10) 
				$aux_pages_temp [$row->page_title] = 1;
			if($row->page_namespace == 14) 
				$aux_pages_cat [$row->page_title] = 1;
				
			$aux_users [$row->user_name] = 1;
			if($row->page_namespace == 0) 
				$aux_users_art [$row->user_name] = 1;
			
			$totaledits[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_edits);
			$totaledits_art[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_edits_art);
			$totaledits_talk[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_edits_talk);
			$totaledits_us[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_edits_us);
			$totaledits_ustalk[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_edits_ustalk);
			$totaledits_file[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_edits_file);
			$totaledits_temp[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_edits_temp);
			$totaledits_cat[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_edits_cat);
			
			$totalpages[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_pages);
			$totalpages_art[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_pages_art);
			$totalpages_talk[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_pages_talk);
			$totalpages_us[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_pages_us);
			$totalpages_ustalk[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_pages_ustalk);
			$totalpages_file[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_pages_file);
			$totalpages_temp[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_pages_temp);
			$totalpages_cat[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_pages_cat);
			
			$totalusers[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_users);
			$totalusers_art[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_users_art);
			
			
			$totalbytesdiff[$this->mwtime_to_unix($row->rev_timestamp)] = $tamdiff;
			
			$totalbytescount += $tamdiff;
			if($row->page_namespace == 0)
				$totalbytesartcount += $tamdiff;
			if($row->page_namespace == 1)
				$totalbytestalkcount += $tamdiff;
			if($row->page_namespace == 2)
				$totalbytesuscount += $tamdiff;
			if($row->page_namespace == 3)
				$totalbytesustalkcount += $tamdiff;
			if($row->page_namespace == 6)
				$totalbytesfilecount += $tamdiff;
			if($row->page_namespace == 10)
				$totalbytestempcount += $tamdiff;
			if($row->page_namespace == 14)
				$totalbytescatcount += $tamdiff;
				
			$totalbytes[$this->mwtime_to_unix($row->rev_timestamp)] = $totalbytescount;
			$totalbytes_art[$this->mwtime_to_unix($row->rev_timestamp)] = $totalbytesartcount;
			$totalbytes_talk[$this->mwtime_to_unix($row->rev_timestamp)] = $totalbytestalkcount;
			$totalbytes_us[$this->mwtime_to_unix($row->rev_timestamp)] = $totalbytesuscount;
			$totalbytes_ustalk[$this->mwtime_to_unix($row->rev_timestamp)] = $totalbytesustalkcount;
			$totalbytes_file[$this->mwtime_to_unix($row->rev_timestamp)] = $totalbytesfilecount;
			$totalbytes_temp[$this->mwtime_to_unix($row->rev_timestamp)] = $totalbytestempcount;
			$totalbytes_cat[$this->mwtime_to_unix($row->rev_timestamp)] = $totalbytescatcount;
			
			$totalvisits = array_sum($pagevisits);
			$revisiondate[$row->rev_id] = $this->mwtime_to_unix($row->rev_timestamp);
			$daterevision[$this->mwtime_to_unix($row->rev_timestamp)] = $row->rev_id;
				
			$totalactivityhour[date('H', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			if($row->page_namespace == 0)
				$totalactivityhour_art[date('H', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
				
			$totalactivitywday[date('D', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			if($row->page_namespace == 0)
				$totalactivitywday_art[date('D', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
				
			$totalactivityweek[date('W', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			if($row->page_namespace == 0)
				$totalactivityweek_art[date('W', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
				
			$totalactivitymonth[date('M', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			if($row->page_namespace == 0)
				$totalactivitymonth_art[date('M', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
				
			$totalactivityyear[date('Y', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			if($row->page_namespace == 0)
				$totalactivityyear_art[date('Y', $this->mwtime_to_unix($row->rev_timestamp))] += 1;
			
			
			//PERCENTAGES
			
			$useredits_per		[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $useredits	[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] / $totaledits[$this->mwtime_to_unix($row->rev_timestamp)];
			$userbytes_per		[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $userbytes	[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] / $totalbytes[$this->mwtime_to_unix($row->rev_timestamp)];
			if($row->page_namespace == 0){
				$useredits_art_per	[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $useredits_art	[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] / $totaledits[$this->mwtime_to_unix($row->rev_timestamp)];
				$userbytes_art_per	[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $userbytes_art	[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] / $totalbytes[$this->mwtime_to_unix($row->rev_timestamp)];
			}
			
			$pageedits_per[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] = $pageedits[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] / $totaledits[$this->mwtime_to_unix($row->rev_timestamp)];
			$pageuseredits_per[$row->page_title][$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $pageuseredits[$row->page_title][$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] / $pageeditscount[$row->page_title];
			$pagebytes_per[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] = $pagebytes[$row->page_title][$this->mwtime_to_unix($row->rev_timestamp)] / $totalbytes[$this->mwtime_to_unix($row->rev_timestamp)];
			$pageuserbytes_per[$row->page_title][$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = ($pagebytescount[$row->page_title] != 0) ? $pageuserbytes[$row->page_title][$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] / $pagebytescount[$row->page_title] : 0;
   		}
   		
   		$analisis_data = array_merge($analisis_data, array('useredits' => $useredits
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
			, 'pageedits' => $pageedits
			, 'pagebytes' => $pagebytes
			, 'pagebytes_per' => $pagebytes_per
			, 'pageedits_per' => $pageedits_per
			, 'pagenamespace' => $pagenamespace
			, 'pagevisits' => $pagevisits
			, 'totaledits' => $totaledits
			, 'totaledits_art' => $totaledits_art
			, 'totaledits_talk' => $totaledits_talk
			, 'totaledits_us' => $totaledits_us
			, 'totaledits_ustalk' => $totaledits_ustalk
			, 'totaledits_file' => $totaledits_file
			, 'totaledits_temp' => $totaledits_temp
			, 'totaledits_cat' => $totaledits_cat
			, 'totalpages' => $totalpages
			, 'totalpages_art' => $totalpages_art
			, 'totalpages_talk' => $totalpages_art
			, 'totalpages_us' => $totalpages_us
			, 'totalpages_ustalk' => $totalpages_ustalk
			, 'totalpages_file' => $totalpages_file
			, 'totalpages_temp' => $totalpages_temp
			, 'totalpages_cat' => $totalpages_cat
			, 'totalusers' => $totalusers
			, 'totalusers_art' => $totalusers_art
			, 'totalvisits' => $totalvisits
			, 'totalbytes' => $totalbytes
			, 'totalbytes_art' => $totalbytes_art
			, 'totalbytes_talk' => $totalbytes_talk
			, 'totalbytes_us' => $totalbytes_us
			, 'totalbytes_ustalk' => $totalbytes_ustalk
			, 'totalbytes_file' => $totalbytes_file
			, 'totalbytes_temp' => $totalbytes_temp
			, 'totalbytes_cat' => $totalbytes_cat
			, 'pageusercount' => $pageusercount
			, 'revisiondate' => $revisiondate
			, 'daterevision' => $daterevision
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
			, 'totalactivityhour' => $totalactivityhour
			, 'totalactivityhour_art' => $totalactivityhour_art
			, 'totalactivitywday' => $totalactivitywday
			, 'totalactivitywday_art' => $totalactivitywday_art
			, 'totalactivityweek' => $totalactivityweek
			, 'totalactivityweek_art' => $totalactivityweek_art
			, 'totalactivitymonth' => $totalactivitymonth
			, 'totalactivitymonth_art' => $totalactivitymonth_art
			, 'totalactivityyear' => $totalactivityyear
			, 'totalactivityyear_art' => $totalactivityyear_art
			, 'revisionpage' => $revisionpage
			, 'totalbytesdiff' => $totalbytesdiff
			, 'userpage' => $userpage
			, 'pageuser' => $pageuser
			, 'pageuseredits' => $pageuseredits
			, 'pageuseredits_per' => $pageuseredits_per
			, 'pageuserbytes' => $pageuserbytes
			, 'pageuserbytes_per' => $pageuserbytes_per
			, 'revisionuser' => $revisionuser
			, 'pageusereditscount' => $pageuseredits
			, 'pageuserbytescount' => $pageuserbytes
			, 'pageid' => $pageid));
						
   		echo "done.</br>";
   		echo "Querying database for category information...";
   		
   		$qstr = "select rev_id, rev_page, page_title, page_counter, page_namespace, page_is_new, user_id, user_name, user_real_name, user_email, user_registration, rev_timestamp, cl_to, cat_pages, rev_len, cat_id from revision, user, page, categorylinks, category where rev_page = page_id and rev_user = user_id and page_id = cl_from and cl_to = cat_title order by rev_timestamp asc";		
		
		//Querying database
   		$query = $link->query($qstr);
		
		if($query->result()){
			echo "done.</br>";
			$catexist = true;
			echo "Storing category information...";
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
				$catusereditscount[$row->cl_to][$row->user_name] = 0;
				$catuserbytescount[$row->cl_to][$row->user_name] = 0;
				
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
				$tamdiff = $row->rev_len - $LAST_PAGE_SIZE;
				
				//RELATION ARRAYS
				
				$catid	 [$row->cl_to] = $row->cat_id;
				
				$usercat [$row->user_name][$row->cl_to] = true;
				$pagecat [$row->page_title][$row->cl_to] = true;
				$catuser [$row->cl_to][$row->user_name] = true;
				$catpage [$row->cl_to][$row->page_title] = true;

				//USER INFORMATION
				
				$usercatcount[$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = count($usercat[$row->user_name]);	// Categories per cat/date
				$catusereditscount	[$row->cl_to][$row->user_name] += 1;					// Count of the total editions per cat & user
				$catuserbytescount	[$row->cl_to][$row->user_name] += $tamdiff;				// Count of the total bytes per cat & user
				$catuseredits		[$row->cl_to][$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $catusereditscount[$row->cl_to][$row->user_name];	// Count of editions per cat & user
				$catuserbytes		[$row->cl_to][$row->user_name][$this->mwtime_to_unix($row->rev_timestamp)] = $catuserbytescount[$row->cl_to][$row->user_name];	// Bytes per cat/date
				
				
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
				
				$revisioncategory[$row->cl_to][$row->rev_id] = true; 
				
				//TOTAL INFORMATION
				
				$aux_categories[$row->cl_to] = 1;
				$totalcategories[$this->mwtime_to_unix($row->rev_timestamp)] = array_sum($aux_categories);
				
				//PERCENTAGES
				
				$catpages_per[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] = $catpages[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] / $totalpages[$this->mwtime_to_unix($row->rev_timestamp)];
				$catusers_per[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] = $catusers[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] / $totalusers[$this->mwtime_to_unix($row->rev_timestamp)];
				$catedits_per[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] = $catedits[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] / $totaledits[$this->mwtime_to_unix($row->rev_timestamp)];
				$catbytes_per[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] = $catbytes[$row->cl_to][$this->mwtime_to_unix($row->rev_timestamp)] / $totalbytes[$this->mwtime_to_unix($row->rev_timestamp)];
			}
			
			echo "done.</br>";
			
			$analisis_data = array_merge($analisis_data, array('catpages' => $catpages
						, 'catpages_per' => $catpages_per
						, 'catusers' => $catusers
						, 'catusers_per' => $catusers_per
						, 'catedits' => $catedits
						, 'catedits_per' => $catedits_per
						, 'catbytes' => $catbytes
						, 'catbytes_per' => $catbytes_per
						, 'usercat' => $usercat
						, 'usercatcount' => $usercatcount
						, 'pagecatcount' => $pagecatcount
						, 'catactivityhour' => $catactivityhour
						, 'catactivitywday' => $catactivitywday
						, 'catactivityweek' => $catactivityweek
						, 'catactivitymonth' => $catactivitymonth
						, 'catactivityyear' => $catactivityyear
						, 'totalcategories' => $totalcategories
						, 'pagecat' => $pagecat
						, 'catuserbytes' => $catuserbytes
						, 'catuseredits' => $catuseredits
						, 'catuserbytescount' => $catuserbytescount
						, 'catusereditscount' => $catusereditscount
						, 'catuser' => $catuser
						, 'revisioncategory' => $revisioncategory
						, 'catid' => $catid));
   		}
   		else 
			echo "fail.</br>";
   		
   		echo "Querying database for uploads information...";
   		ob_flush(); flush();
   		
   		//Creating query string for the uploads query
   		$qstr = "select img_name, user_name, img_timestamp, img_size, page_title from image, page, user, imagelinks where img_name = il_to and il_from = page_id and img_user = user_id order by img_timestamp asc";
		
		//Querying database
		$query = $link->query($qstr);
		
		//If there is information about uploads
   		if($query->result()){
			echo "done.</br>";
			echo "Storing uploads information...";
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
				
				$imagesize[$row->img_name] = $row->img_size;
				
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
			
			echo "done.</br>";
			
			$analisis_data = array_merge($analisis_data, array('useruploads' => $useruploads
							, 'useruploads_per' => $useruploads_per
							, 'userupsize' => $userupsize
							, 'userupsize_per' => $userupsize_per
							, 'userimages' => $userimages
							, 'pageuploads' => $pageuploads
							, 'pageuploads_per' => $pageuploads_per
							, 'pageupsize' => $pageupsize
							, 'pageupsize_per' => $pageupsize_per
							, 'pageimages' => $pageimages
							, 'totaluploads' => $totaluploads
							, 'totalupsize' => $totalupsize
							, 'totalimages' => $totalimages
							, 'imagesize' => $imagesize
						));
			
			if($catexist){
			
				echo "Querying database for uploads information in categories...";
				
				$qstr = "select img_name, user_name, img_timestamp, img_size, page_title, cl_to from image, page, user, imagelinks, categorylinks where img_name = il_to and il_from = page_id and page_id = cl_from and img_user = user_id order by img_timestamp asc";
				
				//Querying database
				$query = $link->query($qstr);
				if($query->result()){
					echo "done.</br>";
					echo "Storing uploads information in categories...";
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
					
					echo "done.</br>";
					ob_flush(); flush();
				}else{
					echo "fail.</br>";
					ob_flush(); flush();
				}
				
				$analisis_data = array_merge($analisis_data, array('catuploads' => $catuploads
					, 'catuploads_per' => $catuploads_per
					, 'catupsize' => $catupsize
					, 'catimages' => $catimages
					, 'catupsize_per' => $catupsize_per));
			}
		}else{
			echo "fail.</br>";
		}
		
		echo ">> Wiki analisis accomplished.</br>";
   		ob_flush(); flush();
   		
   		//Calculating warnings
   		
   		//Returning data
   		return $analisis_data;
   	}
   	
   	function get_page($title, $wikiname){
   		$url = $this->get_base_url($wikiname)."/api.php?action=query&prop=revisions&rvlimit=1&rvprop=content&format=xml&action=parse&titles=".$title;
   		
   		if($this->system_model->fopen_enabled())
			return file_get_contents($url);
   		else{
			$ch = curl_init($url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			return curl_exec($ch);
   		}
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
