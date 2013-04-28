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
   			return false;
   		else{
   			$sql = array('group_name' => $groupname,
   					'wiki_name' => $wikiname
   				);
	
			$this->db->insert('groups', $sql);
		}
		
		return true;
   	}
   	
   	function get_members($groupname){
   		$check = $this->db->query("select member_name from member where member_group = '$groupname'");
   		if(!$check->result())
   			return false;
   		else
   			foreach($check->result() as $row)
				$member[] = $row->member_name;
		
		return $member;
   	}
   	
   	function there_are_groups(){ return ($this->db->query("select * from groups")->result()) ? true : false; }
   	function get_groups($wiki = false){
		if($wiki){
			$check = $this->db->query("select * from groups where wiki_name = '$wiki'");
		}
		else{
			$check = $this->db->query("select * from groups");
		}
		
   		if(!$check->result())
   			return false;
   		else
   			foreach($check->result() as $row)
				$groups[] = $row->group_name;
		
		return $groups;
   	}
   	
   	function get_member_group($member){
		$result = $this->db->query("select * from member where member_name = '$member'")->result();
		
		if(!$result) return 'no group';
   		
   		foreach($result as $row)
			return $row->member_group;
   	}
   	
   	function join_group($groupname, $membername){
		$check = $this->db->get_where('groups', array('group_name' => $groupname));
   		if(!$check)
   			die('Groups error');
   		else{
			$check = $this->db->get_where('member', array('member_name' => $membername));
			if(!$check->result()){
				$sql = array('member_name' => $membername,
						'member_group' => $groupname
					);
	
				$this->db->insert('member', $sql);
			}
			else{
				$sql = array('member_name' => $membername,
						'member_group' => $groupname
					);
	
				$this->db->where('member_name', $membername);
				$this->db->update('member', $sql); 
			}
   		}
   	}
   	
   	function leave_group($membername){
   		$check = $this->db->get_where('member', array('member_name' => $membername));
   		if($check)
   			$this->db->delete('member', array('member_name' => $membername));
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