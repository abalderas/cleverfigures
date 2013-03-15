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


//ADD WIKI CONTROLLER
class Add_wiki extends CI_Controller {

	function Add_wiki(){
      		parent::__construct();
		$this->load->model('wiki_model');
		$this->load->model('user_model');
// 		$this->lang->load('voc', $this->session->userdata('language'));
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
			$this->form_validation->set_rules('wiki_name', lang('voc.i18n_wiki_name'), 'required|alpha_dash|xss_clean');
			$this->form_validation->set_rules('dbname', lang('voc.i18n_dbname'), 'required|alpha_dash|xss_clean');
			$this->form_validation->set_rules('dbserver', lang('voc.i18n_dbserver'), 'required|alpha_dash|xss_clean');
			$this->form_validation->set_rules('dbpassword', lang('voc.i18n_dbpassword'), 'required|xss_clean');
			$this->form_validation->set_rules('dbuser', lang('voc.i18n_dbuser'), 'required|alpha_dash|xss_clean');

			//IF INVALID FORM
			if ($this->form_validation->run() == FALSE){
				
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_add_wiki'));
				
				//LOAD ADD WIKI VIEW
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/add_wiki_view');
				$this->load->view('templates/footer_view');
			}
			else{
				//IF CONNECTION FAILURE
				if(!$this->test_connection()){
					//CREATE HEADER ARRAY
					$datah = array('title' => lang('voc.i18n_add_wiki'));
					
					//CREATE ERROR ARRAY
					$error = array('connection_error'=> lang('voc.i18n_connection_error'));
					
					//LOAD ADD WIKI VIEW
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/add_wiki_view', $error);
					$this->load->view('templates/footer_view');
				}
				else{
				
					//SAVING DATABASE
					$this->wiki_model->new_wiki($_POST['wiki_name'], $_POST['dbserver'], $_POST['dbname'], $_POST['dbuser'], $_POST['dbpassword'], $_POST['wiki_baseurl']);
						
					
					//RELATE WIKI TO THE USER
					$this->user_model->relate_wiki($_POST['wiki_name']);
			
					//CREATE HEADER ARRAY
					$datah = array('title' => lang('voc.i18n_configuration_view'));
					
					//LOAD CONFIGURATION VIEW
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/configuration_view', array('wikilist' => $this->user_model->get_wiki_list($this->session->userdata('username')), 'colorlist' => $this->user_model->get_color_list($this->session->userdata('username'))));
					$this->load->view('templates/footer_view');
				}
			}
		}
	}
}