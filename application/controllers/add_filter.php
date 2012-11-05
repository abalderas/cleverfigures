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



class Create_database_form extends CI_Controller {

	function Create_database_form(){
      		parent::__construct();
		$this->load->model('analisis_model');
		$this->load->model('user_analisis_model');
		$this->load->model('dbforge_model');
		$this->load->model('dbconfig_model');
		$this->load->helper('file');
		$this->load->dbutil();
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
	
		//Form validation rules
		$this->form_validation->set_rules('dbname', lang('voc.i18n_dbname'), 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('dbserver', lang('voc.i18n_dbserver'), 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('dbpassword', lang('voc.i18n_dbpassword'), 'required|xss_clean');
		$this->form_validation->set_rules('dbuser', lang('voc.i18n_dbuser'), 'required|alpha_dash|xss_clean');

		//If invalid form, reload database config view
		if ($this->form_validation->run() == FALSE){
			$datah = array('title' => lang('voc.i18n_installation'));
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/dbconfig_view');
			$this->load->view('templates/footer_view');
		}
		else{
			//If connection failure with given data, reload and show error
			if(!$this->test_connection()){
				$datah = array('title' => lang('voc.i18n_installation'));
				$error = array('connection_error'=> lang('voc.i18n_connection_error'));
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/dbconfig_view', $error);
				$this->load->view('templates/footer_view');
			}
			//Else, save connection data and load next step
			else{
				//Saving connection database & creating tables
				$this->dbconfig_model->config_database($_POST['dbname'], $_POST['dbserver'], $_POST['dbuser'], $_POST['dbpassword']);
				$this->dbforge_model->build_database();
				
				$datah = array('title' => lang('voc.i18n_installation'));
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/installation2_view');
				$this->load->view('templates/footer_view');
			}
		}
	}
} 