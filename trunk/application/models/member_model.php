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


class Member_model extends CI_Model{

	//METHODS
	//constructor
   	function Member_model(){
   	   	parent::__construct();
   	   	$this->load->database();
   	}
   	
   	function get_group($membername){
		$check = $this->db->get_where('member', array('member_name' => $membername));
		
		if($check)
			foreach($check as $row)
				return $row->member_group;
		else
			return false;
   	}
   	
   	function join_group($groupname, $membername){
		$check = $this->db->get_where('group', array('group_name' => $groupname));
   		if(!$check)
   			return false;
   		else{
			$sql = array('member_name' => $membername,
   					'member_group' => $groupname
   				);
	
			$this->db->insert('member', $sql);
   		 	return true;
   		}
   	}
}
