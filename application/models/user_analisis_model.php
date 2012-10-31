<?php

class User_analisis_model extends CI_Model{

	//METHODS
   	function User_analisis_model(){
   	   	parent::__construct();
   	}
   	
   	function get_analisis_list($user){
		$data = $this->db->get_where('user-analisis', array('user_username' => $user));
		if(!$data->result())
			return false;
		
		return $data->result();
   	}
}

?> 
