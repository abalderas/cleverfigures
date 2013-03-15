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
class Delete_user extends CI_Controller {

	function Delete_user(){
      		parent::__construct();
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
	}
	
	function deleteuser($username){
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
			if($this->user_model->delete_user($username)){
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_configuration_view'));
					
				//LOAD CONFIGURATION VIEW
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/configuration_view', array('wikilist' => $this->user_model->get_wiki_list($this->session->userdata('username')), 'colorlist' => $this->user_model->get_color_list($this->session->userdata('username'))));
				$this->load->view('templates/footer_view');
			}
			else{
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_configuration_view'));
					
				//LOAD CONFIGURATION VIEW
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/configuration_view', array('userdeleteerror' => true, 'wikilist' => $this->user_model->get_wiki_list($this->session->userdata('username')), 'colorlist' => $this->user_model->get_color_list($this->session->userdata('username'))));
				$this->load->view('templates/footer_view');
			}
		}
	}
}