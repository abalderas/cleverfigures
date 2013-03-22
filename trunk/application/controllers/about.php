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


//ABOUT CONTROLLER
class About extends CI_Controller {

	function About(){
      		parent::__construct();
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
		else{
			
			//CREATE HEADER ARRAY
			$datah = array('title' => lang('voc.i18n_about'));
			
			//LOAD VIEWS
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/about_view');
			$this->load->view('templates/footer_view');
		}
	}
}