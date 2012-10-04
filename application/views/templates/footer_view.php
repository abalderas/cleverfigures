<!--
	INPUT: i18n_license, wikiname, i18n_contact
	OUTPUT: 
-->

<div id="footer">
	<!--Shows logo image-->
	<div id = "logo"> <img src = "../../images/logo.jpg" alt = "Logo"></img> </div>

	<!--Loads information with the name of the analised wiki and the license-->
	<div id = "info"> 
		<div id = "wiki"> CleverFigures : <?=$wikiname?> </div> 
		<div id = "contact"> <a href = "mailto:alvaro.almagrodoello@alum.uca.es"> <?=$i18n_contact?> </a> </div>
		<div id = "license"> <?=$i18n_license?> </div>
	</div>
	
	<!--Shows misc-->
	<div id = "misc"><!--[1]--></div>
</div>

<!--[1] TO DO: w3c, etc!!-->