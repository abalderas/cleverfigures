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



class Forgot_form extends CI_Controller {

	function Forgot_form(){
      		parent::__construct();
      		$this->load->model('user_model');
      		$this->load->library('email');
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
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

	function index(){
		if($username = $this->user_model->search_mail_user($_POST['email'])){
			$password = $this->randPass(8);

			//$this->user_model->update_password($username, $password);
			
			$this->email->from('cleverfigures@cleverfigures.com', 'Cleverfigures');
			$this->email->to($_POST['email']);

			$this->email->subject('Password Recovery');
			$this->email->message("These are your login credentials for CleverFigures: </br></br> 
						Username: ".$username."</br>
						New Password: ".$password
					);

			$this->email->send();
			//echo $this->email->print_debugger();
			
			$datah = array('title' => lang('voc.i18n_login'));
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view', array('emailsent' => true));
			$this->load->view('templates/footer_view');
		}
	}
} 