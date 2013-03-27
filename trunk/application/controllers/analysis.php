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


//ANALYSIS FORM CONTROLLER
class Analysis extends CI_Controller {

	function Analysis(){
      		parent::__construct();
      		$this->load->model('wiki_model');
      		$this->load->model('color_model');
      		$this->load->model('analisis_model');
      		$this->load->model('user_model');
      		$this->lang->load('voc', $this->session->userdata('language'));
   	}
	
	private function extra_info($wikidata, $colordata){
		
		//CREATING EMPTY ARRAY TO PUT THE DATA IN
		$finaldata = array();
		
		//GETTING COMBINED INFO...
		foreach(array_keys($wikidata['revisionpage']) as $key){
			foreach(array_keys($wikidata['revisionpage'][$key]) as $revision){
				if(isset($wikidata['revisionpage'][$key][$revision]) and isset($colordata['totalmark'][$revision])){
					$pagegrades[$key][$revision] = $colordata['totalmark'][$revision];
					$pageusergrades[$key][$wikidata['revisionuser'][$revision]][$revision] = $colordata['totalmark'][$revision];
					
					$pageaveragevalue[$key][$revision] = array_sum($pagegrades[$key]) / count($pagegrades[$key]);
					$pageuseraveragevalue[$key][$wikidata['revisionuser'][$revision]][$revision] = 
						array_sum($pageusergrades[$key][$wikidata['revisionuser'][$revision]]) / count($pageusergrades[$key][$wikidata['revisionuser'][$revision]]);
					$pagesd[$key][$revision] = $this->standard_deviation($pagegrades[$key]);
					$pageusersd[$key][$wikidata['revisionuser'][$revision]][$revision] = $this->standard_deviation($pageusergrades[$key][$wikidata['revisionuser'][$revision]]);
					$pageminvalue[$key][$revision] = min($pagegrades[$key]);
					$pagemaxvalue[$key][$revision] = max($pagegrades[$key]);
				}
			}
		}
		
		//IF GRADES SET
		if(isset($pagegrades))
		
			//ADD QUALITATIVE DATA TO THE ARRAY
			$finaldata = array_merge($finaldata, array(
				'pagesd' => $pagesd, 
				'pageusersd' => $pageusersd, 
				'pageaveragevalue' => $pageaveragevalue, 
				'pageuseraveragevalue' => $pageuseraveragevalue, 
				'pagegrades' => $pagegrades,
				'pageusergrades' => $pageusergrades,
				'pageminvalue' => $pageminvalue,
				'pagemaxvalue' => $pagemaxvalue));
				
		//IF THERE ARE CATEGORIES
		if(isset($wikidata['revisioncategory']))
			//COMBINE THEIR DATA
			foreach(array_keys($wikidata['revisioncategory']) as $key){
				$catmaxvalue[$key] = 0;
				$catminvalue[$key] = 10;
				$catnvalues[$key] = 0;
				$catvaluesum[$key] = 0;
				
				foreach(array_keys($wikidata['revisioncategory'][$key]) as $revision){
					if(isset($wikidata['revisioncategory'][$key][$revision]) and isset($colordata['totalmark'][$revision])){
						if($colordata['totalmark'][$revision] > $catmaxvalue[$key])
							$catmaxvalue[$key] = $colordata['totalmark'][$revision];
						if($colordata['totalmark'][$revision] < $catminvalue[$key])
							$catminvalue[$key] = $colordata['totalmark'][$revision];
							
						$catnvalues[$key] += 1;
						$catvaluesum[$key] += $colordata['totalmark'][$revision];
						$cataveragevalue[$key][$revision] = $catvaluesum[$key] / $catnvalues[$key];
					}
				}
			}
		
		//ADD CATEGORIES DATA TO THE FINAL ARRAY
		if(isset($catmaxvalue))
			$finaldata = array_merge($finaldata, array(
				'catmaxvalue' => $catmaxvalue, 
				'catminvalue' => $catminvalue, 
				'cataveragevalue' => $cataveragevalue));
				
		//RETURN FINAL ARRAY
		return $finaldata;
	}
	
	//SHARE FUNCTION
   	function share($analysis_date){
		$this->load->view('templates/header_view', array('title' => lang('voc.i18n_sharing_view')));
		$this->load->view('content/sharing_view', array('analysis_date' => $analysis_date));
		$this->load->view('templates/footer_view');
   	}
   	
   	//MAIN FUNCTION
   	function index(){
		
		//IF SESSION EXPIRED
		if(!$this->session->userdata('username')){
			redirect('login/loadlogin/');
		}
	}
}