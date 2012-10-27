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
   			'analisis_username' => $this->session->userdata('user_username')
   			'analisis_wiki_id' => $wikiname
   			'analisis_color_id' => $colorname
   			'analisis_date_range_a' => $date_range_a
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
   	
   	function get_analisis_data($user){
		$data = $this->db->query("select * from analisis where analisis_user = $user");
		
		$result = "<table><tr><th>".lang('i18n_date_hour')."</th><th>".lang('i18n_wiki')."</th><th>".lang('i18n_color')."</th><th>".lang('i18n_date_range_a')."</th><th>".lang('i18n_date_range_b')."</th></tr>";
		foreach($data as $row)
			$result .= "<tr><td>".$row->analisis_date."</td><td>".$row->analisis_wiki_id."</td><td>".$row->analisis_color_id."</td><td>".$row->analisis_date_range_a."</td><td>".$row->analisis_date_range_b."</td></tr>";
		$result .= "</table>";
		
		return $result;
   	}
}

?>  
