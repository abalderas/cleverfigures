CREATE DATABASE cleverfigures;

use cleverfigures;

CREATE TABLE `user` ( user_username VARCHAR(20) NOT NULL, user_password VARCHAR(50) NOT NULL, user_last_session INT(50) NOT NULL, user_realname VARCHAR(50) NOT NULL, user_email VARCHAR(30) NOT NULL, user_language VARCHAR(10) NOT NULL, user_filter VARCHAR(20) NOT NULL, user_is_admin BOOLEAN NOT NULL, user_high_contrast BOOLEAN NOT NULL, KEY user_username (user_username) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
CREATE TABLE `wiki` ( `wiki_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `wiki_name` VARCHAR(50) NOT NULL, `wiki_baseurl` VARCHAR(70), `wiki_connection` INT(6) NOT NULL, `wiki_quality_function` VARCHAR(100) NOT NULL KEY `wiki_id` (`wiki_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
CREATE TABLE `color` ( `color_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `color_name` VARCHAR(50) NOT NULL, `color_connection` INT(6) NOT NULL, KEY `color_id` (`color_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
CREATE TABLE `connection` ( `connection_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `connection_name` VARCHAR(30) NOT NULL, `connection_server` VARCHAR(30) NOT NULL, `connection_user` VARCHAR(20) NOT NULL, `connection_password` VARCHAR(50) NOT NULL, KEY `connection_id` (`connection_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
CREATE TABLE `analisis` ( `analisis_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT, `analisis_date` VARCHAR(50) NOT NULL, `analisis_wiki_name` VARCHAR(30) NOT NULL, `analisis_color_name` VARCHAR(30), KEY `analisis_id` (`analisis_id`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
CREATE TABLE `user-wiki` ( `user_username` VARCHAR(20) NOT NULL, `wiki_name` VARCHAR(50) NOT NULL, KEY `user_username` (`user_username`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
CREATE TABLE `user-color` ( `user_username` VARCHAR(20) NOT NULL, `color_name` VARCHAR(50) NOT NULL, KEY `user_username` (`user_username`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
CREATE TABLE `user-analisis` ( `user_username` VARCHAR(20) NOT NULL, `analisis_date` VARCHAR(50) NOT NULL, KEY `user_username` (`user_username`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
CREATE TABLE `groups` ( `group_name` VARCHAR(50) NOT NULL, `wiki_name` VARCHAR(50) NOT NULL, KEY `group_name` (`group_name`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
CREATE TABLE `member` ( `member_name` VARCHAR(20) NOT NULL, `member_group` VARCHAR(50) NOT NULL, KEY `member_name` (`member_name`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
CREATE TABLE `student-analysis` ( `student_name` VARCHAR(30) NOT NULL, `analisis_date` VARCHAR(50) NOT NULL, KEY `student_name` (`student_name`) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
