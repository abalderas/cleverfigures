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
   	
   	private function wconnection($name){
   		$query = $this->db->query("select wiki_connection from wiki where wiki_name == $name");
   		if($check->result()->num_rows() == 0)
   			return "connection(): ERR_NONEXISTENT";
   		else
   			foreach($check->result() as $row)
   				return $row->wiki_connection;
   	}
   	
   	function new_wiki($name, $db_server, $db_name, $db_user, $db_password){
   		$my_con = $this->connection_model->new_connection($db_server, $db_name, $db_user, $db_password);
   		if(gettype($my_con) != "integer")
   			return "new_wiki(): $my_con";
   			
   		$check = $this->db->query("select * from wiki where wiki_name == $name");
   		if($check->result()->num_rows() != 0)
   			return "new_wiki(): ERR_ALREADY_EXISTS";
   		else{
   			$sql = array('wiki_id' => "",
   				'wiki_name' => "$name",
   				'wiki_connection' => "$my_con"
   				);
			$this->db->insert('wiki', $sql);
		
			if($this->db->affected_rows() != 1) 
				return "new_wiki(): ERR_AFFECTED_ROWS (".$this->db->affected_rows().")";
			else
				return  $this->db->insert_id();
		}
   	}
   	
   	function fetch_general_stats($name){
   		$link = $this->connection_model->connect($this->wconnection($name));
   		$result = $this->connection_model->get_query($link, "SELECT * FROM site_stats");
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
	
			$this->db->insert('wgeneral', $sql);
		
			if($this->db->affected_rows() != 1) 
				return "fetch_general_stats(): ERR_AFFECTED_ROWS (".$this->db->affected_rows().")";
			else 
				return $this->db->insert_id();
   		}
   	}
   	
   	function fetch_category_links($name, $date_range_a => 'default', $date_range_b => 'default'){ //PENDIENTE AÑADIR FILTROS!!!
   		$link = $this->connection_model->connect($this->wconnection($name));
   		
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
   		
   		$result = $this->connection_model->get_query($link, "SELECT cl_from, cl_to FROM categorylinks WHERE cl_from IN (SELECT DISTINCT rev_page FROM revision WHERE rev_timestamp >= $date_range_a and rev_timestamp <= $date_range_b)");
   		
   		$data = array();
   		foreach ($result as $row){
   			$data['wp_id'] = $row->cl_from,
   			$data['wc_title'] = $row->cl_to;
   			
   			$this->connection_model->make_insert($link, 'wpage-wcategory', $data);
   		}
   		
   		return true;
   	}
   	
   	function fetch_categories($name, $date_range_a => 'default', $date_range_b => 'default'){ //PENDIENTE AÑADIR FILTROS!!!
   		$link = $this->connection_model->connect($this->wconnection($name));
   		
   		if($date_range_a == 'default'){
   			$initial_date = $this->connection_model->get_query($link, "SELECT rev_timestamp FROM revision ORDER BY rev_timestamp ASC LIMIT 1");
   			if($initial_date->num_rows() != 0)
   				foreach ($initial_date as $row)
   					$date_range_a = $row -> rev_timestamp;
   			else
   				return "fetch_all_categories(): ERR_NONEXISTENT";
   		}
   		
   		if($date_range_b == 'default')
   			$date_range_b = date('Y-m-d H:i:s', now());
   		
   		$result = $this->connection_model->get_query($link, "SELECT cat_title, cat_pages, cat_subcats FROM page, category WHERE page_title == cat_title AND page_namespace=14 AND page_id IN (SELECT DISTINCT rev_page FROM revision WHERE rev_timestamp>=$date_range_a and rev_timestamp<=$date_range_b)");
   		
   		$data = array();
   		foreach ($result as $row){
   			$data['wc_id'] = '',
   			$data['wc_title'] = $row->cat_title,
   			$data['wc_pages'] = $row->cat_pages,
   			$data['wc_subcats'] = $row->cat_subcats;
   			
   			$this->connection_model->make_insert($link, 'wcategory', $data);
   		}
   		
   		return true;
   	}
   	
   	function fetch_images($name, $date_range_a => 'default', $date_range_b => 'default'){ //PENDIENTE AÑADIR FILTROS!!!
   		$link = $this->connection_model->connect($this->wconnection($name));
   		
   		if($date_range_a == 'default'){
   			$initial_date = $this->connection_model->get_query($link, "SELECT rev_timestamp FROM revision ORDER BY rev_timestamp ASC LIMIT 1");
   			if($initial_date->num_rows() != 0)
   				foreach ($initial_date as $row)
   					$date_range_a = $row -> rev_timestamp;
   			else
   				return "fetch_images(): ERR_NONEXISTENT";
   		}
   		
   		if($date_range_b == 'default')
   			$date_range_b = date('Y-m-d H:i:s', now());
   		
   		$result = $this->connection_model->get_query($link, "SELECT img_name, img_user, img_user_text, img_timestamp, img_size FROM image WHERE img_timestamp >= $date_range_a AND img_timestamp <= $date_range_b");
   		
   		$data = array();
   		foreach ($result as $row){
   			$data['wc_id'] = '',
   			$data['wi_name'] = $row->img_name,
   			$data['wi_user'] = $row->img_user,
   			$data['wi_user_text'] = $row->img_user_text,
   			$data['wi_timestamp'] = $row->img_timestamp,
   			$data['wi_size'] = $row->img_size;
   			
   			$this->connection_model->make_insert($link, 'wimage', $data);
   		}
   		
   		return true;
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
