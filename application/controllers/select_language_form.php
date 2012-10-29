<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Select_language_form extends CI_Controller {

	function Select_language_form(){
      		parent::__construct();
   	}
   	
	function index(){
      		$newdata = array(
                   'language'  => $this->input->post('select_language')
		);

		$this->session->set_userdata($newdata);
      		$this->lang->load('voc', $this->session->userdata('language'));
      		
		$datah = array('title' => lang('voc.i18n_installation'));
		$this->load->view('templates/header_view', $datah);
		$this->load->view('content/installation2_view');
		$this->load->view('templates/footer_view');
	}
} 