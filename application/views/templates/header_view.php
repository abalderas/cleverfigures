<!--
	INPUT:	actual_wikiname, i18n_about, i18n_analise, i18n_configuration, i18n_login, i18n_view_results
	OUTPUT: menu
-->

<div id="header">
	<!--Loads the logo image-->
	<div id = "logo"> <img src = "../../images/logo.jpg"> </div>

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