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

//END OF INSTALLATION CONTROLLER
class Installation_end_form extends CI_Controller {

	function Installation_end_form(){
      		parent::__construct();
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
	function index(){
	
		//CREATE HEADER ARRAY
		$datah = array('title' => lang('voc.i18n_login'));
		
		//LOAD VIEW
		$this->load->view('templates/header_view', $datah);
		$this->load->view('content/login_view');
		$this->load->view('templates/footer_view');
	}
}  
