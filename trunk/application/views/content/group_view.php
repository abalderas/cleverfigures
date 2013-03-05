<?=form_open('groupsave')?>

<table id = "bodytable">
	<?
		if(isset($users)){
			echo "<tr><th>".lang('voc.i18n_username')."</th><th>".lang('voc.i18n_group')."</th></tr>";
			echo "<tr><td colspan = '2' style = 'text-align:right;'>".form_submit('groupsubmit', lang('voc.i18n_save_groups'))."</td></tr>";
			foreach($users as $user)
				echo "<tr><td>$user</td><td>".form_input($user."group")."</td></tr>";
			echo "<tr><td colspan = '3' style = 'text-align:right;'>".form_submit('groupsubmit', lang('voc.i18n_save_groups'))."</td></tr>";
		}
		else{
			echo "<tr><th>".lang('voc.i18n_username')."</th><th>".lang('voc.i18n_group')."</th></tr>";
			echo "<tr><td colspan = '2'>".lang('voc.i18n_no_users')."</td></tr>";
			echo "<tr><td colspan = '2' style = 'text-align:right;'>".form_submit('groupsubmit', lang('voc.i18n_save_groups'))."</td></tr>";
		}
			
	?>
</table>

<?=form_close()?>