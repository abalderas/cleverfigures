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


//CONFIGURATION FORM CONTROLLERS
class Configuration_form extends CI_Controller {

	function Configuration_form(){
      		parent::__construct();
      		$this->load->database();
      		$this->load->model('user_model');
      		$this->lang->load('voc', $this->session->userdata('language'));
 	}
   	
  //MAIN FUNCTION
	function index(){
	
		//IF SESSION EXPIRED
		if(!$this->session->userdata('username'))
			redirect('login/loadlogin/');
		else{
		
			//IF WIKI ADDITION SELECTED
			if($this->input->post('add_wiki')){
				
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_add_wiki'));
				
				//LOAD ADD WIKI VIEW
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/add_wiki_view');
				$this->load->view('templates/footer_view');
			}
			
			//IF COLOR ADDITION SELECTED
			else if($this->input->post('add_color')){
				
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_add_color'));
				
				//GET USER WIKIS
				$wikis = $this->user_model->get_wiki_list($this->session->userdata('username'));
				
				if($wikis == array()) {
					$datah = array('title' => lang('voc.i18n_configuration_view'));
					$error = lang('voc.i18n_no_wikis');
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/configuration_view', array('no_wikis' => $error));
					$this->load->view('templates/footer_view');
				}
				else {
					//LOAD ADD COLOR VIEW
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/add_color_view', array('wikis' => $wikis));
					$this->load->view('templates/footer_view');
				}
			}
			
			//IF USER ADDITION SELECTED
			else if($this->input->post('add_user')){
				
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_add_user'));
				
				//LOAD USER CREATION FORM
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/create_user_view');
				$this->load->view('templates/footer_view');
			}
			
			//IF CHANGE PASSWORD SELECTED
			else if($this->input->post('change_password')){
				
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_change_password'));
				
				//LOAD USER CREATION FORM
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/password_change_view');
				$this->load->view('templates/footer_view');
			}
			
			//IF SAVE CONFIGURATION SELECTED
			else if($this->input->post('save_conf')){
				
				//SET LANGUAGE
				$l = $_POST['select_language'];
				
				//SET USERNAME
				$user = $this->session->userdata('username');
				
				//SET HIGH CONTRAST
				$high_contrast = isset($_POST['high_contrast']);
				
				//SAVE CONFIGURATION INTO DATABASE AND UPDATE COOKIE
				$this->db->query("UPDATE user SET user_high_contrast = '$high_contrast' WHERE user_username = '$user'");
				$this->session->set_userdata(array('language' => $l, 'high_contrast' => $high_contrast));
				$this->user_model->update_language($l);
				$this->config->set_item('language', $l);
				
				//LOAD CONFIGURATION VIEW
				redirect('configure');
			}
			
			//IF CANNCEL SELECTED
			else
				redirect('configure');
		}
	}
}  
