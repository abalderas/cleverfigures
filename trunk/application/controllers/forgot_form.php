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


//FORGOTTEN PASSWORD CONTROLLER
class Forgot_form extends CI_Controller {

	function Forgot_form(){
      		parent::__construct();
      		$this->load->model('user_model');
      		$this->load->library('email');
      		$this->lang->load('voc', $this->session->userdata('language'));
 	}
   	
 	//RANDOM PASSWORD GENERATION FUNCTION
 	//THANKS (http://www.webtoolkit.info/php-random-password-generator.html) FOR THE CODE
 	function randPass($length, $strength=8) {
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength >= 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength >= 2) {
			$vowels .= "AEUY";
		}
		if ($strength >= 4) {
			$consonants .= '23456789';
		}
		if ($strength >= 8) {
			$consonants .= '@#$%';
		}
		
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}

	//MAIN FUNCTION
	function index(){
		//IF STORED MAIL FOR THE USER
		if($username = $this->user_model->search_mail_user($_POST['email'])){
			//GENERATE NEW PASSWORD
			$password = $this->randPass(8);
			
			//UPDATE USER PASSWORD
			//$this->user_model->update_password($username, $password);
			
			//EMAIL HIM WITH THE NEW CREDENTIALS
			$this->email->from('cleverfigures@cleverfigures.com', 'Cleverfigures');
			$this->email->to($_POST['email']);

			$this->email->subject(lang('voc.i18n_recovery_mail_subject')'Password Recovery');
			$this->email->message(lang('voc.i18n_recovery_mail_text') . lang('voc.i18n_username') . ": " . $username . "</br>" . lang('voc.i18n_new_password') . ": " . $password);

			$this->email->send();
			//echo $this->email->print_debugger();
			
			//CREATE HEADER ARRAY
			$datah = array('title' => lang('voc.i18n_login'));
			
			//LOAD LOGIN VIEW SAYING 'EMAIL SENT'
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view', array('emailsent' => true));
			$this->load->view('templates/footer_view');
		}
	}
}
