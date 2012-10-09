<?php

//METHODS
// 	Users_model()
//    	username()
//    	password()
//    	last_session()
//    	realname()
//    	email()
//    	active_wiki()
//    	active_color()
//    	language()
//    	set_user_data($id, $name, $pass, $email_address, $user_wiki, $user_color, $lang)
//    	update_last_session()
//    	update_language($lang)
//    	update_wiki($wiki)
//    	update_color($color)
//    	login()
//    	save_user()
//    	delete_user()


class User_model extends CI_Model{

	//ATTIRBUTES
	private $user_username;
	private $user_password;
	private $user_last_session;
	private $user_realname;
	private $user_email;
	private $user_active_wiki;
	private $user_active_color;
	private $user_language;
	
	//METHODS
	//constructor
   	function Users_model(){
   	   	parent::__construct();
   	   	$this->load->helper('date');
   	   	
   	   	$user_username = 'default';
   	   	$user_password = 'default';
		$user_last_session = 0;
		$user_realname = 'default';
		$user_email = 'default';
		$user_active_wiki = 'default';
		$user_active_color = 'default';
		$user_language = 'default';
   	}
   	
   	//reading methods
   	function username(){return $this->user_username;}
   	function password(){return $this->user_password;}
   	function last_session(){return $this->user_last_session;}
   	function realname(){return $this->user_realname;}
   	function email(){return $this->user_email;}
   	function active_wiki(){return $this->user_active_wiki;}
   	function active_color(){return $this->user_active_color;}
   	function language(){return $this->user_language;}
   	function language(){return $this->user_databases;}
   	
   	//writing methods
   	function set_user_data($id, $name, $pass, $email_address, $user_wiki, $user_color, $lang, $dbs){
   		$this->user_username = $id;
   		$this->user_password = $pass;
   		$this->user_last_session = now();
   		$this->user_realname = $name;
   		$this->user_email = $email_address;
   		$this->user_active_wiki = $user_wiki;
   		$this->user_active_color = $user_color;
   		$this->user_language = $lang;
   		$this->user_databases = $dbs;
   	}
   	
   	function update_last_session(){
   		$data = array('user_last_session' => now());
		$this->db->where('user_username', $this->user_username);
		$this->db->update('User', $data); 
   	}
   	
   	function update_language($lang){
   		$data = array('user_language' => $lang);
		$this->db->where('user_username', $this->user_username);
		$this->db->update('User', $data); 
   	}
   	
   	function update_wiki($wiki){
   		$data = array('user_active_wiki' => $wiki);
		$this->db->where('user_username', $this->user_username);
		$this->db->update('User', $data); 
   	}
   	
   	function update_color($color){
   		$data = array('user_active_color' => $color);
		$this->db->where('user_username', $this->user_username);
		$this->db->update('User', $data); 
   	}
   	
   	function add_database($dbserver, $dbname){
   		$query = $this->db->query("select * from Database where database_name == $dbname and database_server == $dbserver");
   		if($query->result()->num_rows() != 0){
   			$sql = array('user_username' => "$this->user_username",
   					'database_name' => "$dbname",
   					'database_server' => "$dbserver"
   				);
	
			$this->db->insert('User-Database', $sql);
		
			if($this->db->affected_rows() != 1) 
				die("add_database($dbserver, $dbname): Error relating database $dbname from server $dbserver to user $this->user_username.");
			else return TRUE;
		}
   		else
   			die("add_database($dbserver, $dbname): Database $dbname from server $dbserver not found.");
   	}
   	
   	function add_analisis($a_id){
   		$query = $this->db->query("select * from Analisis where analisis_id == $a_id");
   		if($query->result()->num_rows() != 0){
   			$sql = array('user_username' => "$this->user_username",
   					'analisis_id' => "$a_id",
   				);
	
			$this->db->insert('User-Analisis', $sql);
		
			if($this->db->affected_rows() != 1) 
				die("add_analisis($a_id): Error relating analisis $a_id to user $this->user_username.");
			else return TRUE;
		}
   		else
   			die("add_analisis($a_id): Analisis $a_id not found.");
   	}
   	
   	//login methods
   	function login(){
   		$this -> db -> select('user_username') 
      		  -> from('User') 
      		  -> where('user_username = ' . "'" . $this->user_username . "'") 
      		  -> where('user_password = ' . "'" . $this->user_password . "'") 
      		  -> limit(1);
   
      		$this->db->flush_cache();
      		$query = $this -> db -> get();
       
      		if($query -> num_rows() == 1){
      			foreach($query->result() as $row) 
        			$sess_array = array('user_username' => $row -> user_username,
        						'user_language' => $row->user_language); 
            		$this -> session -> set_userdata('logged_in', $sess_array);
            		return true;
      		}
      		else
         		return false;
   	}
   	
   	//save & delete methods
   	function save_user(){
   		$check = $this->db->query("select * from User where user_username == $this->user_username");
   		if($check->result()->num_rows() != 0)
   			return false;
   		else{
   			$sql = array('user_username' => "$this->user_username",
   					'user_password' => "$this->user_password",
   					'user_last_session' => "$this->user_last_session",
   					'user_realname' => "$this->user_realname",
   					'user_email' => "$this->user_email",
   					'user_configuration' => "$this->user_configuration"
   				);
	
			$this->db->insert('User', $sql);
		
			if($this->db->affected_rows() != 1) 
				return false;
			else 
				return true;
		}
   	}
   	
   	function delete_user(){
   		$check = $this->db->query("select * from User where user_username == $this->user_username");
   		if($check->result()->num_rows() == 0)
   			return false;
   		else
   		 	$this->db->delete('User', array('user_username' => $this->user_username)); 
   		 	return true;
   	}
}

?>  
