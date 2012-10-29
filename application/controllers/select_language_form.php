<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Select_language_form extends CI_Controller {

	function Select_language_form(){
      		parent::__construct();
   	}
   	
	function index(){	
		if($this->input->post('select_language')){
			$this->config->set_item('language', $this->input->post('select_language'));
			
			$datah = array('title' => lang('voc.i18n_installation'));
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/installation2_view');
			$this->load->view('templates/footer_view');
		}
	}
} 