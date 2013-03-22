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
class Analisis_form extends CI_Controller {

	function Analisis_form(){
      		parent::__construct();
      		$this->load->model('wiki_model');
      		$this->load->model('color_model');
      		$this->load->model('analisis_model');
      		$this->load->model('user_model');
      		$this->lang->load('voc', $this->session->userdata('language'));
   	}

	//STANDARD DEVIATION FUNCTION
	private function standard_deviation($aValues, $bSample = false){
		$fMean = array_sum($aValues) / count($aValues);
		$fVariance = 0.0;
		foreach ($aValues as $i){
			$fVariance += pow($i - $fMean, 2);
		}
		$fVariance /= ( $bSample ? count($aValues) - 1 : count($aValues) );
		return (float) sqrt($fVariance);
	}
	
	//EXTRA INFO FUNCTION: GETS COMBINED NUMERICAL AND QUALITATIVE INFORMATION
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
	
	//ANALISE FUNCTION
   	private function analise($analisis_data, $name){
   	
		//SET SERVER ANSWER TIME TO UNLIMITED TO ALLOW LONG ANALYSIS
		set_time_limit (0);
		
		//SETTING UP ARRAYS
		$wiki_result = array();
		$assess_result = array();
		
		//GETTING DATA FROM THE WIKI
		$wiki_result = $this->wiki_model->fetch($analisis_data['wiki'], $name);
		
		//IF NO DATA, END AND RETURN -1 ERROR
		if(!$wiki_result)
			return -1;
			
		//IF COLOR SET
		if($analisis_data['color'] != lang('voc.i18n_no_color')){
			
			//GETTING COLOR DATA
			$assess_result = $this->color_model->fetch($analisis_data['color'], $name);
			
			//IF EMPTY RESULT, ERROR
			if(empty($assess_result))
				return -2;
			
			//GETTING EXTRA INFO
			$extra = $this->extra_info($wiki_result, $assess_result);
			
			//IF EMPTY RESULT, ERROR
			if(empty($extra))
				return -3;
			
			//WRITE ANALYSIS RESULT TO FILE INCLUDING COLOR AND EXTRA INFO
			write_file("analisis/$name.dat", serialize(array_merge($wiki_result, $assess_result, $extra)));
		}
		else{
			//WRITE ANALYSIS RESULT TO FILE
			write_file("analisis/$name.dat", serialize(array_merge($wiki_result)));
		}
		
		//RETURN 1, SUCCESS
		return 1;
   	}
   	
   	//MAIN FUNCTION
   	function index(){
		
		//IF SESSION EXPIRED
		if(!$this->session->userdata('username')){
			
			//CREATE HEADER ARRAY
			$datah = array('title' => lang('voc.i18n_login'));
			
			//LOAD LOGIN VIEW
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
			//IF WIKI SELECTED
			if($_POST['select_wiki'] != lang('voc.i18n_no_wiki')){
				
				//CREATE ANALYSIS DATA ARRAY
				$adata = array('wiki' => $_POST['select_wiki'], 
						'color' => $_POST['select_color']
					);
					
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_analising'));
				
				//ANALYSIS NAME IS DATETIME
				$analisis = now();
				
				//INCLUDYING ANALYSIS NAME IN THE COOKIE
				$this->session->set_flashdata(array('aname' => $analisis));
				
				//SHOWING ANALISING VIEW
				echo $this->load->view('templates/header_view', $datah, true);
				echo $this->load->view('content/analising_view', $adata, true);
				ob_flush(); flush();
				
				//START CHRONOMETER
				$start = microtime(true);
				
				//ANALISE
				$valid_analisis = $this->analise($adata, $analisis);
				ob_flush(); flush();
				
				//IN CASE OF ERRORS, PRINT ERRORS
				if($valid_analisis == -1)
					echo "<b>EMPTY WIKI. No analisis performed.</b>";
				else if($valid_analisis == -2)
					echo "<b>EMPTY QUALITATIVE DATA SOURCE. The qualitative data source that you chose is empty. Please select another.</b>";
				else if($valid_analisis == -3)
					echo "<b>INCOMPATIBLE QUALITATIVE DATA SOURCE. The qualitative data source that you chose is not compatible with the data in the wiki. Please select another.</b>";
				else{
					//PRINT TOTAL TIME
					printf("Performed in %.02f seconds.</br>", (microtime(true)-$start));
					ob_flush(); flush();
				
					//RECORD THE ANALYSIS IN THE DB
					$this->analisis_model->register_analisis($_POST['select_wiki'], isset($_POST['select_color'])? $_POST['select_color'] : false, $analisis);
					
					//RELATE ANALYSIS TO THE USER
					$this->user_model->relate_analisis($analisis);
				
					//FINAL MESSAGE
					echo "<b>Analisis saved. You can check it in \"Performed Analisis\".</b>";
				}
			}
			else{
				//SHOW MESSAGE IF NO WIKI SELECTED
				echo 	"<script language=\"javascript\" type=\"text/javascript\">
						alert('".lang('voc.i18n_must_choose_wiki')."');
					 </script>";
			
				//CREATE HEADER ARRAY
				$datah = array('title' => lang('voc.i18n_analise_view'));
			
				//CREATE COLOR LIST ARRAY
				$colors = array(lang('voc.i18n_no_color') => lang('voc.i18n_no_color'));
				$colors = array_merge($colors, $this->color_model->get_color_list($this->session->userdata('username')));
				
				//CREATE WIKI LIST ARRAY
				$wikis = array(lang('voc.i18n_no_wiki') => lang('voc.i18n_no_wiki')); 
				$wikis = array_merge($wikis, $this->wiki_model->get_wiki_list($this->session->userdata('username')));
				
				//CREATE DATA ARRAY
				$adata = array('wikis' => $wikis, 'colors' => $colors, 'filters' => $filters);
				
				//LOAD ANALISE VIEW
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/analise_view', $adata);
				$this->load->view('templates/footer_view');
			}
		}
	}
}