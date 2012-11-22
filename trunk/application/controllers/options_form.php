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



class Options_form extends CI_Controller {

	function Options_form(){
      		parent::__construct();
      		$this->load->model('wiki_model');
      		$this->load->model('color_model');
      		$this->load->model('filter_model');
      		$this->load->model('analisis_model');
      		$this->load->model('user_model');
      		$this->load->model('csv_model');
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
   	function index(){
   	
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
		
			if(isset($_POST['delete'])){
				$datah = array('title' => lang('voc.i18n_delete_analisis'));
				
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/delete_analisis_view', array('analisis' => $_POST['aname']));
				$this->load->view('templates/footer_view');
			}
			else if(isset($_POST['view'])){
				$datah = array('title' => lang('voc.i18n_check_results'));
				
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/check_results_view', $_POST['alabel']);
				$this->load->view('templates/footer_view');
			}
			else die('FATAL ERROR');
		}
	}
}