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

class Configure extends CI_Controller {

	function Configure(){
      		parent::__construct();
      		$this->load->model('wiki_model');
      		$this->load->model('color_model');
      		$this->load->model('user_model');
   	}
   	
	function index(){
	
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
		
			$datah = array('title' => lang('voc.i18n_configuration'));
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/configuration_view', array('admin' => $this->session->userdata('is_admin'), 'wikilist' => $this->user_model->get_wiki_list($this->session->userdata('username')), 'colorlist' => $this->color_model->get_color_list($this->session->userdata('username'))));
			$this->load->view('templates/footer_view');
		}
	}
} 
