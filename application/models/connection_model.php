<?php

//AVAILABLE METHODS
// 	name()
//    	server()
//    	user()
//    	password()
//    	get_query($query_string)
//    	delete_connection()
   	
   	
class Connection_model extends CI_Model{
	
	//ATTRIBUTES
   	private $connection_id;
	private $connection_name;
	private $connection_server;
	private $connection_user;
	private $connection_password;
	private $connection_link;
	
	//METHODS
	//constructor
   	function Connection_model($id, $server => 'default', $name => 'default', $user => 'default', $password => 'default'){
   	   	parent::__construct();
   	   	
   	   	if($server == 'default' && $name == 'default' && $user == 'default' && $password == 'default'){
   			$query = $this->db->query("select * from Connection where connection_id == $id");
   			if($query->result()->num_rows() != 0)
   				foreach ($query->result() as $row){
   					$this->connection_id = $row -> connection_id;
   					$this->connection_server = $row -> connection_server;
   					$this->connection_name = $row -> connection_name;
   					$this->connection_user = $row -> connection_user;
   					$this->connection_password = $row -> connection_password;
   				}
   			else
   				die("Connection_model:__construct(): Connection $id not found.");
   	   	}
   	   	else{
   	   		$this->connection_id = $id;
			$this->connection_server = $server;
   	   		$this->connection_name = $name;
			$this->connection_user = $user;
			$this->connection_password = $password;
			
			$check = $this->db->query("select * from Connection where connection_id == $this->connection_id");
   			if($check->result()->num_rows() != 0)
   				die("Connection_model:__construct(): Connection $this->connection_id already exists.");
   			else{
   				$sql = array('connection_id' => "$this->connection_id",
   					'connection_name' => "$this->connection_name",
   					'connection_server' => "$this->connection_server",
   					'connection_user' => "$this->connection_user",
   					'connection_password' => "$this->connection_password"
   				);
	
				$this->db->insert('Connection', $sql);
		
				if($this->db->affected_rows() != 1) 
					die("Connection_model:__construct(): Error saving connection $this->connection_id.");
				else return TRUE;
			}
   	   	}
		
		$dba['hostname'] = $this->connection_server;
		$dba['username'] = $this->connection_user;
		$dba['password'] = $this->connection_password;
		$dba['database'] = $this->connection_name;
		$dba['dbdriver'] = 'mysql';
		$dba['dbprefix'] = '';
		$dba['pconnect'] = FALSE;
		$dba['db_debug'] = TRUE;
		$dba['cache_on'] = FALSE;
		$dba['cachedir'] = '';
		$dba['char_set'] = 'utf8';
		$dba['dbcollat'] = 'utf8_general_ci';
		$dba['swap_pre'] = '';
		$dba['autoinit'] = TRUE;
		$dba['stricton'] = FALSE;
			
   		$this->connection_link = $this->load->database($dba, TRUE);
   	}
   	
   	function id(){return $this->connection_id;}
   	
   	function name(){return $this->connection_name;}
   	
   	function server(){return $this->connection_server;}
   	
   	function user(){return $this->connection_user;}
   	
   	function password(){return $this->connection_password;}
   	
   	function clink(){return $this->connection_link;}
   	
   	function get_query($query_string){
   		$query = $this->connection_link->query($query_string);
   		return $query->result();
   	}
   	
   	function delete_connection(){
   		$check = $this->db->query("select * from Connection where connection_id == $this->connection_id");
   		if($check->result()->num_rows() == 0)
   			die("delete_connection(): Connection $this->connection_id doesn't exist.");
   		else
   		 	$this->db->delete('Connection', array('connection_id' => $this->connection_name)); 
   		 	return TRUE;
   	}
}

?>