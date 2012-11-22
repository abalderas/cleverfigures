<?php

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



//AVAILABLE METHODS
// 	new_connection($server, $name, $user, $password)
//    	connect($id)
//    	get_query($link, $query_string)
//    	delete_connection($id)
   	
class Csv_model extends CI_Model{
	
	//constructor
   	function Csv_model(){
   	   	parent::__construct();
   	   	$this->load->database();
   	   	$this->load->helper('file');
   	}
   	
   	/**
	* Generatting CSV formatted string from an array.
	* By Sergey Gurevich.
	*/
	
	function array_to_csv_dim0($analisis, $name, $var)
	{
		$str = $var;
		write_file("analisis/$analisis/$name.csv", $str);
	}
	
	function array_to_csv_dim1($analisis, $name, $array, $Xlabel, $Ylabel)
	{
		$str = "$Xlabel, $Ylabel\n";
		foreach(array_keys($array) as $key)
			$str .= $key . "," . $array[$key] . "\n";
		write_file("analisis/$analisis/$name.csv", $str);
	}
	
	function array_to_csv_dim2($analisis, $name, $array, $Xlabel, $Ylabel)
	{
		foreach(array_keys($array) as $key){
			$this->array_to_csv_dim1($analisis, $name."_".$key, $array[$key], $Xlabel, $Ylabel);
		}
	}
	
	function csv_to_array($analisis, $filename){
		$data = read_file("$analisis/$filename.csv");
		return str_getcsv($data, ',', '');
	}
	
	function get_main_tables($analisis){
		
		//USER TABLE
		
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
// 		$ids = 
// 		
// 		foreach(array_keys($wiki['iduser']) as $key){
// 		
// 			$userdata
// 		
// 			$str .= "<tr>";
// 			$str .= "<td>".$key."</td>";
// 			$str .= "<td>".$wiki['userrealname'][$key]."</td>";
// 			$str .= "<td>".end($wiki['useredits'][$key])."</td>";
// 			$str .= "<td>".end($wiki['useredits_per'][$key])."</td>";
// 			$str .= "<td>".end($wiki['useredits_art'][$key])."</td>";
// 			$str .= "<td>".end($wiki['useredits_art_per'][$key])."</td>";
// 			$str .= "<td>".end($wiki['userbytes'][$key])."</td>";
// 			$str .= "<td>".end($wiki['userbytes_per'][$key])."</td>";
// 			$str .= "<td>".end($wiki['userbytes_art'][$key])."</td>";
// 			$str .= "<td>".end($wiki['userbytes_art_per'][$key])."</td>";
// 			$str .= "<td>".end($wiki['useruploads'][$key])."</td>";
// 			$str .= "<td>".end($wiki['useruploads_per'][$key])."</td>";
// 			$str .= "<td>".$wiki['usercreationcount'][$key]."</td>";
// 			$str .= "</tr>";
// 		}
// 		
// 		echo "</table>";
		
		
		//PAGE TABLE
		
		
		//CATEGORY TABLE
		
		return "hey";
	}
}