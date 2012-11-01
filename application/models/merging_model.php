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


class Merging_model extends CI_Model{
	
	
   	function Merging_model(){
   		//Llamamos al constructor heredado.
   	   	parent::__construct();
   	   	$this->load->database();
   	   	
   	   	//Cargamos models necesarios
   	   	$ci =& get_instance();
		$ci->load->model('wiki_model');
		$co =& get_instance();
		$co->load->model('color_model');
   	}
   	
   	function save_general_stats($wikiname, $analisis){
   		//Establecemos conexión con la base de datos de la wiki
   		$link = $this->connection_model->connect($this->wconnection($wikiname));
   		
   		//Consultamos a la tabla de estadísticas
   		$result = $link->query("SELECT * FROM site_stats") -> result();
   		
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
   					'wgen_analisis' => "$analisis"
   				);
			}
			
		//Lo insertamos en nuestro análisis
		$this->db->insert('wgeneral', $sql);
		
		//Comprobamos que la inserción se hizo con éxito
		if($this->db->affected_rows() != 1) 
			return "fetch_general_stats(): ERR_AFFECTED_ROWS (".$this->db->affected_rows().")";
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
   				'wu_edits' => $wikidata['useredits'][$uname],
   				'wu_edits_per' => $wikidata['useredits_per'][$uname],
   				'wu_edits_art' => $wikidata['useredits_art'][$uname],
   				'wu_edits_art_per' => $wikidata['useredits_art_per'][$uname],
   				'wu_bytes' => $wikidata['userbytes'][$uname],
   				'wu_bytes_per' => $wikidata['userbytes_per'][$uname],
   				'wu_bytes_art' => $wikidata['userbytes_art'][$uname],
   				'wu_bytes_art_per' => $wikidata['userbytes_art_per'][$uname],
   				'wu_uploads' => $wikidata['useruploads'][$uname],
   				'wu_uploads_per' => $wikidata['useruploads_per'][$uname],
   				'wu_neval' => $colordata['neval'][$uname],
   				'wu_avg_mark' => $colordata['avg_mark'][$uname],
   				'wu_replies_in' => $colordata['rep_in'][$uname],
   				'wu_replies_out' => $colordata['rep_out'][$uname],
   				'wu_type' => $wikidata['filtertype'],
   				'wu_type_str' => $wikidata['filtername'],
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
   				'wu_edits' => $wikidata['useredits'][$uname],
   				'wu_edits_per' => $wikidata['useredits_per'][$uname],
   				'wu_edits_art' => $wikidata['useredits_art'][$uname],
   				'wu_edits_art_per' => $wikidata['useredits_art_per'][$uname],
   				'wu_bytes' => $wikidata['userbytes'][$uname],
   				'wu_bytes_per' => $wikidata['userbytes_per'][$uname],
   				'wu_bytes_art' => $wikidata['userbytes_art'][$uname],
   				'wu_bytes_art_per' => $wikidata['userbytes_art_per'][$uname],
   				'wu_uploads' => $wikidata['useruploads'][$uname],
   				'wu_uploads_per' => $wikidata['useruploads_per'][$uname],
   				'wu_neval' => NULL,
   				'wu_avg_mark' => NULL,
   				'wu_replies_in' => NULL,
   				'wu_replies_out' => NULL,
   				'wu_type' => $wikidata['filtertype'],
   				'wu_type_str' => $wikidata['filtername'],
   				'wu_analisis' => "$analisis"
   				);
   				
				$this->db->insert('wuser', $sql);
			}
		}
		
		return TRUE;
   	}
   	
   	function save_pages($wikiname, $analisis, /*$colorname = 'default',*/ $date_range_a = 'default', $date_range_b = 'default', $filter_user = 'default'){
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
   				'wp_namespace' => $wikidata['pagenamespace'][$pname],
   				'wp_edits' => $wikidata['pageedits'][$pname],
   				'wp_edits_per' => $wikidata['pageedits_per'][$pname],
   				'wp_bytes' => $wikidata['pagebytes'][$pname],
   				'wp_bytes_per' => $wikidata['pagebytes_per'][$pname],
   				'wp_visits' => $wikidata['pagevisits'][$pname],
   				'wp_visits_per' => $wikidata['pagevisits_per'][$pname],
   				'wp_type' => $wikidata['filtertype'],
   				'wp_type_str' => $wikidata['filtername'],
   				'wp_analisis' => "$analisis"
   				);
   				
				$this->db->insert('wpage', $sql);
			}
		//}
		
		return TRUE;
   	}
   	
   	function save_categories($wikiname, $analisis, /*$colorname = 'default',*/ $date_range_a = 'default', $date_range_b = 'default', $filter_page = 'default', $filter_user = 'default'){
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
		//else{
			foreach($catnames as $catname){
				$sql = array(
				'wc_id' => "",
   				'wc_name' => "$catname",
   				'wc_pages' => $wikidata['catpages'][$catname],
   				'wc_pages_per' => $wikidata['catpages_per'][$catname],
   				'wc_edits' => $wikidata['catedits'][$catname],
   				'wc_edits_per' => $wikidata['catedits_per'][$catname],
   				'wc_bytes' => $wikidata['catbytes'][$catname],
   				'wc_bytes_per' => $wikidata['catbytes_per'][$catname],
   				'wc_visits' => $wikidata['catvisits'][$catname],
   				'wc_visits_per' => $wikidata['catvisits_per'][$catname],
   				'wc_type' => $wikidata['filtertype'],
   				'wc_type_str' => $wikidata['filtername'],
   				'wc_analisis' => "$analisis"
   				);
   				
				$this->db->insert('wcategory', $sql);
			}
		//}
		
		return TRUE;
   	}
   	
   	function save_images($wikiname, $analisis, /*$colorname = 'default',*/ $date_range_a = 'default', $date_range_b = 'default', $filter_page = 'default', $filter_user = 'default', $filter_category = 'default'){
		//Fetching images info from wiki
		$wikidata = $this->wiki_model->fetch_images($wikiname, $date_range_a, $date_range_b, $filter_user, $filter_page, $filter_category);
		
		//Check no errors
		if(gettype($wikidata) == "string")
			return "save_images(): $wikidata";
		
		//Creating list of images names
		foreach(array_keys($wikidata['imgsizes']) as $key)
			$imgnames[] = $key;
		
		//If color provided, then fetch data from color database...
		//if ($colorname != 'default'){
		//	$colordata = $this->color_model->fetch_evaluations($colorname, $date_range_a, $date_range_b);
			
			//Check no errors
		//	if(gettype($colordata) == "string")
		//		return "merge_save_users(): $colordata";
			
			//...and merge it with wiki info, adding it to local database
			foreach($imgnames as $imgname){
				$sql = array(
				'wi_id' => "",
   				'wi_name' => "$imgname",
   				'wi_user_text' => $wikidata['imgtexts'][$imgname],
   				'wi_timestamp' => $wikidata['imgtimes'][$imgname],
   				'wi_size' => $wikidata['imgsizes'][$imgname],
   				'wi_user' => $wikidata['imgusers'][$imgname],
   				'wi_type' => $wikidata['filtertype'],
   				'wi_type_src' => $wikidata['filtername'],
   				'wi_analisis' => "$analisis"
   				);
   				
				$this->db->insert('wimage', $sql);
			}
// 		}
		
		//If color not provided, fill color data with NULL, and add to local database
// 		else{
// 			foreach($unames as $uname){
// 				$sql = array(
// 				'wu_id' => "",
//    				'wu_name' => "$uname",
//    				'wu_edits' => $wikidata['useredits'][$uname]
//    				'wu_edits_per' => $wikidata['useredits_per'][$uname]
//    				'wu_edits_art' => $wikidata['useredits_art'][$uname]
//    				'wu_edits_art_per' => $wikidata['useredits_art_per'][$uname]
//    				'wu_bytes' => $wikidata['userbytes'][$uname]
//    				'wu_bytes_per' => $wikidata['userbytes_per'][$uname]
//    				'wu_bytes_art' => $wikidata['userbytes_art'][$uname]
//    				'wu_bytes_art_per' => $wikidata['userbytes_art_per'][$uname]
//    				'wu_uploads' => $wikidata['useruploads'][$uname]
//    				'wu_uploads_per' => $wikidata['useruploads_per'][$uname]
//    				'wu_neval' => NULL
//    				'wu_avg_mark' => NULL
//    				'wu_replies_in' => NULL
//    				'wu_replies_out' => NULL
//    				'wu_type' => "$wikidata['filtertype']"
//    				'wu_type_str' => "$wikidata['filtername']"
//    				'wu_analisis' => "$analisis"
//    				);
//    				
// 				$this->db->insert('wuser', $sql);
// 			}
// 		}
		
		return TRUE;
   	}
   	
   	function save_content_evolution($wikiname, $analisis, $colorname = 'default', $date_range_a = 'default', $date_range_b = 'default', $filter_user = 'default', $filter_page = 'default', $filter_category = 'default'){
		//Fetching images info from data bases
		$wikidata = $this->wiki_model->fetch_content_evolution($wikiname, $date_range_a, $date_range_b, $filter_user, $filter_page, $filter_category);
		
		$colordata = $this->color_model->fetch_quality_evolution($colorname, $filter_user);
		
		//Check no errors
		if(gettype($wikidata) == "string")
			return "save_content_evolution(): $wikidata";
		if(gettype($colordata) == "string")
			return "save_content_evolution(): $colordata";
		
		//Inserting data
		foreach(array_keys($wikidata) as $key){
			$sql = array(
				'da_id' => $analisis."contentevolution",
				'da_s1' => $key,
				'da_s2' => $wikidata[$key],
				'da_s3' => $colordata[$key]
   				);
   				
			$this->db->insert('data', $sql);
		}
			
		//Registering chart
		$sql = array(
			'ch_id' => $analisis."contentevolution",
			'ch_title' => lang('content_evolution'),
			'ch_type' => "combo");
		
		$this->db->insert('chart', $sql);
		
		return TRUE;
   	}
   	
   	function save_activity($wikiname, $analisis, $colorname = 'default', $date_range_a = 'default', $date_range_b = 'default', $filter_user = 'default', $filter_page = 'default', $filter_category = 'default'){
		//Fetching images info from data bases
		$wikidata = $this->wiki_model->fetch_activity($wikiname, $date_range_a, $date_range_b, $filter_user, $filter_page, $filter_category);
		
		$colordata = $this->color_model->fetch_activity($colorname, $filter_user);
		
		//Check no errors
		if(gettype($wikidata) == "string")
			return "save_activity(): $wikidata";
		if(gettype($colordata) == "string")
			return "save_activity(): $colordata";
			
		//Calculating data
		//////////////////////////////////////////////////////////////////
		
		//Inserting data
		foreach(array_keys($wikidata) as $key){
			$sql = array(
				'da_id' => $analisis."contentevolution",
				'da_s1' => $key,
				'da_s2' => $wikidata[$key],
				'da_s3' => $colordata[$key]
   				);
   				
			$this->db->insert('data', $sql);
		}
			
		//Registering chart
		$sql = array(
			'ch_id' => $analisis."contentevolution",
			'ch_title' => lang('content_evolution'),
			'ch_type' => "combo");
		
		$this->db->insert('chart', $sql);
		
		return TRUE;
   	}
}