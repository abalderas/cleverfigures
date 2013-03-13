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


//GROUP CREATE ARRAY
class Index_controller extends CI_Controller {

	function Index_controller(){
      		parent::__construct();
		$this->load->model('analisis_model');
		$this->load->model('dbforge_model');
		$this->load->model('user_model');
		$this->load->dbutil();
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
   	//FIRST TIME FUNCTION
	private function first_time(){
		$dbs = $this->dbutil->list_databases();
		if(!array_search('cleverfigures', $dbs)) return true;
		return false;
	}
	
	function index(){
			
		//IF FIRST TIME RUNNING CLEVERFIGURES
		if($this->first_time()){
			
			//CLEAR SESSION (JUST IN CASE SOMETHING HAPPENS)
			$this->session->sess_destroy();
			
			//CREATE HEADER ARRAY
			$datah = array('title' => lang('voc.i18n_installation'));
			
			//LOAD INSTALLATION VIEW
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/installation1_view');
			$this->load->view('templates/footer_view');
		}
		//IF NOT, CHECK ACTIVE SESSION
		else{
			//IF USER LOGGED IN
			if($this->session->userdata('username')){
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_teacher_view'));
				
				//LOAD ANALYSIS LIST
				foreach($this->user_model->get_analisis_list($this->session->userdata('username')) as $analisis){
					$adate = $analisis;
					$awiki = $this->analisis_model->get_analisis_wiki($analisis);
					$acolor = $this->analisis_model->get_analisis_color($analisis);
				}
				
				//IF THERE ARE ANALYSIS IN THE LIST, CREATE ARRAY
				if(isset($adate)) $tdata = array('adate' => $adate, 'awiki' => $awiki, 'acolor' => $acolor);
				else $tdata = array();
				
				//LOAD INITIAL VIEW WITH DATA
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/teacher_view', $tdata);
				$this->load->view('templates/footer_view');
			}
			else{
				//IF AN USER ALREADY EXISTS
				if($this->db->query('select * from user')->result()){
					//CREATE HEADER ARRAY
					$datah = array('title' => lang('voc.i18n_login'));
					
					//LOAD LOGIN VIEW
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/login_view');
					$this->load->view('templates/footer_view');
				}
				else{
					//CREATE HEADER ARRAY
					$datah = array('title' => lang('voc.i18n_installation'));
			
					//LOAD USER CREATION VIEW
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/installation2_view');
					$this->load->view('templates/footer_view');
				}
			}
		}
	}
} 
