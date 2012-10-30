<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_form extends CI_Controller {

	function Login_form(){
      		parent::__construct();
      		$this->load->model('user_model');
      		$this->load->model('analisis_model');
//       	$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
	function index(){
		if($this->user_model->login($this->input->post('username'), $this->input->post('password'))){
			$datah = array('title' => lang('voc.i18n_teacher_view'));
			
			if($datanalisis = $this->analisis_model->get_analisis_data($this->session->userdata('user_username'))){
				foreach($datanalisis as $row){
					$adate[] = $row->analisis_date;
					$awiki[] = $row->analisis_wiki_id;
					$acolor[] = $row->analisis_color_id;
					$arangea[] = $row->analisis_date_range_a;
					$arangeb[] = $row->analisis_date_range_b;
				}
				$datat = array('adate' => $adate, 'awiki' => $awiki, 'acolor' => $acolor, 'arangea' => $arangea, 'arangeb' => $arangeb);
			
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/teacher_view', $datat);
				$this->load->view('templates/footer_view');
			}
			else{
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/teacher_view');
				$this->load->view('templates/footer_view');
			}
		}
		else{
			$datah = array('title' => lang('voc.i18n_login'));
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
			echo "<em>".lang('voc.i18n_incorrect_login')."</em>";
		}
	}
}  
