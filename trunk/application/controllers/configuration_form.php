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
// 		$this->lang->load('voc', $this->session->userdata('language'));
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
				
				//LOAD ADD COLOR VIEW
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/add_color_view');
				$this->load->view('templates/footer_view');
			}
			
			//IF USER ADDITION SELECTED
			else if($this->input->post('add_user')){
				
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_add_user'));
				
				//LOAD USER CREATION FORM
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/installation2_view');
				$this->load->view('templates/footer_view');
			}
			
			//IF SAVE CONFIGURATION SELECTED
			else if($this->input->post('save_conf')){
				
				//SET LANGUAGE
				$lang = $_POST['select_language'];
				
				//SET USERNAME
				$user = $this->session->userdata('username');
				
				//SET HIGH CONTRAST
				$high_contrast = (isset($_POST['high_contrast'])) ? true : false ;
				
				//SAVE CONFIGURATION INTO DATABASE AND UPDATE COOKIE
				$this->db->query("UPDATE user SET user_language='$lang', user_high_contrast = '$high_contrast' WHERE user_username = '$user'");
				$this->session->set_userdata(array('language' => $lang, 'high_contrast' => $high_contrast));
				
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_configuration'));
				
				//LOAD CONFIGURATION VIEW
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/configuration_view');
				$this->load->view('templates/footer_view');
			}
			
			//IF CANNCEL SELECTED
			else if($this->input->post('cancel_conf')){
				
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_configuration'));
				
				//LOAD CONFIGURATION VIEW
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/teacher_view');
				$this->load->view('templates/footer_view');
			}
		}
	}
}  
