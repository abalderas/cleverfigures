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


//LOGIN CONTROLLER
class Login_form extends CI_Controller {

	function Login_form(){
 		parent::__construct();
 		$this->load->model('user_model');
		$this->load->model('analisis_model');
		$this->load->model('student_model');
		$this->load->model('wiki_model');
 		$this->lang->load('voc', $this->session->userdata('language'));
 	}
   	
	function index(){
		//IF USER FORGOT PASSWORD
		if(isset($_POST['forgot'])){
			//CREATE HEADER ARRAY
			$datah = array('title' => lang('voc.i18n_forgot_view'));
			
			//LOAD FORGOT VIEW
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/forgot_view');
			$this->load->view('templates/footer_view');
		}
		else{
			//IF USER LOGGED CORRECTLY AS TEACHER
			if($this->user_model->login($this->input->post('username'), $this->input->post('password')))
				redirect('teacher');
			//IF USER LOGGED CORRECTLY AS STUDENT
			else if($this->student_model->login($this->input->post('username'), $this->input->post('password')))
				redirect('student');
			//ELSE, INCORRECT LOGIN CREDENTIALS
			else
				redirect('login/loadlogin/error');
		}
	}
}
