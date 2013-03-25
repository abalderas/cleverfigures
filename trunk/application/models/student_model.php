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


//AVAILABLE METHODS


class Student_model extends CI_Model{
	
   	function Student_model(){
   		//Llamamos al constructor heredado.
   	   	parent::__construct();
   	   	$this->load->database();
   	   	
   	   	$ci =& get_instance();
		$ci->load->model('connection_model');
   	   	$cl =& get_instance();
		$cl->load->model('wiki_model');
   	}
   	
   	function login($uname, $pass){
		$wikis = $this->db->query("select wiki_name from wiki")->result();
		
		$studentwikis = array();
		
		if($wikis)
			foreach($wikis as $row){
				$link = $this->connection_model->connect($this->wiki_model->wconnection($row->wiki_name));
				if(!$link) 
					die("student_login::Invalid database connection.");
				
				$link -> from("user") 
				-> where("user_name = '$uname'") 
				-> where("user_password = '".MD5($pass)."'");
	
				$query = $link -> get();
	
				if($query->result())
					$studentwikis[] = $wiki;
			}
		else
			return false;
		
		if(empty($studentwikis))
			return false;
		else{
			$sess_array = array('username' => $row -> user_name,
						'language' => $this->config->item('language'),
        					'is_student' => true
        				); 
        				
        		$this->session->set_userdata($sess_array);
			
			return true;
		}
   	}
   	
   	function get_analysis_list($studentname){
		$result = $this->db->query("select * from `student-analysis` where student_name = '$studentname' order by analysis_date desc")->result();
		
		if($result){
			foreach($result as $row){
				$alist[] = $row->analisis_date;
			}
			
			return $alist;
		}
		else
			return array();
		
   	}
}