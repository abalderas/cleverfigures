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



class Configuration_form extends CI_Controller {

	function Configuration_form(){
      		parent::__construct();
      		$this->load->database();
//       	$this->load->model('filter_model');
      		$this->load->model('user_model');
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
	function index(){
	
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
		
			if($this->input->post('add_wiki')){
				$datah = array('title' => lang('voc.i18n_add_wiki'));
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/add_wiki_view');
				$this->load->view('templates/footer_view');
			}
				
			else if($this->input->post('add_color')){
				$datah = array('title' => lang('voc.i18n_add_color'));
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/add_color_view');
				$this->load->view('templates/footer_view');
			}
			
			else if($this->input->post('add_user')){
				$datah = array('title' => lang('voc.i18n_add_user'));
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/installation2_view');
				$this->load->view('templates/footer_view');
			}
				
			else if($this->input->post('save_conf')){
				$lang = $_POST['select_language'];
				$user = $this->session->userdata('username');
				
				$high_contrast = (isset($_POST['high_contrast'])) ? true : false ;
				$this->db->query("UPDATE user SET user_language='$lang', user_high_contrast = '$high_contrast' WHERE user_username = '$user'");
				$this->session->set_userdata(array('language' => $lang, 'high_contrast' => $high_contrast));
				
				$datah = array('title' => lang('voc.i18n_configuration'));
				
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/configuration_view', array('admin' => $this->session->userdata('is_admin')));
				$this->load->view('templates/footer_view');
			}
			
			else if($this->input->post('cancel_conf')){
				$datah = array('title' => lang('voc.i18n_configuration'));
				
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/teacher_view');
				$this->load->view('templates/footer_view');
			}
		}
	}
}  
