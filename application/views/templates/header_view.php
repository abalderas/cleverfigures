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
<div id="header">
	<!--Displays user menu-->
	<div id = "menu">
	<table cellspacing="0" cellpadding="5" border="0">
	<tr>
		<? 
			if($this->session->userdata('user_username')){
				echo "<td>$this->session->userdata('user_realname')</td>";
				echo "<td>".lang('i18n_configuration')."</td>";
				echo "<td>".lang('i18n_view_results')."</td>";
				echo "<td".lang('i18n_analise')."</td>";
				echo "<td>".lang('i18n_about')."</td>";
			}
			else{
				echo "<td>".lang('i18n_login')."</td>";
				echo "<td>".lang('i18n_about')."</td>";
			}
		?>
	</tr>
	</table>
	</div>
	
</div>