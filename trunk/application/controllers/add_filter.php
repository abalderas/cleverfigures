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



class Add_filter extends CI_Controller {

	function Add_filter(){
      		parent::__construct();
		$this->load->model('filter_model');
		$this->load->model('user_model');
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
   	private function test_dates($datea, $dateb){
		if ($datea > $dateb) return false;
		return true;
	}
   	
   	function index(){
	
		//Form validation rules
		$this->form_validation->set_rules('filterid', lang('voc.i18n_filter_id'), 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('filter_type', lang('voc.i18n_filter_type'), 'required|xss_clean');
		$this->form_validation->set_rules('filter_name', lang('voc.i18n_filter_name'), 'xss_clean');
		$this->form_validation->set_rules('date_range_a', lang('voc.i18n_date_range_a'), 'xss_clean');
		$this->form_validation->set_rules('date_range_b', lang('voc.i18n_date_range_b'), 'xss_clean');

		//If invalid form, reload database config view
		if ($this->form_validation->run() == FALSE){
			$datah = array('title' => lang('voc.i18n_add_filter'));
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/add_filter_view');
			$this->load->view('templates/footer_view');
			die('validation');
		}
		else{
			//If dates failure with given data, reload and show error
			if(!$this->test_dates(strtotime($_POST['date_range_a']), strtotime($_POST['date_range_b']))){
				$datah = array('title' => lang('voc.i18n_add_filter'));
				$error = array('date_error'=> lang('voc.i18n_date_error'));
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/add_filter_view', $error);
				$this->load->view('templates/footer_view');
			}
			//If type dropdown set to 'All' and then name specified
			else if(($_POST['filter_type'] == 0) && $_POST['filter_name']){
				$datah = array('title' => lang('voc.i18n_add_filter'));
				$error = array('type_error'=> lang('voc.i18n_type_error'));
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/add_filter_view', $error);
				$this->load->view('templates/footer_view');
			}
			//Else, save filter data and load configuration view
			else{
				//Saving connection database & creating tables
				$this->filter_model->new_filter($_POST['filterid'], $_POST['filter_type'], $_POST['filter_name'], strtotime($_POST['date_range_a']), strtotime($_POST['date_range_b']));
				$this->user_model->relate_filter($_POST['filterid']);
				
				$datah = array('title' => lang('voc.i18n_configuration'));
				$filters = array(0 => lang('voc.i18n_no_filter'));
				$filters = array_merge($filters, $this->filter_model->get_filter_list($this->session->userdata('username')));
				$confdata = array('filters' => $filters);
				
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/configuration_view', $confdata);
				$this->load->view('templates/footer_view');
			}
		}
	}
} 