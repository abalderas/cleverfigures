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



class Groupsave extends CI_Controller {

	function Groupsave(){
      		parent::__construct();
      		$this->load->model('wiki_model');
      		$this->load->model('group_model');
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
   	function index(){
   	
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
	}
	
	function savegroup($wikiname){
   	
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
			
			$users = $this->wiki_model->get_user_list($wikiname);
			if($users)
				foreach($users as $user)
					if($this->input->post($user."group") != "no group")
						$this->group_model->join_group($this->input->post($user."group"), $user);
					else
						$this->group_model->leave_group($user);
			
			$this->load->view('templates/header_view', array('title' => lang('voc.i18n_groups')));
			$this->load->view('content/group_view', array('wiki' => $wikiname, 'groupsaved' => true, 'users' => $users));
			$this->load->view('templates/footer_view');
		}
	}
}