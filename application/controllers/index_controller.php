<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index_controller extends CI_Controller {

	function Index_controller(){
      		parent::__construct();
		$this->load->model('analisis_model');
		$this->load->dbforge();
   	}
   	
	private function first_time(){
		return $this->db->table_exists('user')?false:true;
	}
	
	function index(){
		//If first time running CleverFigures, create database and load installation
		if($this->first_time()){
			//Creating tables
			$fields = array(
                        'user_username' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 20
                                          ),
                        'user_password' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '50'
                                          ),
                        'user_last_session' => array(
                                                 'type' =>'INT',
                                                 'constraint' => '50'
                                          ),
                        'user_realname' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '50'
                                          ),
                        'user_email' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '30'
                                          ),
                        'user_language' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '10'
                                          )
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->create_table('user');
			
			$fields = array(
                        'wiki_id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 6,
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'wiki_name' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '50'
                                          ),
                        'wiki_connection' => array(
                                                 'type' =>'INT',
                                                 'constraint' => '6'
                                          )
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->create_table('wiki');
			
			$fields = array(
                        'color_id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 6,
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'color_name' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '50'
                                          ),
                        'color_connection' => array(
                                                 'type' =>'INT',
                                                 'constraint' => '6'
                                          )
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->create_table('color');
			
			///////////////////////////////////////////////////////
			$this->dbforge->create_table('connection');
			$this->dbforge->create_table('analisis');
			$this->dbforge->create_table('wgeneral');
			$this->dbforge->create_table('filter');
			$this->dbforge->create_table('wimage');
			$this->dbforge->create_table('wuser');
			$this->dbforge->create_table('wpage');
			$this->dbforge->create_table('wcategory');
			$this->dbforge->create_table('chart');
			$this->dbforge->create_table('data');
			$this->dbforge->create_table('user-wiki');
			$this->dbforge->create_table('user-color');
			$this->dbforge->create_table('user-analisis');
			$this->dbforge->create_table('user-filter');
			
			//Loading installation
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
