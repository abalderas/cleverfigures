<html>
<head>
	<!--Title structure: CleverFigures | PageName-->
	<title> CleverFigures | <?=$title?> </title>
	<link rel="shortcut icon" type="image/x-icon" href="images/icons/favicon.ico">
	<? 
		if($this->session->userdata('user_language' == 'russian')) 
			echo '<link rel="stylesheet" type="text/css" href="css/russianstyles.css" media="screen" />';
		else
			echo '<link rel="stylesheet" type="text/css" href="css/styles.css" media="screen" />';
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
			else{
				echo "<th>".lang('voc.i18n_login')."</th>";
				echo "<th>".lang('voc.i18n_about')."</th>";
			}
		?>
	</tr>
</table>
</br>