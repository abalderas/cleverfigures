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


//ANALYSIS FORM CONTROLLER
class Charts extends CI_Controller {

	function Charts(){
      		parent::__construct();
      		$this->load->model('wiki_model');
      		$this->load->model('color_model');
      		$this->load->model('analisis_model');
      		$this->load->model('user_model');
      		$this->lang->load('voc', $this->session->userdata('language'));
   	}
	
	function index(){
		
	}
	
	function relations_graph($analysis_name, $type = 'all', $name = 'default'){
		//LOAD ANALISIS DATA
		$adata = $this->analisis_model->get_analisis_data($analysis_name);
		
		//LOAD VIEWS WITH DATA
		$this->load->view('content/relations_view', array('aname' => $analysis_name, 'data' => $adata, 'type' => $type, 'name' => $name));
	}
}
