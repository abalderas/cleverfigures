 
<?php

//AVAILABLE METHODS


class Merging_model extends CI_Model{
	
	
   	function Merging_model(){
   		//Llamamos al constructor heredado.
   	   	parent::__construct();
   	   	
   	   	//Cargamos helpers
   	   	$this->load->helper('date');
   	   	
   	   	//Cargamos models necesarios
   	   	$ci =& get_instance();
		$ci->load->model('wiki_model');
		$co =& get_instance();
		$co->load->model('color_model');
   	}
   	
   	function merge_save_users($wikiname, $analisis, $colorname = 'default', $date_range_a = 'default', $date_range_b = 'default', $filter_page = 'default', $filter_category = 'default'){
		//Fetching users info from wiki
		$wikidata = $this->wiki_model->fetch_users($wikiname, $date_range_a, $date_range_b, $filter_page, $filter_category);
		
		//Check no errors
		if(gettype($wikidata) == "string")
			return "merge_save_users(): $wikidata";
		
		//Creating list of user names
		foreach(array_keys($wikidata['userrealname']) as $key)
			$unames[] = $key;
		
		//If color provided, then fetch data from color database...
		if ($colorname != 'default'){
			$colordata = $this->color_model->fetch_evaluations($colorname, $date_range_a, $date_range_b);
			
			//Check no errors
			if(gettype($colordata) == "string")
				return "merge_save_users(): $colordata";
			
			//...and merge it with wiki info, adding it to local database
			foreach($unames as $uname){
				$sql = array(
				'wu_id' => "",
   				'wu_name' => "$uname",
   				'wu_edits' => $wikidata['useredits'][$uname]
   				'wu_edits_per' => $wikidata['useredits_per'][$uname]
   				'wu_edits_art' => $wikidata['useredits_art'][$uname]
   				'wu_edits_art_per' => $wikidata['useredits_art_per'][$uname]
   				'wu_bytes' => $wikidata['userbytes'][$uname]
   				'wu_bytes_per' => $wikidata['userbytes_per'][$uname]
   				'wu_bytes_art' => $wikidata['userbytes_art'][$uname]
   				'wu_bytes_art_per' => $wikidata['userbytes_art_per'][$uname]
   				'wu_uploads' => $wikidata['useruploads'][$uname]
   				'wu_uploads_per' => $wikidata['useruploads_per'][$uname]
   				'wu_neval' => $colordata['neval'][$uname]
   				'wu_avg_mark' => $colordata['avg_mark'][$uname]
   				'wu_replies_in' => $colordata['rep_in'][$uname]
   				'wu_replies_out' => $colordata['rep_out'][$uname]
   				'wu_type' => "$wikidata['filtertype']"
   				'wu_type_str' => "$wikidata['filtername']"
   				'wu_analisis' => "$analisis"
   				);
   				
				$this->db->insert('wuser', $sql);
			}
		}
		
		//If color not provided, fill color data with NULL, and add to local database
		else{
			foreach($unames as $uname){
				$sql = array(
				'wu_id' => "",
   				'wu_name' => "$uname",
   				'wu_edits' => $wikidata['useredits'][$uname]
   				'wu_edits_per' => $wikidata['useredits_per'][$uname]
   				'wu_edits_art' => $wikidata['useredits_art'][$uname]
   				'wu_edits_art_per' => $wikidata['useredits_art_per'][$uname]
   				'wu_bytes' => $wikidata['userbytes'][$uname]
   				'wu_bytes_per' => $wikidata['userbytes_per'][$uname]
   				'wu_bytes_art' => $wikidata['userbytes_art'][$uname]
   				'wu_bytes_art_per' => $wikidata['userbytes_art_per'][$uname]
   				'wu_uploads' => $wikidata['useruploads'][$uname]
   				'wu_uploads_per' => $wikidata['useruploads_per'][$uname]
   				'wu_neval' => NULL
   				'wu_avg_mark' => NULL
   				'wu_replies_in' => NULL
   				'wu_replies_out' => NULL
   				'wu_type' => "$wikidata['filtertype']"
   				'wu_type_str' => "$wikidata['filtername']"
   				'wu_analisis' => "$analisis"
   				);
   				
				$this->db->insert('wuser', $sql);
			}
		}
		
		return TRUE;
   	}
   	
   	function save_pages($wikiname, $analisis, $colorname = 'default', $date_range_a = 'default', $date_range_b = 'default', $filter_user = 'default'){
		//Fetching pages info from wiki
		$wikidata = $this->wiki_model->fetch_pages($wikiname, $date_range_a, $date_range_b, $filter_user);
		
		//Check no errors
		if(gettype($wikidata) == "string")
			return "save_pages(): $wikidata";
		
		//Creating list of cats names
		foreach(array_keys($wikidata['pagenamespace']) as $key)
			$pnames[] = $key;
		
		//If color provided, then fetch data from color database...
		//if ($colorname != 'default'){} to_do
		
		//If color not provided
		//else{
			foreach($pnames as $pname){
				$sql = array(
				'wp_id' => "",
   				'wp_name' => "$pname",
   				'wp_namespace' => $wikidata['pagenamespace'][$pname]
   				'wp_edits' => $wikidata['pageedits'][$pname]
   				'wp_edits_per' => $wikidata['pageedits_per'][$pname]
   				'wp_bytes' => $wikidata['pagebytes'][$pname]
   				'wp_bytes_per' => $wikidata['pagebytes_per'][$pname]
   				'wp_visits' => $wikidata['pagevisits'][$pname]
   				'wp_visits_per' => $wikidata['pagevisits_per'][$pname]
   				'wp_type' => "$wikidata['filtertype']"
   				'wp_type_str' => "$wikidata['filtername']"
   				'wp_analisis' => "$analisis"
   				);
   				
				$this->db->insert('wpage', $sql);
			}
		//}
		
		return TRUE;
   	}
   	
   	function save_categories($wikiname, $analisis, $colorname = 'default', $date_range_a = 'default', $date_range_b = 'default', $filter_page = 'default', $filter_user = 'default'){
		//Fetching cats info from wiki
		$wikidata = $this->wiki_model->fetch_categories($wikiname, $date_range_a, $date_range_b, $filter_page, $filter_user);
		
		//Check no errors
		if(gettype($wikidata) == "string")
			return "save_categories(): $wikidata";
		
		//Creating list of cats names
		foreach(array_keys($wikidata['catpages']) as $key)
			$catnames[] = $key;
		
		//If color provided, then fetch data from color database...
		//if ($colorname != 'default'){} to_do
		
		//If color not provided, fill color data with NULL, and add to local database
		else{
			foreach($unames as $uname){
				$sql = array(
				'wc_id' => "",
   				'wc_name' => "$uname",
   				'wc_pages' => $wikidata['catpages'][$uname]
   				'wc_pages_per' => $wikidata['catpages_per'][$uname]
   				'wc_edits' => $wikidata['catedits'][$uname]
   				'wc_edits_per' => $wikidata['catedits_per'][$uname]
   				'wc_bytes' => $wikidata['catbytes'][$uname]
   				'wc_bytes_per' => $wikidata['catbytes_per'][$uname]
   				'wc_visits' => $wikidata['catvisits'][$uname]
   				'wc_visits_per' => $wikidata['catvisits_per'][$uname]
   				'wc_type' => "$wikidata['filtertype']"
   				'wc_type_str' => "$wikidata['filtername']"
   				'wc_analisis' => "$analisis"
   				);
   				
				$this->db->insert('wcategory', $sql);
			}
		}
		
		return TRUE;
   	}
   	///////////////////////////////////////////////////////
   	function merge_save_users($wikiname, $analisis, $colorname = 'default', $date_range_a = 'default', $date_range_b = 'default', $filter_page = 'default', $filter_category = 'default'){
		//Fetching users info from wiki
		$wikidata = $this->wiki_model->fetch_users($wikiname, $date_range_a, $date_range_b, $filter_page, $filter_category);
		
		//Check no errors
		if(gettype($wikidata) == "string")
			return "merge_save_users(): $wikidata";
		
		//Creating list of user names
		foreach(array_keys($wikidata['userrealname']) as $key)
			$unames[] = $key;
		
		//If color provided, then fetch data from color database...
		if ($colorname != 'default'){
			$colordata = $this->color_model->fetch_evaluations($colorname, $date_range_a, $date_range_b);
			
			//Check no errors
			if(gettype($colordata) == "string")
				return "merge_save_users(): $colordata";
			
			//...and merge it with wiki info, adding it to local database
			foreach($unames as $uname){
				$sql = array(
				'wu_id' => "",
   				'wu_name' => "$uname",
   				'wu_edits' => $wikidata['useredits'][$uname]
   				'wu_edits_per' => $wikidata['useredits_per'][$uname]
   				'wu_edits_art' => $wikidata['useredits_art'][$uname]
   				'wu_edits_art_per' => $wikidata['useredits_art_per'][$uname]
   				'wu_bytes' => $wikidata['userbytes'][$uname]
   				'wu_bytes_per' => $wikidata['userbytes_per'][$uname]
   				'wu_bytes_art' => $wikidata['userbytes_art'][$uname]
   				'wu_bytes_art_per' => $wikidata['userbytes_art_per'][$uname]
   				'wu_uploads' => $wikidata['useruploads'][$uname]
   				'wu_uploads_per' => $wikidata['useruploads_per'][$uname]
   				'wu_neval' => $colordata['neval'][$uname]
   				'wu_avg_mark' => $colordata['avg_mark'][$uname]
   				'wu_replies_in' => $colordata['rep_in'][$uname]
   				'wu_replies_out' => $colordata['rep_out'][$uname]
   				'wu_type' => "$wikidata['filtertype']"
   				'wu_type_str' => "$wikidata['filtername']"
   				'wu_analisis' => "$analisis"
   				);
   				
				$this->db->insert('wuser', $sql);
			}
		}
		
		//If color not provided, fill color data with NULL, and add to local database
		else{
			foreach($unames as $uname){
				$sql = array(
				'wu_id' => "",
   				'wu_name' => "$uname",
   				'wu_edits' => $wikidata['useredits'][$uname]
   				'wu_edits_per' => $wikidata['useredits_per'][$uname]
   				'wu_edits_art' => $wikidata['useredits_art'][$uname]
   				'wu_edits_art_per' => $wikidata['useredits_art_per'][$uname]
   				'wu_bytes' => $wikidata['userbytes'][$uname]
   				'wu_bytes_per' => $wikidata['userbytes_per'][$uname]
   				'wu_bytes_art' => $wikidata['userbytes_art'][$uname]
   				'wu_bytes_art_per' => $wikidata['userbytes_art_per'][$uname]
   				'wu_uploads' => $wikidata['useruploads'][$uname]
   				'wu_uploads_per' => $wikidata['useruploads_per'][$uname]
   				'wu_neval' => NULL
   				'wu_avg_mark' => NULL
   				'wu_replies_in' => NULL
   				'wu_replies_out' => NULL
   				'wu_type' => "$wikidata['filtertype']"
   				'wu_type_str' => "$wikidata['filtername']"
   				'wu_analisis' => "$analisis"
   				);
   				
				$this->db->insert('wuser', $sql);
			}
		}
		
		return TRUE;
   	}
}

?> 
