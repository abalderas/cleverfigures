<?php
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
   	
   	//writing methods
   	function set_user_data($id, $name, $pass, $email_address, $user_wiki, $user_color, $lang){
   		$this->user_username = $id;
   		$this->user_password = $pass;
   		$this->user_last_session = now();
   		$this->user_realname = $name;
   		$this->user_email = $email_address;
   		$this->user_active_wiki = $user_wiki;
   		$this->user_active_color = $user_color;
   		$this->user_language = $lang;
   	}
   	
   	function save_last_session(){
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
        			$sess_array = array('user_username' => $row -> user_username); 
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
