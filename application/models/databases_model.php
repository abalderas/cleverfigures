<!--FUNCTIONS
	function new_user(){}
   	function fetch_wiki_data(){}
   	function fetch_color_data(){}
   	function save_data(){}
   	function set_color_database_type(){}
-->


<?php

class Databases_model extends CI_Model{

   	function Databases_model(){
   	   	parent::__construct();
   	   	/*[1]*/
   	   	/*[2]*/
   	}
   
   	// user functions
   	function new_user($username, $password, $realname, $email){}
   	function user_logged_off($username){}
   	function delete_user($username){}
   	
   	//fetching functions
   	function fetch_wiki_data(){}
   	function fetch_color_data($database_type){}
   	
   	//analisis functions
   	function save_analisis(){}
   	function view_analisis($id){}
   	
   	//database configuration functions
   	function set_color_database_type($database_type){}
   
   	/*[3]*/
}

?> 

<!--[1] TO_DO: you have to load all the databases, 
but you have no idea of their names until you specify 
how they'll be installed in the database.php file. 
Must be done through another model-->

<!--[2] TO_DO: must add helpers-->

<!--[3] TO_DO: add parameters to created functions and maybe add more functions-->