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


//GROUP CREATION CONTROLLER
class Groupcreate extends CI_Controller {

	function Groupcreate(){
      		parent::__construct();
      		$this->load->model('group_model');
      		$this->load->model('wiki_model');
      		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
   	//DOES NOTHING, JUST CHECKS SESSION IN CASE OF FAILURE
	function index(){
		if(!$this->session->userdata('username'))
			redirect('login/loadlogin/');
	}
	
	//CREATE GROUP FUNCTION
	function crgroup($wikiname){
   	
		//IF SESSION EXPIRED
		if(!$this->session->userdata('username'))
			redirect('login/loadlogin/');
		else{
			//CREATE HEADER ARRAY
			$datah = array('title' => lang('voc.i18n_groups'));
			
			//LOAD HEADER VIEW
			$this->load->view('templates/header_view', $datah);
			
			//GET USERS LIST
			$users = $this->wiki_model->get_user_list($wikiname);
			
			//IF GROUP NAME SPECIFIED
			if($_POST['groupnameinput'] != ""){
				//CREATE GROUP WITH THAT NAME
				$created = $this->group_model->new_group($_POST['groupnameinput'], $wikiname);
				
				//IF SUCCESSFUL
				if($created)
					//LOAD GROUP VIEW SHOWING 'GROUP CREATED'
					$this->load->view('content/group_view', array('wiki' => $wikiname, 'groupcreated' => true, 'users' => $users));
				else
					//LOAD GROUP VIEW SHOWING 'GROUP EXISTS' ERROR
					$this->load->view('content/group_view', array('wiki' => $wikiname, 'groupexists' => true, 'users' => $users));
			}
			else{
				//LOAD GROUP VIEW SHOWING 'NAME NOT SET' ERROR
				$this->load->view('content/group_view', array('wiki' => $wikiname, 'errgroupnamenotset' => true, 'users' => $users));
			}
			
			//LOAD FOOTER VIEW
			$this->load->view('templates/footer_view');
		}
	}
}