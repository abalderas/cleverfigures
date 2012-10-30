<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Installation_end_form extends CI_Controller {

	function Installation_end_form(){
      		parent::__construct();
//       	$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
	function index(){
		$datah = array('title' => lang('voc.i18n_login'));
		$this->load->view('templates/header_view', $datah);
		$this->load->view('content/login_view');
		$this->load->view('templates/footer_view');
	}
}  
