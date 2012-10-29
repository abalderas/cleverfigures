<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Create_user_form extends CI_Controller {

	function Create_user_form(){
      		parent::__construct();
      		$this->load->model('user_model');
   	}
   	
	function index(){		
		$this->form_validation->set_rules('username', lang('voc.i18n_username'), 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('real_name', lang('voc.i18n_real_name'), 'required|xss_clean');
		$this->form_validation->set_rules('password', lang('voc.i18n_password'), 'required|matches[password_confirmation]|xss_clean');
		$this->form_validation->set_rules('password_confirmation', lang('voc.i18n_password_confirmation'), 'required|xss_clean');
		$this->form_validation->set_rules('email', lang('voc.i18n_email'), 'required|valid_email|xss_clean');

		if ($this->form_validation->run() == FALSE)
		{
			$datah = array('title' => lang('voc.i18n_installation'));
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/installation2_view');
			$this->load->view('templates/footer_view');
		}
		else
		{
			$this->user_model->new_user($this->input->post('username'), $this->input->post('password'), now(), $this->input->post('real_name'), $this->input->post('email'));
			$datah = array('title' => lang('voc.i18n_installation'));
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/installation3_view');
			$this->load->view('templates/footer_view');
		}
	}
}  
