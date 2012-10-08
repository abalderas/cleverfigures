<?php
class User_model extends CI_Model{

	//ATTIRBUTES
	private $username;
	private $password;
	private $last_session;
	private $realname;
	private $nanalisis;
	private $email;
	private $configuration;
	
	//METHODS
   	function Users_model(){
   	   	parent::__construct();
   	   	$this->load->helper('date');
   	   	
   	   	$username = 'default';
   	   	$password = 'default';
		$last_session = 0;
		$realname = 'default';
		$nanalisis = 0;
		$email = 'default';
		$configuration = 'default';
   	}
   	
   	function set_user_data($id, $name, $pass, 0, $email_address){
   		$this->load->model('Configuration_model');
   		$this->username = $id;
   		$this->password = $pass;
   		$this->last_session = now();
   		$this->realname = $name;
   		$this->nanalisis = 0;
   		$this->email = $email_address;
   		$this->configuration = $id;
   		
   		$conf = new Configuration_model();
   		$conf->set_configuration_language('english');
   		$conf->set_configuration_date(now());
   		$conf->set_wiki_database();
   		$conf->set_color_database();
   		
   	}
   	function save_user(){}
   	function save_last_session(){}
   	function login(){}
   	function delete_user(){}
}

?>  
