<?php

class Configuration_model extends CI_Model{

   	function Configuration_model(){
   	   	parent::__construct();
   	}
   	function set_wiki_database($database_name){}
   	function set_color_database($database_name){}
   	function set_configuration_date($configuration_date){}
   	function set_configuration_language($configuration_language){}
   	function reset_configuration($configuration_id){}
}

?>  
