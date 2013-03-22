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


//ADD COLOR CONTROLLER
class Add_color extends CI_Controller {

	function Add_color(){
      		parent::__construct();
		$this->load->model('color_model');
		$this->load->model('user_model');
      		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
   	//TEST_CONNECTION FUNCTION
   	private function test_connection(){
		$db = @mysqli_connect($_POST['dbserver'], $_POST['dbuser'], $_POST['dbpassword'], $_POST['dbname'], TRUE);
		if($db)
			return TRUE;
		else
			return FALSE;
	}
	
	//MAIN FUNCTION
	function index(){
		
		//IF SESSION EXPIRED
		if(!$this->session->userdata('username')){
			
			//CREATE HEADER ARRAY
			$datah = array('title' => lang('voc.i18n_login'));
			
			//LOAD LOGIN VIEW
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
		
			//VALIDATING FORM
			$this->form_validation->set_rules('color_name', lang('voc.i18n_color_name'), 'required|alpha_dash|xss_clean');
			$this->form_validation->set_rules('dbname', lang('voc.i18n_dbname'), 'required|alpha_dash|xss_clean');
			$this->form_validation->set_rules('dbserver', lang('voc.i18n_dbserver'), 'required|alpha_dash|xss_clean');
			$this->form_validation->set_rules('dbpassword', lang('voc.i18n_dbpassword'), 'required|xss_clean');
			$this->form_validation->set_rules('dbuser', lang('voc.i18n_dbuser'), 'required|alpha_dash|xss_clean');

			//IF INVALID FORM
			if ($this->form_validation->run() == FALSE){
				
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_add_color'));
				
				//LOAD ADD COLOR VIEW
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/add_color_view');
				$this->load->view('templates/footer_view');
			}
			else{
				//IF CONNECTION ERROR
				if(!$this->test_connection()){
					die('lol');
					//CREATE HEADER ARRAY
					$datah = array('title' => lang('voc.i18n_add_color'));
					
					//CREATE ERROR ARRAY
					$error = array('connection_error'=> lang('voc.i18n_connection_error'));
					
					//LOAD ADD COLOR VIEW
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/add_color_view', $error);
					$this->load->view('templates/footer_view');
				}
				else{
					//SAVING DATABASE
					$this->color_model->new_color($_POST['color_name'], $_POST['dbserver'], $_POST['dbname'], $_POST['dbuser'], $_POST['dbpassword']);
					
					//RELATE COLOR TO THE USER
					$this->user_model->relate_color($_POST['color_name']);
					
					//CREATE HEADER ARRAY
					$datah = array('title' => lang('voc.i18n_installation'));
					
					//LOAD CONFIGURATION VIEW
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/configuration_view', array('wikilist' => $this->user_model->get_wiki_list($this->session->userdata('username')), 'colorlist' => $this->user_model->get_color_list($this->session->userdata('username'))));
					$this->load->view('templates/footer_view');
				}
			}
		}
	}
} 