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


<html>
<head>
	<!--Title structure: CleverFigures | PageName-->
	<title> CleverFigures | <?=$title?> </title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="images/icons/favicon.ico">
	<? 
		if($this->session->userdata('language') == 'russian') 
			 echo link_tag('css/russianstyles.css');  
		else
			 echo link_tag('css/styles.css'); 
	?>
</head>
<body>
<table id = "menu">
	<tr>
		<? 
			$logged = $this->session->userdata('username');
			if($logged != ''){
				echo "<th>".$this->session->userdata('realname')."</th>";
				echo "<th>".lang('voc.i18n_configuration')."</th>";
				echo "<th>".lang('voc.i18n_view_analisis')."</th>";
				echo "<th>".lang('voc.i18n_analise')."</th>";
				echo "<th>".lang('voc.i18n_about')."</th>";
				echo "<th>".lang('voc.i18n_close_session')."</th>";
			}
		?>
	</tr>
</table>
</br>
<div id = "wrap">
<div id= "content">