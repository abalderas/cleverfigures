<?php


//AVAILABLE METHODS
//	Color_model()
// 	name()
//    	connection()
//    	fetch()
//    	delete_color()

//LOADED MODELS
$ci =& get_instance();
$ci->load->model('connection_model');


class Color_model extends CI_Model{
	
	//ATTRIBUTES
	private $color_id;
	private $color_connection;
	private $color_link;
	
	//METHODS
	//constructor
   	function Color_model($id, $connection){
   	   	parent::__construct();
   	   	
		$this->color_id = $id;
		$this->color_connection = $connection;
		
		$check = $this->db->query("select * from Color where color_id == $this->color_id");
   		if($check->result()->num_rows() != 0)
   			die("Color_model:__construct(): Color $this->color_id already exists.");
   		else{
   			$sql = array('color_id' => "$this->color_id",
   				'color_connection' => "$this->color_connection"
   				);
			$this->db->insert('Color', $sql);
		
			if($this->db->affected_rows() != 1) 
				die("Color_model:__construct(): Error saving color $this->color_id.");
		}
   	}
   	
   	function id(){return $this->color_id;}
   	
   	function connection(){return $this->color_connection;}
   	
   	function fetch(){
   		//todo
   	}
   	
   	function delete_color(){
   		$check = $this->db->query("select * from Color where color_id == $this->color_id");
   		if($check->result()->num_rows() == 0)
   			die("delete_color(): Color $this->color_id doesn't exist.");
   		else
   		 	$this->db->delete('Color', array('color_id' => $this->color_id));
   	}
}

?> 
