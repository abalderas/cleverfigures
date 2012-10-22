<html>
<!--
	INPUT:	i18n_title, header, footer, content
	OUTPUT: 
-->
<head>
	<!--Title structure: CleverFigures | PageName-->
	<title> CleverFigures | <?=$i18n_title?> </title>
	<link rel="shortcut icon" type="image/x-icon" href="images/icons/favicon.ico">
	<? 
		if($this->session->userdata('user_language' == 'russian')) 
			echo '<link rel="stylesheet" type="text/css" href="css/russianstyles.css" media="screen" />';
		else
			echo '<link rel="stylesheet" type="text/css" href="css/styles.css" media="screen" />';
	?>
</head>
<body>
	<!--Loads the header-->
	<?=$header?>
	<div id = "content">
		<!--Loads title-->
		<h2><?=$i18n_title?></h2>
	
		<!--Loads content. Completely generated by controller-->
		<?=$content?>
	</div>
	<!--Loads footer-->
	<?=$footer?>
</body>
</html>  