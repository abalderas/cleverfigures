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
	<link href='http://fonts.googleapis.com/css?family=Cinzel' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Donegal+One' rel='stylesheet' type='text/css'>
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
			echo "<table id = 'menu'><tr>";
			
			echo "<th class = \"user\">".$title."</th>";
			if(!$this->session->userdata('is_student') == 1)
				echo "<th>".anchor('configure', lang('voc.i18n_configuration'))."</th>";
			if(!$this->session->userdata('is_student') == 1)
				echo "<th>".anchor('teacher', lang('voc.i18n_view_analisis'))."</th>";
			else
				echo "<th>".anchor('student', lang('voc.i18n_report_list'))."</th>";
			if(!$this->session->userdata('is_student') == 1)
				echo "<th>".anchor('analise', lang('voc.i18n_analise'))."</th>";
			echo "<th>".anchor('close_session', lang('voc.i18n_close_session'));
			
			echo "</tr></table>";
		}
		
		if($title == lang('voc.i18n_check_results')){
			echo "<table id = 'chartselector'>
					<td style = 'width:85%;'>
						<table>
						<tr>
							<td>".form_checkbox(lang('voc.i18n_edits'),lang('voc.i18n_edits'),true,'onClick = "tooglethis(\'chartfinaledits\')"').lang('voc.i18n_edits')."</td>
							<td>".form_checkbox(lang('voc.i18n_bytes'),lang('voc.i18n_bytes'),true,'onClick = "tooglethis(\'chartfinalbytes\')"').lang('voc.i18n_bytes')."</td>
							<td>".form_checkbox(lang('voc.i18n_pages'),lang('voc.i18n_pages'),true,'onClick = "tooglethis(\'chartfinalpages\')"').lang('voc.i18n_pages')."</td>
							<td>".form_checkbox(lang('voc.i18n_users'),lang('voc.i18n_users'),true,'onClick = "tooglethis(\'chartfinalusers\')"').lang('voc.i18n_users')."</td>
						</tr>
						<tr>
							<td>".form_checkbox(lang('voc.i18n_edits_evolution'), lang('voc.i18n_edits_evolution'), true, 'onClick = "tooglethis(\'charttotaledits\')"').lang('voc.i18n_edits_evolution')."</td>
							<td>".form_checkbox(lang('voc.i18n_content_evolution'),lang('voc.i18n_content_evolution'),true,'onClick = "tooglethis(\'charttotalbytes\')"').lang('voc.i18n_content_evolution')."</td>
							<td>".form_checkbox(lang('voc.i18n_pages'),lang('voc.i18n_pages'),true,'onClick = "tooglethis(\'charttotalpages\')"').lang('voc.i18n_pages')."</td>
							<td>".form_checkbox(lang('voc.i18n_users'),lang('voc.i18n_users'),true,'onClick = "tooglethis(\'charttotalusers\')"').lang('voc.i18n_users')."</td>
						</tr>
						<tr>
							<td>".form_checkbox(lang('voc.i18n_categories'),lang('voc.i18n_categories'),true,'onClick = "tooglethis(\'charttotalcategories\')"').lang('voc.i18n_categories')."</td>
							<td>".form_checkbox(lang('voc.i18n_activity_hour'),lang('voc.i18n_activity_hour'),true,'onClick = "tooglethis(\'charttotalactivityhour\')"').lang('voc.i18n_activity_hour')."</td>
							<td>".form_checkbox(lang('voc.i18n_activity_wday'),lang('voc.i18n_activity_wday'),true,'onClick = "tooglethis(\'charttotalactivitywday\')"').lang('voc.i18n_activity_wday')."</td>
							<td>".form_checkbox(lang('voc.i18n_activity_week'),lang('voc.i18n_activity_week'),true,'onClick = "tooglethis(\'charttotalactivityweek\')"').lang('voc.i18n_activity_week')."</td>
						</tr>
						<tr>
							<td>".form_checkbox(lang('voc.i18n_uploads'),lang('voc.i18n_uploads'),true,'onClick = "tooglethis(\'charttotaluploads\')"').lang('voc.i18n_uploads')."</td>
							<td>".form_checkbox(lang('voc.i18n_upsize'),lang('voc.i18n_upsize'),true,'onClick = "tooglethis(\'charttotalupsize\')"').lang('voc.i18n_upsize')."</td>
							<td>".form_checkbox(lang('voc.i18n_average_quality'),lang('voc.i18n_average_quality'),true,'onClick = "tooglethis(\'charttotalquality\')"').lang('voc.i18n_average_quality')."</td>
							<td>".form_checkbox(lang('voc.i18n_bytesxquality'),lang('voc.i18n_bytesxquality'),true,'onClick = "tooglethis(\'charttotalbytesxquality\')"').lang('voc.i18n_bytesxquality')."</td>
						</tr>
						<tr>
							<td>".form_checkbox(lang('voc.i18n_hourquality'),lang('voc.i18n_hourquality'),true,'onClick = "tooglethis(\'qualityhourchart\')"').lang('voc.i18n_hourquality')."</td>
							<td>".form_checkbox(lang('voc.i18n_users'),lang('voc.i18n_users'),lang('voc.i18n_users'),true,'onClick = "tooglethis(\'user_table\')"').lang('voc.i18n_users')."</td>
							<td>".form_checkbox(lang('voc.i18n_pages'),lang('voc.i18n_pages'),true,'onClick = "tooglethis(\'pages_table\')"').lang('voc.i18n_pages')."</td>
							<td>".form_checkbox(lang('voc.i18n_categories'),lang('voc.i18n_categories'),true,'onClick = "tooglethis(\'categories_table\')"').lang('voc.i18n_categories')."</td>
						</tr>
						</table>
					</td>
					<td>
						<table>
						<tr>
							<th>".lang('voc.i18n_chart_selector')."</th>
						</tr>
						</table>
					</td>
				</table>";
		}?>

<div id = "wrap">
<br>