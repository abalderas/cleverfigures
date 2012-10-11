<?php

//AVAILABLE METHODS
//	Wiki_model()
// 	name()
//    	connection()
//    	fetch()
//    	delete_wiki()


class Wiki_model extends CI_Model{
	
	//ATTRIBUTES
	private $wiki_id;
	private $wiki_connection;
	private $wiki_link;
	
	//METHODS
	//constructor
   	function Wiki_model($id, $connection){
   	   	parent::__construct();
   	   	$this->load->helper('date');
   	   	$ci =& get_instance();
		$ci->load->model('connection_model');
   	   	
		$this->wiki_id = $id;
		$this->wiki_connection = $connection;
		
		$check = $this->db->query("select * from Wiki where wiki_id == $this->wiki_id");
   		if($check->result()->num_rows() != 0)
   			die("Wiki_model:__construct(): Wiki $this->wiki_id already exists.");
   		else{
   			$sql = array('wiki_id' => "$this->wiki_id",
   				'wiki_connection' => "$this->wiki_connection"
   				);
			$this->db->insert('Wiki', $sql);
		
			if($this->db->affected_rows() != 1) 
				die("Wiki_model:__construct(): Error saving wiki $this->wiki_id.");
		}
   	}
   	
   	function id(){return $this->wiki_id;}
   	
   	function connection(){return $this->wiki_connection;}
   	
   	function fetch_general_stats(){
   		return $this->connection()->get_query("SELECT ss_total_views, ss_total_edits, ss_good_articles, ss_total_pages, ss_users, ss_active_users, ss_admins, ss_images FROM site_stats LIMIT 1");
   	}
   	
   	function fetch_linked_categories($date_range_a => 'default', $date_range_b => 'default'){
   		if($date_range_a == 'default'){
   			$initial_date = $this->connection()->get_query("SELECT rev_timestamp FROM revision ORDER BY rev_timestamp ASC LIMIT 1");
   			if($initial_date->num_rows() != 0)
   				foreach ($initial_date as $row)
   					$date_range_a = $row -> rev_timestamp;
   			else
   				return false;
   		}
   		
   		if($date_range_b == 'default')
   			$date_range_b = date('Y-m-d H:i:s', now());
   		
   		$result = $this->connection()->get_query("SELECT cl_from, cl_to FROM scategorylinks WHERE cl_from IN (SELECT DISTINCT rev_page FROM revision WHERE rev_timestamp>=$date_range_a and rev_timestamp<=$date_range_b)");
   		
   		$counter = 0;
   		foreach ($result as $row){
   			$array[$row->cl_from] = $row->cl_to;
   			$counter++;
   		}
   		
   		return $array; //$[page id] = category name
   	}
   	
   	function fetch_all_categories($date_range_a => 'default', $date_range_b => 'default'){
   		if($date_range_a == 'default'){
   			$initial_date = $this->connection()->get_query("SELECT rev_timestamp FROM revision ORDER BY rev_timestamp ASC LIMIT 1");
   			if($initial_date->num_rows() != 0)
   				foreach ($initial_date as $row)
   					$date_range_a = $row -> rev_timestamp;
   			else
   				return false;
   		}
   		
   		if($date_range_b == 'default')
   			$date_range_b = date('Y-m-d H:i:s', now());
   		
   		$result = $this->connection()->get_query("SELECT page_title FROM page WHERE page_namespace=14 AND page_id IN (SELECT DISTINCT rev_page FROM revision WHERE rev_timestamp>=$date_range_a and rev_timestamp<=$date_range_b)");
   		
   		$counter = 0;
   		foreach ($result as $row){
   			$array[$counter] = $row->page_title;
   			$counter++;
   		}
   		
   		return $array; //$[index] = page title
   	}
   	
   	function delete_wiki(){
   		$check = $this->db->query("select * from Wiki where wiki_id == $this->wiki_id");
   		if($check->result()->num_rows() == 0)
   			die("delete_wiki(): Wiki $this->wiki_id doesn't exist.");
   		else
   		 	$this->db->delete('Wiki', array('wiki_id' => $this->wiki_id));
   	}
}

?> 
