<?php

class Analisis_model extends CI_Model{

	//ATTRIBUTES
	private $analisis_id;
	private $analisis_date;
	private $analisis_username;
	private $analisis_wiki_database_name;
	private $analisis_color_database_name;
	
   	//FUNCTIONS
   	function Analisis_model(){
   	   	parent::__construct();
   	}
   	
   	function save_analisis(){}
   	function print_analisis(){}
   	function delete_analisis(){}
   	function get_analisis_user(){}
   	function get_analisis_date(){}
}

?>  
