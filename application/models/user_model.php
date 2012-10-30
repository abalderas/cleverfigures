<?php


class User_model extends CI_Model{

	//METHODS
	//constructor
   	function User_model(){
   	   	parent::__construct();
   	}
   	
   	//writing methods
   	function new_user($uname, $pass, $date, $rname, $mail){
   		$check = $this->db->query("select * from user where user_username = '$uname'");
   		if($check->result())
   			return "new_user(): ERR_ALREADY_EXISTS";
   		else{
   			$sql = array('user_username' => $uname,
   					'user_password' => MD5($pass),
   					'user_last_session' => $date,
   					'user_realname' => $rname,
   					'user_email' => $mail,
   					'user_language' => $this->config->item('language')
   				);
	
			$this->db->insert('user', $sql);
		}
   	}
   	
   	function update_last_session($uname){
   		$data = array('user_last_session' => now());
		$this->db->where('user_username', $uname);
		$this->db->update('user', $data); 
   	}
   	
   	function update_language($uname, $lang){
   		$data = array('user_language' => $lang);
		$this->db->where('user_username', $uname);
		$this->db->update('user', $data); 
   	}
   	
   	function relate_wiki($wikiname){
   		$query = $this->db->query("select * from wiki where wiki_name == $wikiname");
   		if($query->result()->num_rows() != 0){
   			$sql = array('user_username' => $this->session->userdata('user_username'),
   					'wiki_name' => "$wikiname"
   				);
	
			$this->db->insert('user-wiki', $sql);
		
			if($this->db->affected_rows() != 1) 
				return "relate_wiki(): ERR_AFFECTED_ROWS";
			else return TRUE;
		}
   		else
   			return "relate_wiki(): ERR_ALREADY_EXISTS";
   	}
   	
   	function relate_color($colorname){
   		$query = $this->db->query("select * from color where color_name == $colorname");
   		if($query->result()->num_rows() != 0){
   			$sql = array('user_username' => $this->session->userdata('user_username'),
   					'color_name' => "$colorname"
   				);
	
			$this->db->insert('user-color', $sql);
		
			if($this->db->affected_rows() != 1) 
				return "relate_color(): ERR_AFFECTED_ROWS";
			else return TRUE;
		}
   		else
   			return "relate_color(): ERR_ALREADY_EXISTS";
   	}
   	
   	function relate_analisis($analisis){
   		$query = $this->db->query("select * from analisis where analisis_id == $analisis");
   		if($query->result()->num_rows() != 0){
   			$sql = array('user_username' => "$this->user_username",
   					'analisis_id' => "$analisis",
   				);
	
			$this->db->insert('user-analisis', $sql);
		
			if($this->db->affected_rows() != 1) 
				return "relate_analisis(): ERR_AFFECTED_ROWS";
			else return TRUE;
		}
   		else
   			return "relate_analisis(): ERR_ALREADY_EXISTS";
   	}
   	
   	//login methods
   	function login($uname, $pass){
   		$this -> db -> from('user') 
      		  -> where('user_username = ' . "'" . $uname . "'") 
      		  -> where('user_password = ' . "'" . MD5($pass) . "'") 
      		  -> limit(1);
   
      		$query = $this -> db -> get();
       
      		if($query->result()){
      			foreach($query->result() as $row) 
        			$sess_array = array('user_username' => $row -> user_username,
        						'user_language' => $row -> user_language,
        						'user_realname' => $row -> user_realname); 
            		$this -> session -> set_userdata('logged_in', $sess_array);
            		$this->update_last_session($uname);
            		return true;
      		}
      		else
         		return false;
   	}
   	
   	//save & delete methods
   	
   	function delete_user(){
   		$check = $this->db->get_where('user', array('user_username' => $this->session->userdata('user_username')));
   		if(!$check)
   			return "delete(): ERR_NONEXISTENT";
   		else
   		 	$this->db->delete('user', array('user_username' => $this->session->userdata('user_username')));
   		 	
   		 	$this->session->sess_destroy();
   		 	return true;
   	}
}

?>  
