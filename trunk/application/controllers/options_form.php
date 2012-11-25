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



class Options_form extends CI_Controller {

	function Options_form(){
      		parent::__construct();
      		$this->load->model('wiki_model');
      		$this->load->model('color_model');
      		$this->load->model('filter_model');
      		$this->load->model('analisis_model');
      		$this->load->model('user_model');
      		$this->load->model('csv_model');
// 		$this->lang->load('voc', $this->session->userdata('language'));
   	}
   	
//    	function get_main_tables($analisis){
// 		
// 		//USER TABLE
// 		
// 		$str = "<table id = \"bodytable\">
// 		<tr>
// 			<th>User</th>
// 			<th>Real Name</th>
// 			<th>Editions</th>
// 			<th>%</th>
// 			<th>Editions in articles</th>
// 			<th>%</th>
// 			<th>Bytes</th>
// 			<th>%</th>
// 			<th>Bytes in articles</th>
// 			<th>%</th>
// 			<th>Uploads</th>
// 			<th>%</th>
// 			<th>Created Pages</th>
// 		</tr>";
// 		
// 		$ids = $this->csv_model->csv_to_array($analisis, 'iduser');
// 		$rnames = $this->csv_model->csv_to_array($analisis, 'userrealname');
// 		$edits = $this->csv_model->csv_to_array($analisis, 'useredits');
// 		$edits_per = $this->csv_model->csv_to_array($analisis, 'useredits_per');
// 		$edits_art = $this->csv_model->csv_to_array($analisis, 'useredits_art');
// 		$edits_art_per = $this->csv_model->csv_to_array($analisis, 'useredits_art_per');
// 		$bytes = $this->csv_model->csv_to_array($analisis, 'userbytes');
// 		$bytes_per = $this->csv_model->csv_to_array($analisis, 'userbytes_per');
// 		$uploads = $this->csv_model->csv_to_array($analisis, 'useruploads');
// 		$uploads_per = $this->csv_model->csv_to_array($analisis, 'useruploads_per');
// 		$createdp = $this->csv_model->csv_to_array($analisis, 'usercreatedpages');
// 		$bytes_art = $this->csv_model->csv_to_array($analisis, 'userbytes_art');
// 		$bytes_art_per = $this->csv_model->csv_to_array($analisis, 'userbytes_art_per');
// 		
// 		foreach(array_keys($ids) as $key){
// 		
// 			$userdata
// 		
// 			$str .= "<tr>";
// 			$str .= "<td>".$key."</td>";
// 			$str .= "<td>".$rnames[$key]."</td>";
// 			$str .= "<td>".end($edits[$key])."</td>";
// 			$str .= "<td>".end($edits_per[$key])."</td>";
// 			$str .= "<td>".end($edits_art[$key])."</td>";
// 			$str .= "<td>".end($edits_art_per[$key])."</td>";
// 			$str .= "<td>".end($bytes[$key])."</td>";
// 			$str .= "<td>".end($bytes_per[$key])."</td>";
// 			$str .= "<td>".end($bytes_art[$key])."</td>";
// 			$str .= "<td>".end($bytes_art_per[$key])."</td>";
// 			$str .= "<td>".end($uploads[$key])."</td>";
// 			$str .= "<td>".end($uploads_per[$key])."</td>";
// 			$str .= "<td>".$createdp[$key]."</td>";
// 			$str .= "</tr>";
// 		}
// 		
// 		$str .= "</table>";
// 		
// 		
// 		//PAGE TABLE
// 		
// 		
// 		//CATEGORY TABLE
// 		
// 		return "hey";
// 	}
	
   	function index(){
   	
		if(!$this->session->userdata('username')){
			$datah = array('title' => lang('voc.i18n_login'));
			
			$this->load->view('templates/header_view', $datah);
			$this->load->view('content/login_view');
			$this->load->view('templates/footer_view');
		}
		else{
		
			if(isset($_POST['delete'])){
				$datah = array('title' => lang('voc.i18n_delete_analisis'));
				
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/delete_analisis_view', array('analisis' => $_POST['aname']));
				$this->load->view('templates/footer_view');
			}
			else if(isset($_POST['view'])){
				$datah = array('title' => lang('voc.i18n_check_results'));
				
				$adata = $this->analisis_model->get_analisis_data($_POST['aname']);
				
				$this->load->view('templates/header_view', $datah);
				$this->load->view('content/check_results_view', array('data' => $adata));
				$this->load->view('templates/footer_view');
			}
			else die('FATAL ERROR');
		}
	}
}