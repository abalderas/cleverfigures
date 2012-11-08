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
   	
   	function build_database(){
		
		//Creating tables
		$this->db = $this->load->database('main_db', TRUE);
		$this->db->query("CREATE TABLE user ( user_username VARCHAR(20) NOT NULL, user_password VARCHAR(50) NOT NULL, user_last_session INT(50) NOT NULL, user_realname VARCHAR(50) NOT NULL, user_email VARCHAR(30) NOT NULL, user_language VARCHAR(10) NOT NULL, user_filter VARCHAR(20) NOT NULL, KEY user_username (user_username) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
			
		$this->db->query("CREATE TABLE `wiki` ( `wiki_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `wiki_name` VARCHAR(50) NOT NULL, `wiki_connection` INT(6) NOT NULL, KEY `wiki_id` (`wiki_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
			
		$this->db->query("CREATE TABLE `color` ( `color_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `color_name` VARCHAR(50) NOT NULL, `color_connection` INT(6) NOT NULL, KEY `color_id` (`color_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
			
		$this->db->query("CREATE TABLE `connection` ( `connection_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `connection_name` VARCHAR(30) NOT NULL, `connection_server` VARCHAR(30) NOT NULL, `connection_user` VARCHAR(20) NOT NULL, `connection_password` VARCHAR(50) NOT NULL, KEY `connection_id` (`connection_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");

		$this->db->query("CREATE TABLE `analisis` ( `analisis_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `analisis_date` VARCHAR(50) NOT NULL, `analisis_wiki_name` VARCHAR(30) NOT NULL, `analisis_color_name` VARCHAR(30) NOT NULL, `analisis_date_range_a` VARCHAR(50) NOT NULL, `analisis_date_range_b` VARCHAR(50) NOT NULL, KEY `analisis_id` (`analisis_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		
		$this->db->query("CREATE TABLE `wgeneral` ( `wgen_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `wgen_total_views` INT(9) NOT NULL, `wgen_total_edits` INT(9) NOT NULL, `wgen_good_articles` INT(9) NOT NULL, `wgen_total_pages` INT(9) NOT NULL, `wgen_users` INT(9) NOT NULL, `wgen_active_users` INT(9) NOT NULL, `wgen_admins` INT(9) NOT NULL, `wgen_images` INT(9) NOT NULL, `wgen_analisis` INT(9) NOT NULL, KEY `wgen_id` (`wgen_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
			
		$this->db->query("CREATE TABLE `wimage` ( `wi_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `wi_name` VARCHAR(30) NOT NULL, `wi_user_text` TEXT NULL, `wi_timestamp` VARCHAR(50) NOT NULL, `wi_size` INT(15) NOT NULL, `wi_user` VARCHAR(20) NOT NULL, `wi_type` VARCHAR(10) NOT NULL, `wi_type_src` VARCHAR(50) NOT NULL, `wi_analisis` INT(9) NOT NULL, KEY `wi_id` (`wi_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
			
		$this->db->query("CREATE TABLE `wuser` ( `wu_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `wu_name` VARCHAR(30) NOT NULL, `wu_edits` INT(15) NOT NULL, `wu_edits_per` FLOAT(5) NOT NULL, `wu_edits_art` INT(15) NOT NULL, `wu_edits_art_per` FLOAT(5) NOT NULL, `wu_bytes` INT(15) NOT NULL, `wu_bytes_per` FLOAT(5) NOT NULL, `wu_bytes_art` INT(15) NOT NULL, `wu_bytes_art_per` FLOAT(5) NOT NULL, `wu_uploads` INT(15) NOT NULL, `wu_uploads_per` FLOAT(5) NOT NULL, `wu_neval` INT(15) NOT NULL, `wu_avg_mark` FLOAT(5) NOT NULL, `wu_replies_in` INT(15) NOT NULL, `wu_replies_out` INT(15) NOT NULL, `wu_type` VARCHAR(10) NOT NULL, `wu_type_src` VARCHAR(50) NOT NULL, `wu_analisis` INT(9) NOT NULL, KEY `wu_id` (`wu_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
			
		$this->db->query("CREATE TABLE `wpage` ( `wp_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `wp_name` VARCHAR(30) NOT NULL, `wp_namespace` INT(3) NOT NULL, `wp_edits` INT(15) NOT NULL, `wp_edits_per` FLOAT(5) NOT NULL, `wp_bytes` INT(15) NOT NULL, `wp_bytes_per` FLOAT(5) NOT NULL, `wp_visits` INT(15) NOT NULL, `wp_visits_per` FLOAT(5) NOT NULL, `wp_type` VARCHAR(10) NOT NULL, `wp_type_src` VARCHAR(50) NOT NULL, `wp_analisis` INT(9) NOT NULL, KEY `wp_id` (`wp_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		
		$this->db->query("CREATE TABLE `wcategory` ( `wc_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `wc_name` VARCHAR(30) NOT NULL, `wc_pages` INT(15) NOT NULL, `wc_pages_per` FLOAT(5) NOT NULL, `wc_edits` INT(15) NOT NULL, `wc_edits_per` FLOAT(5) NOT NULL, `wc_bytes` INT(15) NOT NULL, `wc_bytes_per` FLOAT(5) NOT NULL, `wc_visits` INT(15) NOT NULL, `wc_visits_per` FLOAT(5) NOT NULL, `wc_type` VARCHAR(10) NOT NULL, `wc_type_src` VARCHAR(50) NOT NULL, `wc_analisis` INT(9) NOT NULL, KEY `wc_id` (`wc_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
	
	
		$this->db->query("CREATE TABLE `chart` ( `ch_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `ch_title` VARCHAR(30) NOT NULL, `ch_type` VARCHAR(10) NOT NULL, KEY `ch_id` (`ch_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		
		$this->db->query("CREATE TABLE `data` ( `da_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `da_s1` FLOAT(5) NOT NULL, `da_s2` FLOAT(5) NOT NULL, `da_s3` FLOAT(5) NOT NULL, `da_s4` FLOAT(5) NOT NULL, `da_s5` FLOAT(5) NOT NULL, `da_s6` FLOAT(5) NOT NULL, `da_s7` FLOAT(5) NOT NULL, `da_s8` FLOAT(5) NOT NULL, `da_s9` FLOAT(5) NOT NULL, `da_s10` FLOAT(5) NOT NULL, KEY `da_id` (`da_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		
		$this->db->query("CREATE TABLE `user-wiki` ( `user_username` VARCHAR(20) NOT NULL, `wiki_name` VARCHAR(50) NOT NULL, KEY `user_username` (`user_username`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		
		$this->db->query("CREATE TABLE `user-color` ( `user_username` VARCHAR(20) NOT NULL, `color_name` VARCHAR(50) NOT NULL, KEY `user_username` (`user_username`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		
		$this->db->query("CREATE TABLE `user-analisis` ( `user_username` VARCHAR(20) NOT NULL, `analisis_id` INT(15) NOT NULL, KEY `user_username` (`user_username`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		
		$this->db->query("CREATE TABLE `user-filter` ( `user_username` VARCHAR(20) NOT NULL, `filter_id` VARCHAR(20) NOT NULL, KEY `user_username` (`user_username`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		
		$this->db->query("CREATE TABLE `filter` ( `ref` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `filter_id` VARCHAR(20) NOT NULL, `filter_type` VARCHAR(20) NOT NULL, `filter_name` VARCHAR(20) NOT NULL, `filter_date_a` VARCHAR(50) NOT NULL, `filter_date_b` VARCHAR(50) NOT NULL, KEY `ref` (`ref`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
   	}
}