<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// <<Copyright 2013 Alvaro Almagro Doello>>
// 
// This file is part of CleverFigures.
// 
// CleverFigures is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// CleverFigures is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with CleverFigures.  If not, see <http://www.gnu.org/licenses/>.

class Csv extends CI_Controller {

	function Csv(){
      		parent::__construct();
      		$this->load->model('csv_model');
      		$this->load->helper('file');
      		$this->lang->load('voc', $this->session->userdata('language'));
 	}
   	
 	//DOES NOTHING, JUST CHECKS SESSION IN CASE OF FAILURE
	function index(){
		if(!$this->session->userdata('username'))
			redirect('login/loadlogin/');
	}
	
	//GET STUDENT GROUP FUNCTION
	function getcsv($arr, $name){
		$this->csv_model->createcsv($arr, $name);
		redirect("csv/$name.csv");
	}
}
