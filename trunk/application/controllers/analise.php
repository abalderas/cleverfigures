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


//ANALISE CONTROLLER
class Analise extends CI_Controller {

	function Analise(){
      		parent::__construct();
      		$this->load->model('color_model');
      		$this->load->model('user_model');
      		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
   	//MAIN FUNCTION
   	function index(){
   	
		//IF SESSION EXPIRED
		if(!$this->session->userdata('username')){
			redirect('login/loadlogin/');
		}
		else{
		
			//CREATE HEADER ARRAY
			$datah = array('title' => lang('voc.i18n_analise_view'));
			
			//CREATE COLOR LIST ARRAY
			$colors = array('false' => lang('voc.i18n_no_color'));
			$colors = array_merge($colors, $this->user_model->get_color_list($this->session->userdata('username')));
			
			//CREAT WIKI LIST ARRAY
			$wikis = array('false' => lang('voc.i18n_no_wiki')); 
			$wikis = array_merge($wikis, $this->user_model->get_wiki_list($this->session->userdata('username')));
			
			//CREATE DATA ARRAY
			$adata = array('wikis' => $wikis, 'colors' => $colors);
			
			//LOAD ANALISE VIEW
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/analise_view', $adata);
			$this->load->view('templates/footer_view');
		}
	}
}
