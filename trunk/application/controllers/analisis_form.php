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
      		$this->load->model('filter_model');
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
		foreach(array_keys($wikidata['revisionpage']) as $key){ //páginas
			foreach(array_keys($wikidata['revisionpage'][$key]) as $revision){ //revisiones
				if(isset($wikidata['revisionpage'][$key][$revision]) and isset($colordata['totalmark'][$revision])){
					$pagenvalues[$key] = 0;
					$pagevaluesum[$key] = 0;
				}
			}
		}
		
		foreach(array_keys($wikidata['revisionpage']) as $key){
			foreach(array_keys($wikidata['revisionpage'][$key]) as $revision){
				if(isset($wikidata['revisionpage'][$key][$revision]) and isset($colordata['totalmark'][$revision])){
					$pagegrades[$key][$revision] = $colordata['totalmark'][$revision];
					
					$pageaveragevalue[$key][$revision] = array_sum($pagegrades[$key]) / count($pagegrades[$key]);
					$pagesd[$key][$revision] = $this->standard_deviation($pagegrades[$key]);
					$pageminvalue[$key][$revision] = min($pagegrades[$key]);
					$pagemaxvalue[$key][$revision] = max($pagegrades[$key]);
				}
			}
		}
		
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
		
		return array(
			'pagesd' => $pagesd, 
			'pageaveragevalue' => $pageaveragevalue, 
			'pageminvalue' => $pageminvalue,
			'pagemaxvalue' => $pagemaxvalue,
			'catmaxvalue' => $catmaxvalue, 
			'catminvalue' => $catminvalue, 
			'cataveragevalue' => $cataveragevalue
		);
	}
	
   	private function analise($analisis_data, $name){
		set_time_limit (0);
		
		$wiki_result = array();
		$assess_result = array();
		
		$wiki_result = $this->wiki_model->fetch($analisis_data['wiki'], $name);
		if($analisis_data['color'] != lang('voc.i18n_no_color')){
			$assess_result = $this->color_model->fetch($analisis_data['color'], $name);
			$extra = $this->extra_info($wiki_result, $assess_result);
			
			write_file("analisis/$name.dat", serialize(array_merge($wiki_result, $assess_result, $extra)));
		}
		else{
			write_file("analisis/$name.dat", serialize(array_merge($wiki_result)));
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
			if($_POST['select_wiki'] != lang('voc.i18n_no_wiki')){
				$adata = array('wiki' => $_POST['select_wiki'], 
						'color' => $_POST['select_color']
					);
				$datah = array('title' => lang('voc.i18n_analising'));
			
				echo $this->load->view('templates/header_view', $datah, true);
				echo $this->load->view('content/analising_view', $adata, true);
				ob_flush(); flush();
				
				$start = microtime(true);
			
				$analisis = now();
				$this->analise($adata, $analisis);
			
				ob_flush(); flush();
			
				printf("Performed in %.02f seconds.</br>", (microtime(true)-$start));
				ob_flush(); flush();
			
				$this->analisis_model->register_analisis($_POST['select_wiki'], isset($_POST['select_color'])? $_POST['select_color'] : false, $analisis);
				$this->user_model->relate_analisis($analisis);
			
				echo "<b>Analisis saved. You can view the results ".anchor('teacher',lang('voc.i18n_here')).".</b>";
				echo $this->load->view('templates/footer_view', true);
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