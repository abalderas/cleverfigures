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



class Login_form extends CI_Controller {

	function Login_form(){
      		parent::__construct();
      		$this->load->model('user_model');
		$this->load->model('analisis_model');
		$this->load->model('wiki_model');
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
	function index(){
		if(isset($_POST['forgot'])){
			$datah = array('title' => lang('voc.i18n_forgot_view'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/forgot_view');
			$this->load->view('templates/footer_view');
		}
		else{
			//If logged in correctly
			if($this->user_model->login($this->input->post('username'), $this->input->post('password'))){
				//Get data for header
				$datah = array('title' => lang('voc.i18n_teacher_view'));
			
				//If there are analisis performed by he user
				if($this->user_model->get_analisis_list($this->session->userdata('username'))){
					foreach($this->user_model->get_analisis_list($this->session->userdata('username')) as $analisis){
						$adata = $this->analisis_model->get_analisis_data($analisis);
						$adate[] = $analisis;
						$awiki[] = $this->analisis_model->get_analisis_wiki($analisis);
						$acolor[] = $this->analisis_model->get_analisis_color($analisis);
					}
			
					$tdata = array('adate' => $adate, 'awiki' => $awiki, 'acolor' => $acolor);
				
					//And give the data to the view
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/teacher_view', $tdata);
					$this->load->view('templates/footer_view');
				}
				//Else, load view without data
				else{
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/teacher_view');
					$this->load->view('templates/footer_view');
				}
			}
			else if($this->wiki_model->student_login($this->input->post('username'), $this->input->post('password'))){
// 				$reports = $this->report_model->get_my_reports($this->session->userdata('username'));
// 				if($reports){
// 					foreach($reports as $report){
// 					}
// 			
// 					$tdata = array('rdate' => $rdate, 'rwiki' => $rwiki, 'rteacher' => $rteacher, 'rtype' => $rtype, 'rname' => $rname);
// 				
// 					//And give the data to the view
// 					$this->load->view('templates/header_view', $datah);
// 					$this->load->view('content/student_view', $tdata);
// 					$this->load->view('templates/footer_view');
// 				}
// 				//Else, load view without data
// 				else{
// 					$this->load->view('templates/header_view', $datah);
// 					$this->load->view('content/teacher_view');
// 					$this->load->view('templates/footer_view');
// 				}
			}
			
			//Else, reload login view showing error
			else{
				$datah = array('title' => lang('voc.i18n_login'));
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/login_view', array('error' => true));
				$this->load->view('templates/footer_view');
			}
		}
	}
}  
