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


class Group_model extends CI_Model{


   	function Group_model(){
   	   	parent::__construct();
   	   	$this->load->database();
   	}
   	
   	function new_group($groupname, $wikiname){
   		$check = $this->db->query("select * from groups where group_name = '$groupname'");
   		if($check->result())
   			return "new_group(): ERR_ALREADY_EXISTS";
   		else{
   			$sql = array('group_name' => $groupname,
   					'wiki_name' => $wikiname
   				);
	
			$this->db->insert('groups', $sql);
		}
   	}
   	
   	function delete_group($groupname){
   		$check = $this->db->get_where('groups', array('group_name' => $groupname));
   		if(!$check)
   			return "delete(): ERR_NONEXISTENT";
   		else{
   		 	$this->db->delete('groups', array('group_name' => $groupname));
   		 	$this->db->delete('member', array('member_group' => $groupname));
   		 	return true;
   		}
   	}
}