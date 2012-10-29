<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Installation_end_form extends CI_Controller {

	function Installation_end_form(){
      		parent::__construct();
      		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
	function index(){
		$this->load->view('templates/header_view');
		$this->load->view('content/login_view');
		$this->load->view('templates/footer_view');
	}
}  
