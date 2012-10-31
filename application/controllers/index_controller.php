<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index_controller extends CI_Controller {

	function Index_controller(){
      		parent::__construct();
		$this->load->model('analisis_model');
		$this->load->model('user_analisis_model');
		$this->load->model('dbforge_model');
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
	private function first_time(){
		return $this->db->table_exists('user')?false:true;
	}
	
	function index(){
		//If first time running CleverFigures, create database and load installation
		if($this->first_time()){
			//Creating database
			$this->dbforge_model->build_database();
			
			//Loading installation
			$datah = array('title' => lang('voc.i18n_installation'));
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/installation1_view');
			$this->load->view('templates/footer_view');
		}
		//If not, check session
		else{
			//If user logged in, load teacher view
			if($this->session->userdata('username')){
				$datah = array('title' => lang('voc.i18n_teacher_view'));
				
				if($analist = $this->user_analisis_model->get_analisis_list($this->session->userdata('username'))){
				foreach($analist as $row){
					$datanalisis = $this->analisis->get_analisis_data($row->analisis_id);
					
					foreach($datanalisis as $row){
						$adate[] = $row->analisis_date;
						$awiki[] = $row->analisis_wiki_id;
						$acolor[] = $row->analisis_color_id;
						$arangea[] = $row->analisis_date_range_a;
						$arangeb[] = $row->analisis_date_range_b;
					}
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
			//If not, load login view
			else{
				if($this->db->query('select * from user')->result()){
					$datah = array('title' => lang('voc.i18n_login'));
			
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/login_view');
					$this->load->view('templates/footer_view');
				}
				else{
					$datah = array('title' => lang('voc.i18n_installation'));
			
					$this->load->view('templates/header_view', $datah);
					$this->load->view('content/installation2_view');
					$this->load->view('templates/footer_view');
				}
			}
		}
	}
} 
