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

class Teacher extends CI_Controller {

	function Teacher(){
      		parent::__construct();
      		$this->load->model('wiki_model');
      		$this->load->model('color_model');
      		$this->load->model('user_model');
      		$this->load->model('analisis_model');
   	}
   	
	function index(){
		
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
			foreach($this->user_model->get_analisis_list($this->session->userdata('username')) as $analisis){
				$adate[] = $analisis;
				$awiki[] = $this->analisis_model->get_analisis_wiki($analisis);
				$acolor[] = $this->analisis_model->get_analisis_color($analisis);
			}
			
			if(isset($adate))
				$tdata = array('adate' => $adate, 'awiki' => $awiki, 'acolor' => $acolor);
			else
				$tdata = array();
				
			$datah = array('title' => lang('voc.i18n_teacher_view'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/teacher_view', $tdata);
			$this->load->view('templates/footer_view');
		}
	}
} 