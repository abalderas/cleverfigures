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
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}
	
	private function previous_highest_key($array, $key){
		$result = false;
		$keys = array_keys($array);
		sort($keys);
		foreach($keys as $akey){////////////////////////////////////////////////////////////////////////////
			if($akey <= $key)
				$result = $akey;
			else 
				return $result;
		}
	}
	
	private function split_string($string, $delimiter){
		$ufstring = str_replace(' ','',$string);
		$finalarray = explode($delimiter, $ufstring);
		array_pop($finalarray);
		return $finalarray;
	}
	
	private function combine_additive_array($superarray){
		$keys = array();
		foreach($superarray as $arg_array)
			$keys = array_merge(array_keys($arg_array), $keys);
		$keys = array_unique($keys);
		sort($keys);
		
		foreach($keys as $key)
			foreach($superarray as $arg_array){
				$value = ($this->previous_highest_key($arg_array, $key)) ? $arg_array[$this->previous_highest_key($arg_array, $key)] : false;
				$sum = $value ? $value : 0;
				$result[$key] = (isset($result[$key])) ? $result[$key] + $sum : $sum;
			}
		return $result;
	}
	
	private function combine_array($superarray){
		$keys = array();
		foreach($superarray as $arg_array)
			$keys = array_merge(array_keys($arg_array), $keys);
		$keys = array_unique($keys);
		sort($keys);
		
		foreach($keys as $key)
			foreach($superarray as $arg_array){
				$value = (isset($arg_array[$key])) ? $arg_array[$key] : false;
				$sum = $value ? $value : 0;
				$result[$key] = (isset($result[$key])) ? $result[$key] + $sum : $sum;
			}
		return $result;
	}
	
	private function combine_results($names, $filtertype, $data){
		$combined_data = array();
		if($_POST['select_filter'] == lang('voc.i18n_user')){
			foreach($names as $user)
				$edits_arrays[$user] = $data['useredits'][$user];
				$edits_art_arrays[$user] = $data['useredits_art'][$user];
				$bytes_arrays[$user] = $data['userbytes'][$user];
				$bytes_art_arrays[$user] = $data['userbytes_art'][$user];
				$edits_per_arrays[$user] = $data['useredits_per'][$user];
				$realname_arrays[$user] = $data['userrealname'][$user];
				$bytes_art_per_arrays[$user] = $data['userbytes_art_per'][$user];
				$bytes_per_arrays[$user] = $data['userbytes_per'][$user];
				$creationcount_arrays[$user] = $data['usercreationcount'][$user];
				$createdpages_arrays[$user] = $data['usercreatedpages'][$user];
				$pagecount_arrays[$user] = $data['userpagecount'][$user];
				$catcount_arrays[$user] = $data['usercatcount'][$user];
				$userid_arrays[$user] = $data['userid'][$user];
				$iduser_arrays[$user] = $data['iduser'][$user];
				$activityhour_arrays[$user] = $data['useractivityhour'][$user];
				$activitywday_arrays[$user] = $data['useractivitywday'][$user];
				$activityweek_arrays[$user] = $data['useractivityweek'][$user];
				$activitymonth_arrays[$user] = $data['useractivitymonth'][$user];
				$activityyear_arrays[$user] = $data['useractivityyear'][$user];
				//...
		}
		else if($_POST['select_filter'] == lang('voc.i18n_page')){
			foreach($names as $page){
				$edits_arrays[$page] = $data['pageedits'][$page];
				$edits_per_arrays[$page] = $data['pageedits_per'][$page];
				$bytes_arrays[$page] = $data['pagebytes'][$page];
				$bytes_per_arrays[$page] = $data['pagebytes_per'][$page];
				$pageusercount_arrays[$page] = $data['pageusercount'][$page];
				$activityhour_arrays[$page] = $data['pageactivityhour'][$page];
				$activitywday_arrays[$page] = $data['pageactivitywday'][$page];
				$activityweek_arrays[$page] = $data['pageactivityweek'][$page];
				$activitymonth_arrays[$page] = $data['pageactivitymonth'][$page];
				$activityyear_arrays[$page] = $data['pageactivityyear'][$page];
				if(isset($data['pageuploads'][$page])){
					$uploads_arrays[$page] = $data['pageuploads'][$page];
					$upsize_arrays[$page] = $data['pageupsize'][$page];
				}
				if(isset($data['pageaveragevalue'][$page])){
					$averagevalue_arrays[$page] = $data['pageaveragevalue'][$page];
					$grades_arrays[$page] = $data['pagegrades'][$page];
				}
				$user_arrays[$page] = $data['pageuser'][$page];
				$useredits_arrays[$page] = $data['pageuseredits'][$page];
				$usereditscount_arrays[$page] = $data['pageusereditscount'][$page];
				$userbytes_arrays[$page] = $data['pageuserbytes'][$page];
				$userbytescount_arrays[$page] = $data['pageuserbytescount'][$page];
				if (isset($data['pageuseraveragevalue'][$page])){
					$useraveragevalue_arrays[$page] = $data['pageuseraveragevalue'][$page];
					$usersd_arrays[$page] = $data['pageusersd'][$page];
				}
				if(isset($data['pagecat'][$page])) 
					$cat_arrays[$page] = $data['pagecat'][$page];
			}
			
			$edits_arrays = $this->combine_additive_array($edits_arrays);
			$bytes_arrays = $this->combine_additive_array($bytes_arrays);
			$edits_per_arrays = $this->combine_additive_array($edits_per_arrays);
			$bytes_per_arrays = $this->combine_additive_array($bytes_per_arrays);
			$pageusercount_arrays = $this->combine_additive_array($pageusercount_arrays);
			$activityhour_arrays = $this->combine_array($activityhour_arrays);
			$activitywday_arrays = $this->combine_array($activitywday_arrays);
			$activityweek_arrays = $this->combine_array($activityweek_arrays);
			$activitymonth_arrays = $this->combine_array($activitymonth_arrays);
			$activityyear_arrays = $this->combine_array($activityyear_arrays);
			$useredits_arrays = $this->combine_additive_array($useredits_arrays);
			$usereditscount_arrays = $this->combine_additive_array($usereditscount_arrays);
			$userbytes_arrays = $this->combine_additive_array($userbytes_arrays);
			$userbytescount_arrays = $this->combine_additive_array($userbytescount_arrays);
			$users = array();
			foreach($user_arrays as $user)
				$users = array_merge($users, $user);
				
			$combined_data = array('edits_arrays' => $edits_arrays, 'bytes_arrays' => $bytes_arrays, 'edits_per_arrays' => $edits_per_arrays, 'bytes_per_arrays' => $bytes_per_arrays, 'pageusercount_arrays' => $pageusercount_arrays, 'activityhour_arrays' => $activityhour_arrays, 'activitymonth_arrays' => $activitymonth_arrays, 'activitywday_arrays' => $activitywday_arrays, 'activityweek_arrays' => $activityweek_arrays, 'activityyear_arrays' => $activityyear_arrays, 'useredits_arrays' => $useredits_arrays, 'userbytes_arrays' => $userbytes_arrays, 'usereditscount_arrays' => $usereditscount_arrays, 'userbytescount_arrays' => $userbytescount_arrays, 'users' => $users);
			
			if(isset($data['pageuploads'][$page])){
				$uploads_arrays = $this->combine_additive_array($uploads_arrays);
				$upsize_arrays = $this->combine_additive_array($upsize_arrays);
				
				$combined_data[] = $uploads_arrays;
				$combined_data[] = $upsize_arrays;
			}
			if(isset($data['pageaveragevalue'][$page])){
				$averagevalue_arrays = $this->combine_additive_array($averagevalue_arrays);
				$useraveragevalue_arrays = $this->combine_additive_array($useraveragevalue_arrays);
				$usersd_arrays = $this->combine_additive_array($usersd_arrays);
				$useredits_arrays = $this->combine_additive_array($useredits_arrays);
				
				$grades = array();
				foreach($grades_arrays as $page)
					$grades = array_merge($grades, $page);
					
				$combined_data[] = $averagevalue_arrays;
				$combined_data[] = $useraveragevalue_arrays;
				$combined_data[] = $usersd_arrays;
				$combined_data[] = $useredits_arrays;
				$combined_data[] = $grades;
			}
			if(isset($data['pagecat'][$page])){
				$categories = array();
				foreach($cat_arrays as $page)
					$categories = array_merge($categories, $page);
					
				$combined_data[] = $categories;
			}
				
			
			return array_merge($combined_data, $data);
			
		}
		else if($_POST['select_filter'] == lang('voc.i18n_category')){
		
		}
		//else if($_POST['select_filter'] == lang('voc.i18n_criteria')){}
		else{	
			die('Filters_form : FATAL ERROR');
		}
	}
	
	function index(){
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
			if($_POST['combined'] == TRUE){
				$adata = $this->analisis_model->get_analisis_data($this->session->flashdata('aname'));
				$this->session->keep_flashdata('aname');
			
				$datah = array('title' => lang('voc.i18n_check_results'));
							$this->load->view('templates/header_view', $datah);
			
				$filterstrings = $this->split_string($_POST['filterstring'],',');
				
				$combined_data = $this->combine_results($filterstrings, $_POST['select_filter'], $adata);
				
				if($_POST['select_filter'] == lang('voc.i18n_user'))
					$this->load->view('content/combineduseranalisis_view', array('data' => $combined_data, 'usernames' => $filterstrings));
				else if($_POST['select_filter'] == lang('voc.i18n_page'))
					$this->load->view('content/combinedpageanalisis_view', array('data' => $combined_data, 'pagenames' => $filterstrings));
				else if($_POST['select_filter'] == lang('voc.i18n_category'))
					$this->load->view('content/combinedcatanalisis_view', array('data' => $combined_data, 'catnames' => $filterstrings));
				//else if($_POST['select_filter'] == lang('voc.i18n_criteria')){}
				else{	
					die('Filters_form : FATAL ERROR');
				}
			}
			else{
				$adata = $this->analisis_model->get_analisis_data($this->session->flashdata('aname'));
				$this->session->keep_flashdata('aname');
			
				$datah = array('title' => lang('voc.i18n_check_results'));
				$this->load->view('templates/header_view', $datah);
			
				$filterstrings = $this->split_string($_POST['filterstring'],',');
			
				if($_POST['select_filter'] == lang('voc.i18n_user'))
					foreach($filterstrings as $user){
						$this->load->view('content/useranalisis_view', array('data' => $adata, 'username' => $user));
// 						echo "<br><br>";
					}
				else if($_POST['select_filter'] == lang('voc.i18n_page'))
					foreach($filterstrings as $page){
						$this->load->view('content/pageanalisis_view', array('data' => $adata, 'pagename' => $page));
						ob_flush(); flush();
// 						echo "<br><br>";
					}
				else if($_POST['select_filter'] == lang('voc.i18n_category'))
					foreach($filterstrings as $category){
						$this->load->view('content/catanalisis_view', array('data' => $adata, 'catname' => $category));
// 						echo "<br><br>";
					}
				//else if($_POST['select_filter'] == lang('voc.i18n_criteria')){}
				else{	
					die('Filters_form : FATAL ERROR');
				}
		
				$this->load->view('templates/footer_view');
			}
		}
	}
} 