CREATE DATABASE IF NOT EXISTS cleverfigures;

use cleverfigures;

CREATE TABLE IF NOT EXISTS `user` (
  `user_username` VARCHAR(20) NOT NULL,
  `user_password` VARCHAR(50) NOT NULL,
  `user_last_session` INT(50) NOT NULL,
  `user_realname` VARCHAR(50) NOT NULL,
  `user_email` VARCHAR(30) NOT NULL,
  `user_language` VARCHAR(10) NOT NULL,
  `user_is_admin` BOOLEAN NOT NULL,
  `user_high_contrast` BOOLEAN NOT NULL
);

CREATE TABLE IF NOT EXISTS `wiki` (
  `wiki_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `wiki_name` VARCHAR(50) NOT NULL,
  `wiki_baseurl` VARCHAR(70),
  `wiki_connection` INT(6) NOT NULL,
  `wiki_quality_function` VARCHAR(100) NOT NULL,
  KEY(`wiki_id`)
);

CREATE TABLE IF NOT EXISTS `color` (
  `color_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `color_name` VARCHAR(50) NOT NULL,
  `color_connection` INT(6) NOT NULL,
  KEY(`color_id`)
);

CREATE TABLE IF NOT EXISTS `connection` (
  `connection_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection_name` VARCHAR(30) NOT NULL,
  `connection_server` VARCHAR(30) NOT NULL,
  `connection_user` VARCHAR(20) NOT NULL,
  `connection_password` VARCHAR(50) NOT NULL,
  KEY(`connection_id`)
);

CREATE TABLE IF NOT EXISTS `analisis` (
  `analisis_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `analisis_date` VARCHAR(50) NOT NULL,
  `analisis_wiki_name` VARCHAR(30) NOT NULL,
  `analisis_color_name` VARCHAR(30),
  KEY(`analisis_id`)
);

CREATE TABLE IF NOT EXISTS `user-wiki` (
  `user_username` VARCHAR(20) NOT NULL,
  `wiki_name` VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS `user-color` (
  `user_username` VARCHAR(20) NOT NULL,
  `color_name` VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS `user-analisis` (
  `user_username` VARCHAR(20) NOT NULL,
  `analisis_date` VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS `groups` (
  `group_name` VARCHAR(50) NOT NULL,
  `wiki_name` VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS `member` (
  `member_name` VARCHAR(20) NOT NULL,
  `member_group` VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS `student-analysis` (
  `student_name` VARCHAR(30) NOT NULL,
  `analisis_date` VARCHAR(50) NOT NULL
);
