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
class Login extends CI_Controller {

	function Login(){
		parent::__construct();
		$this->lang->load('voc', 'english');
 	}
   	
	function loadlogin($error = false){
		//CREATE HEADER ARRAY
		$datah = array('title' => lang('voc.i18n_login'));
		
		//LOAD LOGIN VIEW
		$this->load->view('templates/header_view', $datah);
		if($error)
			$this->load->view('content/login_view', array('error' => $error));
		else
			$this->load->view('content/login_view');
		$this->load->view('templates/footer_view');
	}
}
