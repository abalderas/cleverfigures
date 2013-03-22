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


//CREATE DATABASE CONTROLLER
class Create_database_form extends CI_Controller {

	function Create_database_form(){
      		parent::__construct();
		$this->load->model('analisis_model');
		$this->load->model('user_analisis_model');
		$this->load->model('dbforge_model');
		$this->load->model('dbconfig_model');
		$this->load->helper('file');
		$this->load->dbutil();
      		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
   	//TEST_CONNECTION FUNCTION: TESTS IF A MYSQL CONNECTION IS WORKING CORRECTLY
   	private function test_connection(){
		$db = @mysqli_connect($_POST['dbserver'], $_POST['dbuser'], $_POST['dbpassword']);
		if($db)
			return TRUE;
		else
			return FALSE;
	}
	
	//MAIN FUNCTION
	function index(){
	
		//VALIDATING FORM
		$this->form_validation->set_rules('dbserver', lang('voc.i18n_dbserver'), 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('dbpassword', lang('voc.i18n_dbpassword'), 'required|xss_clean');
		$this->form_validation->set_rules('dbuser', lang('voc.i18n_dbuser'), 'required|alpha_dash|xss_clean');

		//IF INVALID FORM
		if ($this->form_validation->run() == FALSE){
		
			//CREATE HEADER ARRAY
			$datah = array('title' => lang('voc.i18n_installation'));
			
			//LOAD DATABASE CONFIGURATION VIEW
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/dbconfig_view');
			$this->load->view('templates/footer_view');
		}
		else{
			//IF CONNECTION FAILS
			if(!$this->test_connection()){
				
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_installation'));
				
				//CREATE CONNECTION ERROR ARRAY
				$error = array('connection_error'=> lang('voc.i18n_connection_error'));
				
				//LOAD DATABASE CONFIGURATION VIEW
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/dbconfig_view', $error);
				$this->load->view('templates/footer_view');
			}
			else{
				//SAVE COONECTION DATABASE
				$this->dbconfig_model->config_database('cleverfigures', $_POST['dbserver'], $_POST['dbuser'], $_POST['dbpassword']);
				
				//CREATE TABLES
				$this->dbforge_model->build_database('cleverfigures', $_POST['dbserver'], $_POST['dbuser'], $_POST['dbpassword']);
				
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_installation'));
				
				//LOAD INSTALLATION VIEW 2
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/installation2_view');
				$this->load->view('templates/footer_view');
			}
		}
	}
} 