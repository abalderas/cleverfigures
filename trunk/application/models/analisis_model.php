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



class Analisis_model extends CI_Model{

	//METHODS
   	function Analisis_model(){
   	   	parent::__construct();
   	   	$this->load->database();
   	   	$this->load->helper('file');
   	   	$co =& get_instance();
		$co->load->model('merging_model');
		$ci =& get_instance();
		$ci->load->model('wiki_model');
   	}
   	
   	function register_analisis($wikiname, $colorname = "", $date){
		
		$sql = array(
			'analisis_id' => "",
   			'analisis_date' => $date,
   			'analisis_wiki_name' => $wikiname,
   			'analisis_color_name' => $colorname
   			);
   				
		$this->db->insert('analisis', $sql);
		
		//Checking no errors
		if($this->db->affected_rows() != 1) 
			return "perform_analisis(): ERR_AFFECTED_ROWS (".$this->db->affected_rows().")";
   	}
   	
   	function delete_analisis($analisis){
		echo $analisis;
		$check = $this->db->query("select analisis_date from analisis where analisis_date = '$analisis'");
   		if(!$check->result())
   			die( "delete_analisis(): ERR_NONEXISTENT");
		
		$check = $this->db->query("DELETE FROM analisis WHERE analisis_date = '$analisis'");
		$check = $this->db->query("DELETE FROM `user-analisis` WHERE analisis_date = '$analisis'");
		
		delete_files("analisis/$analisis/");
		rmdir("analisis/$analisis/");
		
		return true;
   	}
   	
   	function get_analisis_data($date){
		$data = $this->db->get_where('analisis', array('analisis_date' => $date));
		if(!$data->result())
			return false;
		foreach($data->result() as $row)
			return array('awiki' => $row->analisis_wiki_name, 'acolor' => $row->analisis_color_name);
   	}
}