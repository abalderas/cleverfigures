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

//_deprecated_
/*
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
	
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
		
			//Form validation rules
			$this->form_validation->set_rules('filterid', lang('voc.i18n_filter_id'), 'required|alpha_dash|xss_clean');
			if(isset($_POST['filterusercheck'])) $this->form_validation->set_rules('filteruser', lang('voc.i18n_filter_type'), 'xss_clean');
			if(isset($_POST['filterpagecheck'])) $this->form_validation->set_rules('filterpage', lang('voc.i18n_filter_type'), 'xss_clean');
			if(isset($_POST['filtercategorycheck'])) $this->form_validation->set_rules('filtercategory', lang('voc.i18n_filter_type'), 'xss_clean');
			if(isset($_POST['filterccriteriacheck'])) $this->form_validation->set_rules('filtercriteria', lang('voc.i18n_filter_type'), 'xss_clean');
			$this->form_validation->set_rules('date_range_a', lang('voc.i18n_date_range_a'), 'required|xss_clean');
			$this->form_validation->set_rules('date_range_b', lang('voc.i18n_date_range_b'), 'required|xss_clean');

			//If invalid form, reload database config view
			if ($this->form_validation->run() == FALSE){
				$datah = array('title' => lang('voc.i18n_add_filter'));
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/add_filter_view');
				$this->load->view('templates/footer_view');
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
				//If checkbox is true but no name specified
				else if((isset($_POST['filterusercheck'])) && $_POST['filteruser'] == ""){
					$datah = array('title' => lang('voc.i18n_add_filter'));
					$error = array('filteruser_error'=> lang('voc.i18n_filteruser_error'));
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/add_filter_view', $error);
					$this->load->view('templates/footer_view');
				}
				else if((isset($_POST['filterpagecheck'])) && $_POST['filterpage'] == ""){
					$datah = array('title' => lang('voc.i18n_add_filter'));
					$error = array('filterpage_error'=> lang('voc.i18n_filterpage_error'));
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/add_filter_view', $error);
					$this->load->view('templates/footer_view');
				}
				else if((isset($_POST['filtercategorycheck'])) && $_POST['filtercategory'] == ""){
					$datah = array('title' => lang('voc.i18n_add_filter'));
					$error = array('filtercategory_error'=> lang('voc.i18n_filtercategory_error'));
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/add_filter_view', $error);
					$this->load->view('templates/footer_view');
				}
				else if((isset($_POST['filtercriteriacheck'])) && $_POST['filtercriteria'] == ""){
					$datah = array('title' => lang('voc.i18n_add_filter'));
					$error = array('filtercriteria_error'=> lang('voc.i18n_filtercriteria_error'));
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/add_filter_view', $error);
					$this->load->view('templates/footer_view');
				}
				//Else, save filter data and load configuration view
				else{
					$filterdata = array('filterid' => $_POST['filterid'], 'datea' => $_POST['date_range_a'], 'dateb' => $_POST['date_range_b']);
					
					if((isset($_POST['filterusercheck']))){
						$filterdata['filterusercheck'] = true;
						$filterdata['filteruser'] = $_POST['filteruser'];
					}
					else{
						$filterdata['filterusercheck'] = false;
						$filterdata['filteruser'] = "";
					}
					if((isset($_POST['filterpagecheck']))){
						$filterdata['filterpagecheck'] = true;
						$filterdata['filterpage'] = $_POST['filterpage'];
					}
					else{
						$filterdata['filterpagecheck'] = false;
						$filterdata['filterpage'] = "";
					}
					if((isset($_POST['filtercategorycheck']))){
						$filterdata['filtercategorycheck'] = true;
						$filterdata['filtercategory'] = $_POST['filtercategory'];
					}
					else{
						$filterdata['filtercategorycheck'] = false;
						$filterdata['filtercategory'] = "";
					}
					if((isset($_POST['filtercriteriacheck']))){
						$filterdata['filtercriteriacheck'] = true;
						$filterdata['filtercriteria'] = $_POST['filtercriteria'];
					}
					else{
						$filterdata['filtercriteriacheck'] = false;
						$filterdata['filtercriteria'] = "";
					}
					
					$this->filter_model->new_filter($filterdata);
					$this->user_model->relate_filter($filterdata['filterid']);
					
					$datah = array('title' => lang('voc.i18n_configuration'));
					$filters = array(0 => lang('voc.i18n_no_filter'));
					$filters = array_merge($filters, $this->filter_model->get_filter_list($this->session->userdata('username')));
					$confdata = array('filters' => $filters, 'userdefaultfilter' => $this->user_model->default_filter($this->session->userdata('username')));
					
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/configuration_view', $confdata);
					$this->load->view('templates/footer_view');
				}
			}
		}
	}
} */