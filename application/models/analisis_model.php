<!--
<<Copyright 2013 Alvaro Almagro Doello>>

This file is part of CleverFigures.

CleverFigures is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

CleverFigures is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with CleverFigures.  If not, see <http://www.gnu.org/licenses/>.
-->

<?php

class Analisis_model extends CI_Model{

	//METHODS
   	function Analisis_model(){
   	   	parent::__construct();
   	   	$co =& get_instance();
		$co->load->model('merging_model');
		$ci =& get_instance();
		$ci->load->model('wiki_model');
   	}
   	
   	function perform_analisis($wikiname, $colorname = 'default', $date_range_a = 'default', $date_range_b = 'default', $filter_user = 'default', $filter_page = 'default', $filter_category = 'default'){
   	
		//Creamos el nombre del análisis, compuesto de la fecha, la wiki, el color y el usuario.
		$formato = 'DATE_W3C';
		$tiempo = time();
		$analisis = standard_date($formato, $tiempo).$wikiname.$colorname.$this->session->userdata('user_username'); 

		//Realizamos el análisis
		if($result = gettype($this->merging_model->merge_save_users($wikiname, $analisis, $colorname, $date_range_a, $date_range_b, $filter_page, $filter_category)) != "boolean")
			die($result);
		
		if($result = gettype($this->merging_model->save_pages($wikiname, $analisis, $colorname, $date_range_a, $date_range_b, $filter_user)) != "boolean")
			die($result);
		
		if($result = gettype($this->merging_model->save_categories($wikiname, $analisis, $colorname, $date_range_a, $date_range_b, $filter_page, $filter_user)) != "boolean")
			die($result);
		
		if($result = gettype($this->merging_model->save_images($wikiname, $analisis, $colorname, $date_range_a, $date_range_b, $filter_user, $filter_page, $filter_category)) != "boolean")
			die($result);
		
		if($result = gettype($this->wiki_model->fetch_general_stats($wikiname, $analisis)) != "boolean")
			die($result);
		
		//TO_DO: graficos
		
		//Una vez terminado, registramos el análisis.
		$sql = array(
			'analisis_id' => $analisis,
   			'analisis_date' => standard_date($formato, $tiempo),
   			'analisis_wiki_name' => $wikiname,
   			'analisis_color_name' => $colorname,
   			'analisis_date_range_a' => $date_range_a,
   			'analisis_date_range_b' => $date_range_b
   			);
   				
		$this->db->insert('analisis', $sql);
		
		//Comprobamos que la insertación se hizo con éxito
		if($this->db->affected_rows() != 1) 
			return "perform_analisis(): ERR_AFFECTED_ROWS (".$this->db->affected_rows().")";
			
		//Devolvemos el nombre del analisis
		return $analisis;
   	}
   	
   	function delete_analisis($analisis){
		
		$check = $this->db->query("select analisis_id from analisis where analisis_id == $analisis");
   		if($check->result()->num_rows() == 0)
   			return "delete_analisis(): ERR_NONEXISTENT";
   	
		$this->db->delete('analisis', array('analisis_id' => $analisis));
		$this->db->delete('wimage', array('wi_analisis' => $analisis));
		$this->db->delete('wuser', array('wu_analisis' => $analisis));
		$this->db->delete('wpage', array('wp_analisis' => $analisis));
		$this->db->delete('wcategory', array('wc_analisis' => $analisis));
		$this->db->delete('wgeneral', array('wgen_analisis' => $analisis));
   	}
   	
   	function get_analisis_data($analisis){
		$data = $this->db->get_where('analisis', array('analisis_id' => $analisis));
		if(!$data->result())
			return false;
		return $data->result();
   	}
}

?>  
