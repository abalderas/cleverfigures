<?php

//AVAILABLE METHODS
// 	name()
//    	server()
//    	user()
//    	password()
//    	set_connection_data($server, $name, $user, $password)
//    	connect()
//    	get_query($query_string)
//    	load_connection_data($name, $server)
//    	save_connection()
//    	delete_connection()
   	
   	
class Connection_model extends CI_Model{
	
	//ATTRIBUTES
   	private $connection_id;
	private $connection_name;
	private $connection_server;
	private $connection_user;
	private $connection_password;
	private $connection_complete;
	private $connection_link;
	
	//METHODS
	//constructor
   	function Connection_model(){
   	   	parent::__construct();
   	   	
   	   	$connection_id = 'default';
		$connection_server = 'localhost';
   	   	$connection_name = 'default';
		$connection_user = 'root';
		$connection_password = '';
		$connection_complete = FALSE;
		$connection_link = 0;
   	}
   	
   	//reading methods
   	function id(){return $this->connection_id;}
   	function name(){return $this->connection_name;}
   	function server(){return $this->connection_server;}
   	function user(){return $this->connection_user;}
   	function password(){return $this->connection_password;}
   	function clink(){return $this->connection_link;}
   	
   	//writing methods
   	function set_connection_data($id, $server, $name, $user, $password){
   		$this->connection_id=$id;
   		$this->connection_server=$server;
   		$this->connection_name=$name;
   		$this->connection_user=$user;
   		$this->connection_user=$password;
   		$this->connection_complete=TRUE;
   	}
   	
   	//connection methods
   	function connect(){
   		if($this->connection_complete){
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
   		else 
   			die("connect(): Impossible to connect connection $this->connection_id. Connection data not set.");
   	}
   	
   	function get_query($query_string){
   		if($this->connection_link != 0){
   			$query = $this->connection_link->query($query_string);
   			return $query->result();
   		}
   		else
   			return FALSE;
   	}
   	
   	//loading, adding and deleting connections methods
   	function load_connection_data($id){
   		$query = $this->db->query("select * from Database where connection_id == $id");
   		if($query->result()->num_rows() != 0)
   			foreach ($query->result() as $row)
   				$this->set_connection_data($row->connection_id, $row->connection_server, $row->connection_name, 
   								$row->connection_user, $row->connection_password);
   		else
   			die("load_connection_data(): Connection $id not found.");
   	}
   	
   	function save_connection(){
   		$check = $this->db->query("select * from Database where connection_id == $this->connection_id");
   		if($check->result()->num_rows() != 0)
   			die("save_connection(): Connection $this->connection_id already exists.");
   		else{
   			$sql = array('connection_id' => "$this->connection_id",
   					'connection_name' => "$this->connection_name",
   					'connection_server' => "$this->connection_server",
   					'connection_user' => "$this->connection_user",
   					'connection_password' => "$this->connection_password"
   				);
	
			$this->db->insert('Database', $sql);
		
			if($this->db->affected_rows() != 1) 
				die("save_connection(): Error saving connection $this->id.");
			else return TRUE;
		}
   	}
   	
   	function delete_connection(){
   		$check = $this->db->query("select * from Database where connection_id == $this->connection_id");
   		if($check->result()->num_rows() == 0)
   			die("delete_connection(): Connection $this->connection_id doesn't exist.");
   		else
   		 	$this->db->delete('Database', array('connection_id' => $this->connection_name)); 
   		 	return TRUE;
   	}
}

?>