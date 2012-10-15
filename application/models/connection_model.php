<?php

//AVAILABLE METHODS
// 	new_connection($server, $name, $user, $password)
//    	connect($id)
//    	get_query($link, $query_string)
//    	delete_connection($id)
   	
class Connection_model extends CI_Model{
	
	//constructor
   	function Connection_model(){
   	   	parent::__construct();
   	}
   	
   	function new_connection($server, $name, $user, $password){
   	   	$check = $this->db->query("select * from connection where connection_server == $server and connection_name == $name and connection_user == $user");
   		if($check->result()->num_rows() != 0)
   			return "new_connection(): ERR_ALREADY_EXISTS";
   		else{
   			$sql = array('connection_id' => "",
   				'connection_name' => "$name",
   				'connection_server' => "$server",
   				'connection_user' => "$user",
   				'connection_password' => "$password"
   			);
					$this->db->insert('Connection', $sql);
	
			if($this->db->affected_rows() != 1) 
				return "new_connection(): ERR_AFFECTED_ROWS (".$this->db->affected_rows().")";
			else 
				return  $this->db->insert_id();
		}
	}
	
	function connect($id){
		$query = $this->db->query("select * from connection where connection_id == $id");
   		if($query->result()->num_rows() == 0)
   			return "connect(): ERR_NONEXISTENT";
   		else{
   			$result = $query->result();
   			foreach($result as $row){
   				$dba['hostname'] = $row->connection_server;
				$dba['username'] = $row->connection_user;
				$dba['password'] = $row->connection_password;
				$dba['database'] = $row->connection_name;
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
			
   				return $this->load->database($dba, TRUE);
   			}
   				
		}
	}
   	
   	function get_query($link, $query_string){
   		$query = $link->query($query_string);
   		return $query->result();
   	}
   	
   	function make_insert($link, $table, $insert_array){
   		$link->insert_string($table, $insert_array);
   	}
   	
   	function delete_connection($id){
   		$check = $this->db->query("select * from connection where connection_id == $id");
   		if($check->result()->num_rows() == 0)
   			return "delete_connection(): ERR_NONEXISTENT";
   		else
   		 	$this->db->delete('connection', array('connection_id' => $id)); 
   		 	if($this->db->affected_rows() != 1) 
				return "delete_connection(): ERR_AFFECTED_ROWS (".$this->db->affected_rows().")";
			else 
				return  true;
   	}
}

?>