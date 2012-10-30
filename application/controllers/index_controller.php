<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index_controller extends CI_Controller {

	function Index_controller(){
      		parent::__construct();
		$this->load->model('analisis_model');
		$this->load->dbforge();
// 		$this->lang->load('voc', $this->session->userdata('language'));
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
			$this->dbforge->add_key('user_username');
			$this->dbforge->create_table('user');
			
			$fields = array(
                        'wiki_id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9,
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE,
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
			$this->dbforge->add_key('wiki_id');
			$this->dbforge->create_table('wiki');
			
			$fields = array(
                        'color_id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9,
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
			$this->dbforge->add_key('color_id');
			$this->dbforge->create_table('color');
			
			$fields = array(
                        'connection_id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9,
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'connection_name' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '30'
                                          ),
                        'connection_server' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '30'
                                          ),
                        'connection_user' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '20'
                                          ),
                        'connection_password' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '50'
                                          )
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('connection_id');
			$this->dbforge->create_table('connection');
			
			$fields = array(
                        'analisis_id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9,
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'analisis_date' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '30'
                                          ),
                        'analisis_username' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '20'
                                          ),
                        'analisis_wiki_id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9
                                          ),
                        'analisis_color_id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9
                                          ),
                        'analisis_date_range_a' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '50'
                                          ),
                        'analisis_date_range_b' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '50'
                                          )               
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('analisis_id');
			$this->dbforge->create_table('analisis');
			
			$fields = array(
                        'wgen_id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9,
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'wgen_total_views' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9
                                          ),
                        'wgen_total_edits' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9
                                          ),
                        'wgen_good_articles' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9
                                          ),
                        'wgen_total_pages' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9
                                          ),
                        'wgen_users' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9
                                          ),
                        'wgen_active_users' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9
                                          ), 
                        'wgen_admins' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9
                                          ),
                        'wgen_images' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9
                                          ),
                        'wgen_analisis' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9
                                          )                  
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('wgen_id');
			$this->dbforge->create_table('wgeneral');
			
			$fields = array(
                        'wi_id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9,
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'wi_name' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '30'
                                          ),
                        'wi_user_text' => array(
                                                 'type' =>'TEXT',
                                                 'NULL' => TRUE
                                          ),
                        'wi_timestamp' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '50'
                                          ),
                        'wi_size' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 15
                                          ),
                        'wi_user' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '20'
                                          ),
                        'wi_type' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '10'
                                          ), 
                        'wi_type_src' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '50'
                                          ),
                        'wi_analisis' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9
                                          )                
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('wi_id');
			$this->dbforge->create_table('wimage');
			
			$fields = array(
                        'wu_id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9,
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'wu_name' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '30'
                                          ),
                        'wu_edits' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 15
                                          ),
                        'wu_edits_per' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),
                        'wu_edits_art' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 15
                                          ),
                        'wu_edits_art_per' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),                  
                        'wu_bytes' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 15
                                          ),
                        'wu_bytes_per' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ), 
                        'wu_bytes_art' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 15
                                          ),
                        'wu_bytes_art_per' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),
                        'wu_uploads' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 15
                                          ),
                        'wu_uploads_per' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),
                        'wu_neval' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 15
                                          ),
                        'wu_avg_mark' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),
                        'wu_replies_in' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 15
                                          ),
                        'wu_replies_out' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 15
                                          ),
                        'wu_type' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '10'
                                          ), 
                        'wu_type_src' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '50'
                                          ),
                        'wu_analisis' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9
                                          )                  
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('wu_id');
			$this->dbforge->create_table('wuser');
			
			$fields = array(
                        'wp_id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9,
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'wp_name' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '30'
                                          ),
                        'wp_namespace' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 3
                                          ),                  
                        'wp_edits' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 15
                                          ),
                        'wp_edits_per' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),                 
                        'wp_bytes' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 15
                                          ),
                        'wp_bytes_per' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ), 
                        'wp_visits' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 15
                                          ),
                        'wp_visits_per' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),
                        'wp_type' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '10'
                                          ), 
                        'wp_type_src' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '50'
                                          ),
                        'wp_analisis' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9
                                          )                  
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('wp_id');
			$this->dbforge->create_table('wpage');
			
			$fields = array(
                        'wc_id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9,
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'wc_name' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '30'
                                          ),
                        'wc_pages' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 15
                                          ),  
                        'wc_pages_per' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),                   
                        'wc_edits' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 15
                                          ),
                        'wc_edits_per' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),                 
                        'wc_bytes' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 15
                                          ),
                        'wc_bytes_per' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ), 
                        'wc_visits' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 15
                                          ),
                        'wc_visits_per' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),
                        'wc_type' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '10'
                                          ), 
                        'wc_type_src' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '50'
                                          ),
                        'wc_analisis' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9
                                          )                  
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('wc_id');
			$this->dbforge->create_table('wcategory');
			
			$fields = array(
                        'ch_id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9,
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'ch_title' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '30'
                                          ),
                        'ch_type' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '10'
                                          )        
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('ch_id');
			$this->dbforge->create_table('chart');
			
			$fields = array(
                        'da_id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 9,
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'da_s1' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ), 
                        'da_s2' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),
                        'da_s3' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),
                        'da_s4' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),
                        'da_s5' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),
                        'da_s6' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),
                        'da_s7' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),
                        'da_s8' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),
                        'da_s9' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          ),
                        'da_s10' => array(
                                                 'type' => 'FLOAT',
                                                 'constraint' => 5
                                          )
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('da_id');
			$this->dbforge->create_table('data');
			
			$fields = array(
                        'user_name' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '20'
                                          ),
                        'wiki_name' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '50'
                                          )
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('user_name');
			$this->dbforge->create_table('user-wiki');
			
			$fields = array(
                        'user_name' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '20'
                                          ),
                        'color_name' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '50'
                                          )
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('user_name');
			$this->dbforge->create_table('user-color');
			
			$fields = array(
                        'user_name' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => '20'
                                          ),
                        'analisis_id' => array(
                                                 'type' =>'INT',
                                                 'constraint' => 15
                                          )
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('user_name');
			$this->dbforge->create_table('user-analisis');
			
// 			$fields = array(
//                         'user_name' => array(
//                                                  'type' =>'VARCHAR',
//                                                  'constraint' => '20'
//                                           ),
//                         'filter_id' => array(
//                                                  'type' =>'INT',
//                                                  'constraint' => 15
//                                           )
// 			);
// 			$this->dbforge->add_field($fields);
// 			$this->dbforge->add_key('user_name');
// 			$this->dbforge->create_table('user-filter');
			//$this->dbforge->create_table('filter');
			
			//Loading installation
			$datah = array('title' => lang('voc.i18n_installation'));
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/installation1_view');
			$this->load->view('templates/footer_view');
		}
		//If not, check session
		else{
			//If user logged in, load teacher view
			if($this->session->userdata('user_username')){
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
