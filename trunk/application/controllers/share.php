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


//REPORT CONTROLLER
class Share extends CI_Controller {

	function Share(){
      		parent::__construct();
      		$this->load->model('wiki_model');
      		$this->load->model('analisis_model');
      		$this->lang->load('voc', $this->session->userdata('language'));
   	}

	function index(){
		//IF SESSION EXPIRED
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
			$wikiname = $_POST['wiki_name'];
			$users = $this->wiki_model->get_user_list($wikiname);
			
			foreach($users as $user){
				if(isset($_POST['sharewith'.$user])){
					$this->analisis_model->share($_POST['analysis_date_backup'], $user);
				}
				else{
					if($this->analisis_model->shared_with($_POST['analysis_date_backup'], $user)){
						$this->analisis_model->unshare($_POST['analysis_date_backup'], $user);
					}
				}
			}
			
			redirect('teacher');
		}
	}
}