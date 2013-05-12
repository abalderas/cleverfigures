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



class Filters_form extends CI_Controller {

	function Filters_form(){
      		parent::__construct();
      		$this->load->model('analisis_model');
      		$this->load->model('group_model');
      		$this->load->model('wiki_model');
      		$this->lang->load('voc', $this->session->userdata('language'));
   	}
	
	//PREVIOUS HIGHEST KEY FUNCTION: GETS THE LAST HIGHEST KEY OF AN ARRAY CHECKING BACKWARDS FROM THE GIVEN ONE
	private function previous_highest_key($array, $key){
		$result = false;
		foreach(array_keys($array) as $akey){
			if($akey <= $key)
				$result = $akey;
			else 
				return $result;
		}
		return $result;
	}
	
	function filter($analysis, $type, $name){
		//IF SESSION EXPIRED
		if(!$this->session->userdata('username'))
			redirect('login/loadlogin/');
		else{
			
			//GET ANALISIS DATA
			$adata = $this->analisis_model->get_analisis_data($analysis);
			
			$this->session->set_userdata(array('aname' => $analysis));
			//IF NO DATA, ERROR
			if(!$adata)
				die('No such analisis data.');
			
			//CREATE HEADER ARRAY
			$datah = array('title' => lang('voc.i18n_check_results'), 'wiki' => $this->input->post('wname'), 'data' => $adata, 'aname' => $this->input->post('aname'));
			
			//LOAD HEADER VIEW
			$this->load->view('templates/header_view', $datah);
			
			//IF FILTERING BY USER
			if($type == 'user')
				//LOAD TABBED VIEW FOR USERS
				$this->load->view('content/useranalisis_view', array('data' => $adata, 'username' => $name, 'aname' => $analysis));
			//IF FILTERING BY PAGE
			else if($type == 'page')
				//LOAD TABBED VIEW FOR PAGES
				$this->load->view('content/pageanalisis_view', array('data' => $adata, 'pagename' => $name, 'aname' => $analysis));
			//IF FILTERING BY CATEGORY
			else if($type == 'category')
				//LOAD TABBED VIEW FOR CATEGORIES
				$this->load->view('content/categoryanalisis_view', array('data' => $adata, 'categoryname' => $name, 'aname' => $analysis));			
			//IF FILTERING BY GROUP
			else if($type == 'group')
				$this->load->view('content/groupanalysis_view', array('data' => $adata, 'groupname' => $name, 'aname' => $analysis));
			
			else{
				//FILTER NOT DEFINED, ERROR
				die('FILTER NOT DEFINED');
			}
			
			//LOAD FOOTER VIEW
			$this->load->view('templates/footer_view');
		}
	}
} 
