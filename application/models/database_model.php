<?php

//AVAILABLE METHODS
// 	name()
//    	server()
//    	user()
//    	password()
//    	type()
//    	set_connection_data($server, $name, $user, $password, $type)
//    	connect()
//    	get_query($query_string)
//    	load_database_connection_data($name, $server)
//    	save_database_connection_data()
//    	delete_database()
   	
   	
class Databases_model extends CI_Model{
	
	//ATTRIBUTES
	private $database_name;
	private $database_server;
	private $database_user;
	private $database_password;
	private $database_type;
	private $database_complete;
	private $database_link;
	
	//METHODS
	//constructor
   	function Database_model(){
   	   	parent::__construct();
   	   	
		$database_server = 'default';
   	   	$database_name = 'default';
		$database_user = 'default';
		$database_password = 'default';
		$database_type = 'default';
		$database_complete = FALSE;
		$database_link = 0;
   	}
   	
   	//reading methods
   	function name(){return $this->database_name;}
   	function server(){return $this->database_server;}
   	function user(){return $this->database_user;}
   	function password(){return $this->database_password;}
   	function type(){return $this->database_type;}
   	
   	//writing methods
   	function set_connection_data($server, $name, $user, $password, $type){
   		$this->database_server=$server;
   		$this->database_name=$name;
   		$this->database_user$user;
   		$this->database_user$password;
   		$this->database_type=$type;
   		$this->database_complete=TRUE;
   	}
   	
   	//connection methods
   	function connect(){
   		if($this->database_complete){
   			$dba['hostname'] = $this->database_server;
			$dba['username'] = $this->database_user;
			$dba['password'] = $this->database_password;
			$dba['database'] = $this->database_name;
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
			
   			$this->database_link = $this->load->database($dba, TRUE);
   		}
   		else 
   			die("connect(): Impossible to connect database $this->database_name in $this->database_server. Database connection data not set.");
   	}
   	
   	function get_query($query_string){
   		if($this->database_link != 0){
   			$query = $this->database_link->query($query_string);
   			return $query->result();
   		}
   		else
   			return FALSE;
   	}
   	
   	//loading, adding and deleting databases methods
   	function load_database_connection_data($name, $server){
   		$query = $this->db->query("select * from Database where database_name == $name and database_server == $server");
   		if($query->result()->num_rows() != 0)
   			foreach ($query->result() as $row)
   				$this->set_connection_data($row->database_server, $row->database_name, $row->database_user, $row->database_password, $row->database_type);
   		else
   			die("load_database_connection_data(): Database $name from server $server not found.");
   	}
   	
   	function save_database_connection_data(){
   		$check = $this->db->query("select * from Database where database_name == $this->database_name and database_server == $this->database_server");
   		if($check->result()->num_rows() != 0)
   			die("save_database_connection_data(): Database $this->database_name from server $this->database_server already exists.");
   		else{
   			$sql = array('database_name' => "$this->database_name",
   					'database_server' => "$this->database_server",
   					'database_user' => "$this->database_user",
   					'database_password' => "$this->database_password",
   					'database_type' => $this->"database_type"
   				);
	
			$this->db->insert('Database', $sql);
		
			if($this->db->affected_rows() != 1) 
				die("save_database_connection_data(): Error saving database $this->database_name from server $this->database_server.");
			else return TRUE;
		}
   	}
   	
   	function delete_database(){
   		$check = $this->db->query("select * from Database where database_name == $this->database_name and database_server == $this->database_server");
   		if($check->result()->num_rows() == 0)
   			die("delete_database(): Database $this->database_name from server $this->database_server doesn't exist.");
   		else
   		 	$this->db->delete('Database', array('database_name' => $this->database_name, 'database_server' => $this->database_server)); 
   		 	return TRUE;
   	}
}

?>