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

class Create_user_form extends CI_Controller {

	function Create_user_form(){
      		parent::__construct();
      		$this->load->model('user_model');
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
	function index(){
		$this->form_validation->set_rules('username', lang('voc.i18n_username'), 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('real_name', lang('voc.i18n_real_name'), 'required|xss_clean');
		$this->form_validation->set_rules('password', lang('voc.i18n_password'), 'required|matches[password_confirmation]|xss_clean');
		$this->form_validation->set_rules('password_confirmation', lang('voc.i18n_password_confirmation'), 'required|xss_clean');
		$this->form_validation->set_rules('email', lang('voc.i18n_email'), 'required|valid_email|xss_clean');

		if ($this->form_validation->run() == FALSE){
			$datah = array('title' => lang('voc.i18n_installation'));
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/installation2_view');
			$this->load->view('templates/footer_view');
		}
		else{
			$result = $this->db->query("select * from user")->result();
			if($result){
				$this->user_model->new_user($this->input->post('username'), $this->input->post('password'), now(), $this->input->post('real_name'), $this->input->post('email'), $this->input->post('is_admin'));
				$datah = array('title' => lang('voc.i18n_configuration'));
				
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/configuration_view');
				$this->load->view('templates/footer_view');
			}
			else{
				$this->user_model->new_user($this->input->post('username'), $this->input->post('password'), now(), $this->input->post('real_name'), $this->input->post('email'), true);
				$datah = array('title' => lang('voc.i18n_installation'));
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/installation3_view');
				$this->load->view('templates/footer_view');
			}
		}
	}
}  
