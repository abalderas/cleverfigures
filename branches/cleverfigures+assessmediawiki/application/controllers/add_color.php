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



class Add_color extends CI_Controller {

	function Add_color(){
      		parent::__construct();
		$this->load->model('color_model');
		$this->load->model('user_model');
// 		$this->load->model('filter_model');
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
   	private function test_connection(){
		$db = @mysqli_connect($_POST['dbserver'], $_POST['dbuser'], $_POST['dbpassword'], $_POST['dbname'], TRUE);
		if($db)
			return TRUE;
		else
			return FALSE;
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
			$this->form_validation->set_rules('color_name', lang('voc.i18n_color_name'), 'required|alpha_dash|xss_clean');
			$this->form_validation->set_rules('dbname', lang('voc.i18n_dbname'), 'required|alpha_dash|xss_clean');
			$this->form_validation->set_rules('dbserver', lang('voc.i18n_dbserver'), 'required|alpha_dash|xss_clean');
			$this->form_validation->set_rules('dbpassword', lang('voc.i18n_dbpassword'), 'required|xss_clean');
			$this->form_validation->set_rules('dbuser', lang('voc.i18n_dbuser'), 'required|alpha_dash|xss_clean');

			//If invalid form, reload view
			if ($this->form_validation->run() == FALSE){
				$datah = array('title' => lang('voc.i18n_add_color'));
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/add_color_view');
				$this->load->view('templates/footer_view');
			}
			else{
				//If connection failure with given data, reload and show error
				if(!$this->test_connection()){
					$datah = array('title' => lang('voc.i18n_add_color'));
					$error = array('connection_error'=> lang('voc.i18n_connection_error'));
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/add_color_view', $error);
					$this->load->view('templates/footer_view');
				}
				//Else, save color and load configuration view
				else{
					//Saving database
					$this->color_model->new_color($_POST['color_name'], $_POST['dbserver'], $_POST['dbname'], $_POST['dbuser'], $_POST['dbpassword']);
					$this->user_model->relate_color($_POST['color_name']);
					
					$filters = array(0 => lang('voc.i18n_no_filter'));
					$filters = array_merge($filters, $this->filter_model->get_filter_list($this->session->userdata('username')));
					$confdata = array('filters' => $filters, 'userdefaultfilter' => $this->user_model->default_filter($this->session->userdata('username')));
			
					$datah = array('title' => lang('voc.i18n_installation'));
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/configuration_view', $confdata);
					$this->load->view('templates/footer_view');
				}
			}
		}
	}
} 