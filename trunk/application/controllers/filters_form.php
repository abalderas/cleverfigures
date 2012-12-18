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



class Filters_form extends CI_Controller {

	function Filters_form(){
      		parent::__construct();
      		$this->load_model('analisis_model');
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}
	
	function index(){
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
			$adata = $this->analisis_model->get_analisis_data($this->session->flashdata('aname'));
		
			$datah = array('title' => lang('voc.i18n_check_results'));
			$this->load->view('templates/header_view', $datah);
		
			if($_POST['select_filter'] == lang('voc.i18n_user'))
				$this->load->view('content/pageanalisis_view', array('data' => $adata, 'pagename' => $_POST['filterstring']));
			else if($_POST['select_filter'] == lang('voc.i18n_page'))
				$this->load->view('content/useranalisis_view', array('data' => $adata, 'pagename' => $_POST['filterstring']));
			else if($_POST['select_filter'] == lang('voc.i18n_category'))
				$this->load->view('content/catanalisis_view', array('data' => $adata, 'pagename' => $_POST['filterstring']));
			//else if($_POST['select_filter'] == lang('voc.i18n_criteria')){}
			else{	
				die('Filters_form : FATAL ERROR');
			}
		
			$this->load->view('templates/footer_view');
		}
	}
} 