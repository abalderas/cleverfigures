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
// 	new_wiki()
// 	fetch_categories()
// 	wconnection()
// 	fetch_category_links()
// 	fetch_general_stats()
// 	fetch_images()
// 	fetch_pages()
// 	fetch_users()
// 	delete_wiki()


class Filter_model extends CI_Model{
	
	
   	function Filter_model(){
   		//Llamamos al constructor heredado.
   	   	parent::__construct();
   	   	$this->load->database();
   	}
   	
   	function get_filter_list($username){
		//Consultamos la conexión
   		$query = $this->db->query("select * from filter, `user-filter` where filter.filter_id = `user-filter`.filter_id and `user-filter`.user_username = '$username'");
   		if(!$query->result())
   			return array();
   		else
   			foreach($query->result() as $row)
   				$filters[$row->filter_id] = $row->filter_id;
   		
   		return $filters;
   	}
   	
   	function str_type($type){
		switch($type){
			case 0: return lang('voc.i18n_all');
			case 1: return lang('voc.i18n_user');
			case 2: return lang('voc.i18n_page');
			case 3: return lang('voc.i18n_category');
			default: return false;
		}
	}
   	function new_filter($data){
   		$sql = array('ref' => "",
   			'filter_id' => $data['filterid'],
   			'filter_user' => $data['filterusercheck'],
   			'filter_username' => $data['filteruser'],
   			'filter_page' => $data['filterpagecheck'],
   			'filter_pagename' => $data['filterpage'],
   			'filter_category' => $data['filtercategorycheck'],
   			'filter_categoryname' => $data['filtercategory'],
   			'filter_criteria' => $data['filtercriteriacheck'],
   			'filter_criterianame' => $data['filtercriteria'],
   			'filter_date_a' => $data['datea'],
   			'filter_date_b' => $data['dateb']
   			);
		$this->db->insert('filter', $sql);
		
		//Si no hay error de inserción, devolvemos el id
		if($this->db->affected_rows() != 1) 
			return "new_filter(): ERR_AFFECTED_ROWS (".$this->db->affected_rows().")";
   	}	
   	
   	function user($id){
		$query = $this->db->query("select filter_user, filter_username from filter where filter_id = '$id'");
		foreach($query->result() as $row){
			if($row->filter_user == true)
				return $row->filter_username;
			return false;
		}
   	}
   	
   	function page($id){
		$query = $this->db->query("select filter_page, filter_pagename from filter where filter_id = '$id'");
		foreach($query->result() as $row){
			if($row->filter_page == true)
				return $row->filter_pagename;
			return false;
		}
	}
	
   	function category($id){
		$query = $this->db->query("select filter_category, filter_categoryname from filter where filter_id = '$id'");
		foreach($query->result() as $row){
			if($row->filter_category == true)
				return $row->filter_categoryname;
			return false;
		}
	}
	
   	function criteria($id){
		$query = $this->db->query("select filter_criteria, filter_criterianame from filter where filter_id = '$id'");
		foreach($query->result() as $row){
			if($row->filter_criteria == true)
				return $row->filter_criterianame;
			return false;
		}
   	}
   	
   	function firstdate($id){
		$query = $this->db->query("select filter_date_a from filter where filter_id = '$id'");
		foreach($query->result() as $row){
			return $row->filter_date_a;
		}
   	}
   	
   	function lastdate($id){
		$query = $this->db->query("select filter_date_b from filter where filter_id = '$id'");
		foreach($query->result() as $row){
			return $row->filter_date_b;
		}
   	}
   	
   	function delete_filter($id){
   		//Comprobamos que existe y devuelve error si no
   		$check = $this->db->query("select * from filter where filter_id = '$id'");
   		if(!$check->result())
   			return "delete_filter(): NONEXISTENT";
   		else
   		 	$this->db->delete('filter', array('filter_id' => $id));
   	}
}