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
	<link href='http://fonts.googleapis.com/css?family=Playball&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Cinzel' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Donegal+One' rel='stylesheet' type='text/css'>
	<?= link_tag('css/styles.css')?>

</head>
<body>
<? 
	$logged = $this->session->userdata('username');
	if($logged == '') echo "<!--";
?>
<table id = "menu">
	<tr>
		<?
			echo "<th class = \"user\"><un>".$title."</un></th>";
			echo "<th>".anchor('configure', lang('voc.i18n_configuration'))."</th>";
			if($this->session->userdata('is_student') == 1)
				echo "<th>".anchor('student', lang('voc.i18n_view_reports'))."</th>";
			else
				echo "<th>".anchor('teacher', lang('voc.i18n_view_analisis'))."</th>";
			echo "<th>".anchor('analise', lang('voc.i18n_analise'))."</th>";
			echo "<th>".anchor('close_session', lang('voc.i18n_close_session'));
		?>
	</tr>
</table>
<? 
	if($logged == '') echo "-->";
?>
<div id = "wrap">
<br>