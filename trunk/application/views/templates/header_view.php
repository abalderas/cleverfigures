<!DOCTYPE HTML>

<html>
<!--
<<Copyright 2013 Alvaro Almagro Doello>>

This file is part of CleverFigures.

CleverFigures is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

CleverFigures is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with CleverFigures.  If not, see <http://www.gnu.org/licenses/>.
-->

<head>
	<!--Title structure: CleverFigures | PageName-->
	<title> CleverFigures | <?=$title?> </title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="images/icons/favicon.ico">
	<link href='http://fonts.googleapis.com/css?family=Playball&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Titillium+Web&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Cinzel' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Donegal+One' rel='stylesheet' type='text/css'>
    	<?=link_tag('css/ex.css');?>
	<?
		if($this->session->userdata('high_contrast')) 
			echo link_tag('css/acstyles.css');
		else 
			echo link_tag('css/styles.css');
	?>
	<script src="http://yui.yahooapis.com/3.8.0/build/yui/yui-min.js"></script>
	<script type='text/javascript' src='http://www.google.com/jsapi'></script>

</head>
<body>
	<?
		if($this->session->userdata('username')){
			echo "<table id = 'menu-left' class='menufonts'><tr><th>";	
			if(!$this->session->userdata('is_student') == 1)
				echo anchor('configure', lang('voc.i18n_configuration'));
			if(!$this->session->userdata('is_student') == 1)
				echo " | " . anchor('teacher', lang('voc.i18n_view_analisis'));
			else
				echo " | " . anchor('student', lang('voc.i18n_report_list'));
			if(!$this->session->userdata('is_student') == 1)
				echo " | " . anchor('analise', lang('voc.i18n_analise'));
			echo "</th></tr></table>";
			echo "<table id='menu-right' class='menufonts'><tr><th>";
				echo anchor('close_session', lang('voc.i18n_close_session'));
			echo "</th></tr></table>";
		}
	?>

<div id="horizontal-line"></div>
<div id = "wrap">
<br>
