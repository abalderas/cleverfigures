<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Select_language_form extends CI_Controller {

	function Select_language_form(){
      		parent::__construct();
   	}
   	
	function index(){	
		$this->form_validation->set_rules('select_language_form', lang('i18n_language'), 'required');
		$this->form_validation->set_error_delimiters('<em>','</em>');

		if($this->input->post('select_language_form')){
			if($this->form_validation->run()){
				/////////////////////////////////////////// establecer idioma
			}
		}
	}
} 