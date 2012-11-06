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
   				$filters[] = $row->filter_id;
   		
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
   	function new_filter($id, $type, $name, $datea, $dateb){
   		$sql = array('ref' => "",
   			'filter_id' => "$id",
   			'filter_type' => "$type",
   			'filter_name' => "$name",
   			'filter_date_a' => "$datea",
   			'filter_date_b' => "$dateb"
   			);
		$this->db->insert('filter', $sql);
		
		//Si no hay error de inserción, devolvemos el id de la wiki
		if($this->db->affected_rows() != 1) 
			return "new_filter(): ERR_AFFECTED_ROWS (".$this->db->affected_rows().")";
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