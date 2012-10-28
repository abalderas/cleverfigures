<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index_controller extends CI_Controller {

	function Index_controller(){
      		parent::__construct();
		$this->load->model('analisis_model');
   	}
   	
	private function first_time(){
		return $this->db->table_exists('u')?false:true;
	}
	
	function index(){	
		$this->lang->load('voc');
		//If first time running CleverFigures, load installation
		if($this->first_time()){
			$datah = array('title' => lang('voc.i18n_installation'));
			
			$this->load->view('templates/header_view.php', $datah);
			$this->load->view('content/installation1_view.php');
			$this->load->view('templates/footer_view.php');
		}
		//If not, check session
		else{
			//If user logged in, load teacher view
			if($this->session->userdata('user_username')){
				$datah = array('title' => lang('voc.i18n_check_results'));
				$datat = array('analisis_list' => $this->analisis_model->get_analisis_data($this->session->userdata('user_username')));
			
				$this->load->view('templates/header_view.php', $datah);
				$this->load->view('content/teacher_view.php', $datat);
				$this->load->view('templates/footer_view.php');
			}
			//If not, load login view
			else{
				$datah = array('title' => lang('voc.i18n_login'));
			
				$this->load->view('templates/header_view.php', $datah);
				$this->load->view('content/login_view.php');
				$this->load->view('templates/footer_view.php');
			}
		}
	}
} 
