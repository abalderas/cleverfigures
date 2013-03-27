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
	
	//MAIN FUNCTION
	function index(){
		//IF SESSION EXPIRED
		if(!$this->session->userdata('username'))
			redirect('login/loadlogin/');
		else{
			//SEPARATE STRING INTO SINGLE NAMES
			$filterstrings = explode(',', $_POST['filterstring']);
			array_pop($filterstrings);
			foreach($filterstrings as $key => $value)
				$filterstrings[$key] = trim($value);
			
			//GET ANALISIS DATA
			$adata = $this->analisis_model->get_analisis_data($this->input->post('aname'));
			
			//IF NO DATA, ERROR
			if(!$adata)
				die('No such analisis data.');
			
			//CREATE HEADER ARRAY
			$datah = array('title' => lang('voc.i18n_check_results'));
			
			//LOAD HEADER VIEW
			$this->load->view('templates/header_view', $datah);
			
			//IF FILTERING BY USER
			if($_POST['select_filter'] == lang('voc.i18n_user'))
				//LOAD TABBED VIEW FOR USERS
				$this->load->view('content/tabbed_view', array('data' => $adata, 'names' => $filterstrings, 'type' => 'user', 'panid' => '1', 'wiki' => $this->input->post('wname')));
			//IF FILTERING BY PAGE
			else if($_POST['select_filter'] == lang('voc.i18n_page'))
				//LOAD TABBED VIEW FOR PAGES
				$this->load->view('content/tabbed_view', array('data' => $adata, 'names' => $filterstrings, 'type' => 'page', 'panid' => '1', 'wiki' => $this->input->post('wname')));
			//IF FILTERING BY CATEGORY
			else if($_POST['select_filter'] == lang('voc.i18n_category'))
				//LOAD TABBED VIEW FOR CATEGORIES
				$this->load->view('content/tabbed_view', array('data' => $adata, 'names' => $filterstrings, 'type' => 'category', 'panid' => '1', 'wiki' => $this->input->post('wname')));
			//IF FILTERING BY GROUP
			else if($_POST['select_filter'] == lang('voc.i18n_group')){
				$id = 1;
				//FOR EACH GROUP
				foreach($filterstrings as $groupname){
					//GET MEMBERS
					$members = $this->group_model->get_members($groupname);
					
					//IF THERE ARE MEMBERS
					if($members){
						//LOAD TABBED VIEW FOR USERS
						$this->load->view('content/tabbed_view', array('data' => $adata, 'names' => $members, 'type' => 'user', 'panid' => $id, 'wiki' => $this->input->post('wname')));
						echo "<br><br>";
					}
					$id++;
				}
			}
			else{
				//FILTER NOT DEFINED, ERROR
				die('FILTER NOT DEFINED');
			}
			
			//LOAD FOOTER VIEW
			$this->load->view('templates/footer_view');
		}
	}
} 