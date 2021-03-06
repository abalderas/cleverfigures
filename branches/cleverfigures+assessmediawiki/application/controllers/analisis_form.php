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



class Analisis_form extends CI_Controller {

	function Analisis_form(){
      		parent::__construct();
      		$this->load->model('wiki_model');
      		$this->load->model('color_model');
      		$this->load->model('analisis_model');
      		$this->load->model('user_model');
      		$this->load->model('csv_model');
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}

	private function standard_deviation($aValues, $bSample = false){
		$fMean = array_sum($aValues) / count($aValues);
		$fVariance = 0.0;
		foreach ($aValues as $i){
			$fVariance += pow($i - $fMean, 2);
		}
		$fVariance /= ( $bSample ? count($aValues) - 1 : count($aValues) );
		return (float) sqrt($fVariance);
	}
	
	private function extra_info($wikidata, $colordata){
		$finaldata = array();
		
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
		
		if(isset($pagegrades))
			$finaldata = array_merge($finaldata, array(
				'pagesd' => $pagesd, 
				'pageusersd' => $pageusersd, 
				'pageaveragevalue' => $pageaveragevalue, 
				'pageuseraveragevalue' => $pageuseraveragevalue, 
				'pagegrades' => $pagegrades,
				'pageusergrades' => $pageusergrades,
				'pageminvalue' => $pageminvalue,
				'pagemaxvalue' => $pagemaxvalue));
				
		if(isset($wikidata['revisioncategory']))
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
		
		if(isset($catmaxvalue))
			$finaldata = array_merge($finaldata, array(
				'catmaxvalue' => $catmaxvalue, 
				'catminvalue' => $catminvalue, 
				'cataveragevalue' => $cataveragevalue));
				
		return $finaldata;
	}
	
   	private function analise($analisis_data, $name){
		set_time_limit (0);
		
		$wiki_result = array();
		$assess_result = array();
		
		$wiki_result = $this->wiki_model->fetch($analisis_data['wiki'], $name);
		if(!$wiki_result)
			return -1;
			
		if($analisis_data['color'] != lang('voc.i18n_no_color')){
			$assess_result = $this->color_model->fetch($analisis_data['color'], $name);
			
			if(empty($assess_result))
				return -2;
				
			$extra = $this->extra_info($wiki_result, $assess_result);
			
			if(empty($extra))
				return -3;
				
			write_file("analisis/$name.dat", serialize(array_merge($wiki_result, $assess_result, $extra)));
		}
		else{
			write_file("analisis/$name.dat", serialize(array_merge($wiki_result)));
		}
		
		return 1;
   	}
   	
   	function index(){
   	
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
			if($_POST['select_wiki'] != lang('voc.i18n_no_wiki')){
				$adata = array('wiki' => $_POST['select_wiki'], 
						'color' => $_POST['select_color']
					);
				$datah = array('title' => lang('voc.i18n_analising'));
			
				$analisis = now();
				$this->session->set_flashdata(array('aname' => $analisis));
				
				echo $this->load->view('templates/header_view', $datah, true);
				echo $this->load->view('content/analising_view', $adata, true);
				ob_flush(); flush();
				
				$start = microtime(true);

				$valid_analisis = $this->analise($adata, $analisis);
				ob_flush(); flush();
				
				if($valid_analisis == -1)
					echo "<b>EMPTY WIKI. No analisis performed.</b>";
				else if($valid_analisis == -2)
					echo "<b>EMPTY QUALITATIVE DATA SOURCE. The qualitative data source that you chose is empty. Please select another.</b>";
				else if($valid_analisis == -3)
					echo "<b>INCOMPATIBLE QUALITATIVE DATA SOURCE. The qualitative data source that you chose is not compatible with the data in the wiki. Please select another.</b>";
				else{
					printf("Performed in %.02f seconds.</br>", (microtime(true)-$start));
					ob_flush(); flush();
			
					$this->analisis_model->register_analisis($_POST['select_wiki'], isset($_POST['select_color'])? $_POST['select_color'] : false, $analisis);
					$this->user_model->relate_analisis($analisis);
				
					echo "<b>Analisis saved. You can check it in \"Performed Analisis\".</b>";
				}
			}
			else{
				echo 	"<script language=\"javascript\" type=\"text/javascript\">
						alert('".lang('voc.i18n_must_choose_wiki')."');
					 </script>";
			
				$datah = array('title' => lang('voc.i18n_analise'));
			
				$colors = array(lang('voc.i18n_no_color') => lang('voc.i18n_no_color'));
				$colors = array_merge($colors, $this->color_model->get_color_list($this->session->userdata('username')));
				
				$wikis = array(lang('voc.i18n_no_wiki') => lang('voc.i18n_no_wiki')); 
				$wikis = array_merge($wikis, $this->wiki_model->get_wiki_list($this->session->userdata('username')));
				
				$adata = array('wikis' => $wikis, 'colors' => $colors, 'filters' => $filters);
				
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/analise_view', $adata);
				$this->load->view('templates/footer_view');
			}
		}
	}
}
