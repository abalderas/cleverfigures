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


//REPORT OPTIONS CONTROLLER
class Options_form extends CI_Controller {

	function Options_form(){
      		parent::__construct();
      		$this->load->model('wiki_model');
      		$this->load->model('color_model');
      		$this->load->model('analisis_model');
      		$this->load->model('user_model');
      		$this->load->model('group_model');
      		$this->load->model('csv_model');
      		$this->lang->load('voc', $this->session->userdata('language'));
 	}
   	
	function index(){
		//IF SESSION EXPIRED, LOAD LOGIN VIEW
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
	}
	
	//DELETE ANALISIS FUNCTION
	function delete($name){
		//IF SESSION EXPIRED, LOAD LOGIN VIEW
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
			
			//DELETE ANALYSIS
			$this->analisis_model->delete_analisis($name);
				
			//REDIRECT TO TEACHER CONTROLLER
			redirect('teacher');
		}
	}
	
	//VIEW REPORT FUNCTION
	function view($name){
		//IF SESSION EXPIRED, LOAD LOGIN VIEW
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
			
			//LOAD ANALISIS DATA
			$adata = $this->analisis_model->get_analisis_data($name);
		
			$this->session->set_userdata('analysis', $name);
			
			//CREATE HEADER ARRAY
			$datah = array('title' => lang('voc.i18n_check_results'), 'aname' => $name, 'data' => $adata);
			
			//LOAD VIEWS WITH DATA
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/check_results_view', array('aname' => $name, 'data' => $adata));
			$this->load->view('templates/footer_view');
		}
	}
	
	function studentview($name, $studentname){
		//IF SESSION EXPIRED, LOAD LOGIN VIEW
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
		
			//CREATE HEADER ARRAY
			$datah = array('title' => lang('voc.i18n_check_results'));
			
			//LOAD ANALISIS DATA
			$adata = $this->analisis_model->get_analisis_data($name);
			
			//LOAD VIEWS WITH DATA
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/useranalisis_view', array('aname' => $name, 'data' => $adata, 'username' => $studentname));
			$this->load->view('templates/footer_view');
		}
	}
}
