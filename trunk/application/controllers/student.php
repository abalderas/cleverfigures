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

//SELECT LANGUAGE CONTROLLER
class Student extends CI_Controller {

	function Student(){
      		parent::__construct();
      		$this->lang->load('voc', $this->config->item('language'));
      		$this->load->model('student_model');
      		$this->load->model('analisis_model');
   	}
   	
	function index(){
		
		//IF SESSION EXPIRED, LOAD LOGIN VIEW
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
			//LOAD ALL PERFORMED ANALISIS
			foreach($this->student_model->get_analysis_list($this->session->userdata('username')) as $analisis){
				$adate[] = $analisis;
				$awiki[] = $this->analisis_model->get_analisis_wiki($analisis);
				$acolor[] = $this->analisis_model->get_analisis_color($analisis);
			}
			
			//IF THERE ARE ANALYSIS, CREATE VIEW ARRAY
			if(isset($adate))
				$sdata = array('adate' => $adate, 'awiki' => $awiki, 'acolor' => $acolor);
			else
				$sdata = array();
				
			//CREATE HEADER ARRAY
			$datah = array('title' => lang('voc.i18n_student_view'));
			
			//LOAD VIEWS WITH CREATED ARRAYS
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/student_view', $sdata);
			$this->load->view('templates/footer_view');
		}
	}
} 