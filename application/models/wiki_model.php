<?php

//AVAILABLE METHODS
//	Wiki_model()
// 	name()
//    	connection()
//    	fetch()
//    	delete_wiki()

//LOADED MODELS
$ci =& get_instance();
$ci->load->model('connection_model');


class Wiki_model extends CI_Model{
	
	//ATTRIBUTES
	private $wiki_id;
	private $wiki_connection;
	private $wiki_link;
	
	//METHODS
	//constructor
   	function Wiki_model($id, $connection){
   	   	parent::__construct();
   	   	
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
   	
   	function fetch(){
   		//todo
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
