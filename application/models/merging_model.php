 
<?php

//AVAILABLE METHODS


class Merging_model extends CI_Model{
	
	
   	function Merging_model(){
   		//Llamamos al constructor heredado.
   	   	parent::__construct();
   	   	
   	   	//Cargamos helpers
   	   	$this->load->helper('date');
   	   	
   	   	//Cargamos models necesarios
   	   	$ci =& get_instance();
		$ci->load->model('connection_model');
   	}
   	
   	function general_fetch(){
		///////////////////////////////////////////////////////
   	}
}

?> 
