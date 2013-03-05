<?php

// <<Copyright 2013 Alvaro Almagro Doello>>
// 
// This file is part of CleverFigures.
// 
// CleverFigures is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// CleverFigures is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with CleverFigures.  If not, see <http://www.gnu.org/licenses/>.


class User_model extends CI_Model{

	//METHODS
	//constructor
   	function User_model(){
   	   	parent::__construct();
   	   	$this->load->database();
   	}
   	
   	//writing methods
   	function new_user($uname, $pass, $date, $rname, $mail, $is_admin){
   		$check = $this->db->query("select * from user where user_username = '$uname'");
   		if($check->result())
   			return "new_user(): ERR_ALREADY_EXISTS";
   		else{
   			$sql = array('user_username' => $uname,
   					'user_password' => MD5($pass),
   					'user_last_session' => $date,
   					'user_realname' => $rname,
   					'user_email' => $mail,
   					'user_language' => $this->config->item('language'),
   					'user_is_admin' => $is_admin,
   					'user_high_contrast' => false
   				);
	
			$this->db->insert('user', $sql);
		}
   	}
   	
//    	function default_language(){}
   	
   	function is_admin($uname){
		$result = $this->db->query("select user_is_admin from `user-analisis` where user_username = '$uname'")->result();
		
		if($result)
			foreach($result as $row)
				return $row->user_is_admin;
		else
			return false;
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
   	
   	function update_password($uname, $password){
   		$data = array('user_password' => $lang);
		$this->db->where('user_username', $uname);
		$this->db->update('user', $data); 
   	}
   	
   	function get_wiki_list($username = 'default'){
		//Consultamos la conexión
   		$query = $this->db->query("select * from wiki, `user-wiki` where wiki.wiki_name = `user-wiki`.wiki_name and `user-wiki`.user_username = '$username'");
   		if(!$query->result())
   			return array();
   		else
   			foreach($query->result() as $row)
   				$wikis[$row->wiki_name] = $row->wiki_name;
   		
   		return $wikis;
   	}
   	
   	function get_analisis_list($uname){
		$result = $this->db->query("select * from `user-analisis` where user_username = '$uname' order by analisis_date desc")->result();
		
		if($result){
			foreach($result as $row){
				$alist[] = $row->analisis_date;
			}
			
			return $alist;
		}
		else
			return array();
		
   	}
   	
   	function relate_wiki($wikiname){
   		$query = $this->db->query("select * from wiki where wiki_name = '$wikiname'");
   		if($query->result()){
   			$sql = array('user_username' => $this->session->userdata('username'),
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
   		$query = $this->db->query("select * from color where color_name = '$colorname'");
   		if($query->result()){
   			$sql = array('user_username' => $this->session->userdata('username'),
   					'color_name' => "$colorname"
   				);
	
			$this->db->insert('user-color', $sql);
		
			if($this->db->affected_rows() != 1) 
				return "relate_color(): ERR_AFFECTED_ROWS";
			else return TRUE;
		}
   		else
   			die( "relate_color(): ERR_ALREADY_EXISTS");
   	}
   	
   	function relate_analisis($analisis){
   		$query = $this->db->query("select * from analisis where analisis_date = '$analisis'");
   		if($query->result()){
   			$sql = array('user_username' => $this->session->userdata('username'),
   					'analisis_date' => $analisis
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
        			$sess_array = array('username' => $row -> user_username,
        						'language' => $row -> user_language,
        						'is_admin' => $row -> user_is_admin,
        						'high_contrast' => $row -> user_high_contrast,
        						'realname' => $row -> user_realname); 
            		$this -> session -> set_userdata($sess_array);
            		$this -> update_last_session($uname);
            		return true;
      		}
      		else
         		return false;
   	}
   	
   	//email
   	function search_mail_user($mail){
   		$query = $this -> db -> query("select user_username, user_password from user where user_email = '$mail'");
       
      		if($query->result())
      			foreach($query->result() as $row)
				return $row->user_username;
      		return false;
   	}
   	
   	function delete_user(){
   		$check = $this->db->get_where('user', array('user_username' => $this->session->userdata('username')));
   		if(!$check)
   			return "delete(): ERR_NONEXISTENT";
   		else
   		 	$this->db->delete('user', array('user_username' => $this->session->userdata('username')));
   		 	
   		 	$this->session->sess_destroy();
   		 	return true;
   	}
}
