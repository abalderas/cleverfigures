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



class Dbforge_model extends CI_Model{

	//METHODS
   	function Dbforge_model(){
   	   	parent::__construct();
   	   	$this->load->dbforge();
   	}
   	
   	function build_database($dbname, $dbserver, $dbuser, $dbpassword){
		
		//Creating database
		$con = mysql_connect($dbserver,$dbuser,$dbpassword);
		if (!$con)
			die('Could not connect: ' . mysql_error());

		if (!mysql_query("CREATE DATABASE $dbname",$con))
			die ("Error creating database: " . mysql_error());

		$this->db = $this->load->database('main_db', TRUE);
		
		$this->db->query("CREATE TABLE user ( user_username VARCHAR(20) NOT NULL, user_password VARCHAR(50) NOT NULL, user_last_session INT(50) NOT NULL, user_realname VARCHAR(50) NOT NULL, user_email VARCHAR(30) NOT NULL, user_language VARCHAR(10) NOT NULL, user_filter VARCHAR(20) NOT NULL, KEY user_username (user_username) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
			
		$this->db->query("CREATE TABLE `wiki` ( `wiki_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `wiki_name` VARCHAR(50) NOT NULL, `wiki_connection` INT(6) NOT NULL, KEY `wiki_id` (`wiki_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
			
		$this->db->query("CREATE TABLE `color` ( `color_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `color_name` VARCHAR(50) NOT NULL, `color_connection` INT(6) NOT NULL, KEY `color_id` (`color_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
			
		$this->db->query("CREATE TABLE `connection` ( `connection_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `connection_name` VARCHAR(30) NOT NULL, `connection_server` VARCHAR(30) NOT NULL, `connection_user` VARCHAR(20) NOT NULL, `connection_password` VARCHAR(50) NOT NULL, KEY `connection_id` (`connection_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");

		$this->db->query("CREATE TABLE `analisis` ( `analisis_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `analisis_date` VARCHAR(50) NOT NULL, `analisis_wiki_name` VARCHAR(30) NOT NULL, `analisis_color_name` VARCHAR(30), KEY `analisis_id` (`analisis_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		
		$this->db->query("CREATE TABLE `user-wiki` ( `user_username` VARCHAR(20) NOT NULL, `wiki_name` VARCHAR(50) NOT NULL, KEY `user_username` (`user_username`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		
		$this->db->query("CREATE TABLE `user-color` ( `user_username` VARCHAR(20) NOT NULL, `color_name` VARCHAR(50) NOT NULL, KEY `user_username` (`user_username`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		
		$this->db->query("CREATE TABLE `user-analisis` ( `user_username` VARCHAR(20) NOT NULL, `analisis_date` VARCHAR(50) NOT NULL, KEY `user_username` (`user_username`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		
		$this->db->query("CREATE TABLE `user-filter` ( `user_username` VARCHAR(20) NOT NULL, `filter_id` VARCHAR(20) NOT NULL, KEY `user_username` (`user_username`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		
		$this->db->query("CREATE TABLE `filter` ( `ref` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `filter_id` VARCHAR(20) NOT NULL, `filter_user` VARCHAR(20) NOT NULL, `filter_username` VARCHAR(20) NOT NULL, `filter_page` BOOLEAN NOT NULL, `filter_pagename` VARCHAR(40) NOT NULL, `filter_category` BOOLEAN NOT NULL, `filter_categoryname` VARCHAR(40) NOT NULL, `filter_criteria` BOOLEAN NOT NULL, `filter_criterianame` VARCHAR(40) NOT NULL, `filter_date_a` VARCHAR(50) NOT NULL, `filter_date_b` VARCHAR(50) NOT NULL, KEY `ref` (`ref`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
   	}
}