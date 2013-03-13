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

class Groups extends CI_Controller {

	function Groups(){
      		parent::__construct();
      		$this->load->model('wiki_model');
      		$this->load->model('group_model');
   	}
   	
   	//DOES NOTHING, JUST CHECKS SESSION IN CASE OF FAILURE
	function index(){
	
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
	}
	
	//GET STUDENT GROUP FUNCTION
	function getgroups($wiki){
		
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
			//CREATE HEADER ARRAY
			$datah = array('title' => lang('voc.i18n_groups'));
			
			//LOAD GROUP VIEW WITH USERS LIST AND WIKI NAME
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/group_view', array('wiki' => $wiki, 'users' => $this->wiki_model->get_user_list($wiki)));
			$this->load->view('templates/footer_view');
		}
	}
} 