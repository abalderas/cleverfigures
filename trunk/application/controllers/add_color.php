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
			redirect('login/loadlogin/');
		}
		else{
		
			//VALIDATING FORM
			$this->form_validation->set_rules('color_name', lang('voc.i18n_color_name'), 'required|xss_clean');
			$this->form_validation->set_rules('dbname', lang('voc.i18n_dbname'), 'required|xss_clean');
			$this->form_validation->set_rules('dbserver', lang('voc.i18n_dbserver'), 'required|xss_clean');
			$this->form_validation->set_rules('dbpassword', lang('voc.i18n_dbpassword'), 'required|xss_clean');
			$this->form_validation->set_rules('dbuser', lang('voc.i18n_dbuser'), 'required|xss_clean');

			//IF INVALID FORM
			if ($this->form_validation->run() == FALSE){
				
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_add_color'));
				
			  $wikis = $this->user_model->get_wiki_list($this->session->userdata('username'));

        //LOAD ADD COLOR VIEW
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/add_color_view', array('wikis' => $wikis));
				$this->load->view('templates/footer_view');
			}
			else{
				//IF CONNECTION ERROR
				if(!$this->test_connection()){
					//CREATE HEADER ARRAY
					$datah = array('title' => lang('voc.i18n_add_color'));
									
			  	//GET USER WIKIS
			  	$wikis = $this->user_model->get_wiki_list($this->session->userdata('username'));

          //LOAD ADD COLOR VIEW
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/add_color_view', array('wikis' => $wikis, 'connection_error' => lang('voc.i18n_connection_error')));
					$this->load->view('templates/footer_view');
        }
				else{
					//SAVING DATABASE
          $this->color_model->new_color($_POST['color_name'], $_POST['dbserver'], $_POST['dbname'],
            $_POST['dbuser'], $_POST['dbpassword'], $_POST['related_wiki']);
					
					//RELATE COLOR TO THE USER
					$this->user_model->relate_color($_POST['color_name']);
					
					redirect('configure');
				}
			}
		}
	}
} 
