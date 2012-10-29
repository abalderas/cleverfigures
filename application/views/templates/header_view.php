<html>
<head>
	<!--Title structure: CleverFigures | PageName-->
	<title> CleverFigures | <?=$title?> </title>
	<link rel="shortcut icon" type="image/x-icon" href="images/icons/favicon.ico">
	<? 
		if($this->config->item('language') == 'russian') 
			 echo link_tag('css/russianstyles.css');  
		else
			 echo link_tag('css/styles.css'); 
	?>
</head>
<body>
<table id = "menu">
	<tr>
		<? 
			if($this->session->userdata('user_username')){
				echo "<th>$this->session->userdata('user_realname')</th>";
				echo "<th>".lang('voc.i18n_configuration')."</th>";
				echo "<th>".lang('voc.i18n_view_results')."</th>";
				echo "<th".lang('voc.i18n_analise')."</th>";
				echo "<th>".lang('voc.i18n_about')."</th>";
			}
		?>
	</tr>
</table>
</br>
<div id = "wrap">
<div id= "content">