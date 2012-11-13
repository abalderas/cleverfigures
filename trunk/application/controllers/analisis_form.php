<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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



class Analisis_form extends CI_Controller {

	function Analisis_form(){
      		parent::__construct();
      		$this->load->model('wiki_model');
      		$this->load->model('color_model');
      		$this->load->model('filter_model');
      		$this->load->helper('date');
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
   	private function time_php2sql($unixtime){
		return gmdate("Y-m-d H:i:s", $unixtime);
	}

	function displayTree($array) {
	$output = "";
     $newline = "<br>";
     foreach($array as $key => $value) {    //cycle through each item in the array as key => value pairs
         if (is_array($value) || is_object($value)) {        //if the VALUE is an array, then
            //call it out as such, surround with brackets, and recursively call displayTree.
             $value = "Array()" . $newline . "(<ul>" . $this->displayTree($value) . "</ul>)" . $newline;
         }
        //if value isn't an array, it must be a string. output its' key and value.
        $output .= "[$key] => " . $value . $newline;
     }
     return $output;
     }
   	private function analise($analisis_data){
		set_time_limit (0);
		if($analisis_data['filter'] != lang('voc.i18n_no_filter')){
			$start = microtime(true);
			echo "flores1: ". $analisis_data['datea'];
			$wiki_result = $this->wiki_model->fetch($analisis_data['wiki'], $analisis_data['filter']);
			
			printf("Performed in %.02f seconds.", (microtime(true)-$start));
		}
		else{
			$start = microtime(true);
			
			$wiki_result = $this->wiki_model->fetch($analisis_data['wiki'], false, $this->time_php2sql(strtotime($analisis_data['date_range_a'])), $this->time_php2sql(strtotime($analisis_data['date_range_b'])));
			
			echo $this->displayTree($wiki_result);
			printf("Performed in %.02f seconds.", (microtime(true)-$start));
		}
   	}
   	
   	function index(){
		$adata = array('wiki' => $_POST['select_wiki'], 
				'color' => $_POST['select_color'], 
				'date_range_a' => $_POST['select_date_range_a'], 
				'date_range_b' => $_POST['select_date_range_b'], 
				'filter' => $_POST['select_filter']
			);
		$datah = array('title' => lang('voc.i18n_analising'));
		
		echo $this->load->view('templates/header_view', $datah, true);
		echo $this->load->view('content/analising_view', $adata, true);
		echo $this->load->view('templates/footer_view', true);
		
		$this->analise($adata);
	}
}