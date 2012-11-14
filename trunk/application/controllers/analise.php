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



class Analise extends CI_Controller {

	function Analise(){
      		parent::__construct();
      		$this->load->model('wiki_model');
      		$this->load->model('color_model');
      		$this->load->model('filter_model');
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
   	function index(){
		$datah = array('title' => lang('voc.i18n_analise'));
		
		$colors = array(0 => lang('voc.i18n_no_color'));
		$colors = array_merge($colors, $this->color_model->get_color_list($this->session->userdata('username')));
		
		$filters = array(lang('voc.i18n_no_filter') => lang('voc.i18n_no_filter'));
		$filters = array_merge($filters, $this->filter_model->get_filter_list($this->session->userdata('username')));
		
		$wikis = array(lang('voc.i18n_no_wiki') => lang('voc.i18n_no_wiki')); 
		$wikis = array_merge($wikis, $this->wiki_model->get_wiki_list($this->session->userdata('username')));
		
		$adata = array('wikis' => $wikis, 'colors' => $colors, 'filters' => $filters);
		
		$this->load->view('templates/header_view', $datah);
		$this->load->view('content/analise_view', $adata);
		$this->load->view('templates/footer_view');
	}
}