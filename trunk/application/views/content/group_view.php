<?=form_open('groupcreate')?>

<table id = "bodytable"><tr>
	<th><?=lang('voc.i18n_create_groups')?></th><td style ="text-align:center"><?=form_label(lang('voc.i18n_group_name'), 'groupname_label')." ".form_input('groupnameinput').form_submit('groupnameinput', lang('voc.i18n_save_group'))?></td></tr>
</table>

<?=form_close()?>

<br>

<?=form_open('groupsave')?>

<table id = "bodytable">
	<?
		if(isset($users)){
			echo "<tr><th>".lang('voc.i18n_username')."</th><th>".lang('voc.i18n_group')."</th></tr>";
			echo "<tr><td colspan = '2' style = 'text-align:right;'>".form_submit('groupsubmit', lang('voc.i18n_save_selection'))."</td></tr>";
			if(isset($errgroupnamenotset))
				echo "<tr><td colspan = '2' color = 'red'>".lang('voc.i18n_groupname_not_set')."</td></tr>";
			if(isset($groupcreated))
				echo "<tr><td colspan = '2' color = 'green'>".lang('voc.i18n_groupcreated')."</td></tr>";
			foreach($users as $user)
				echo "<tr><td>$user</td><td>".form_input($user."group")."</td></tr>";
			echo "<tr><td colspan = '3' style = 'text-align:right;'>".form_submit('groupsubmit', lang('voc.i18n_save_selection'))."</td></tr>";
		}
		else{
			echo "<tr><th>".lang('voc.i18n_username')."</th><th>".lang('voc.i18n_group')."</th></tr>";
			echo "<tr><td colspan = '2'>".lang('voc.i18n_no_users')."</td></tr>";
			echo "<tr><td colspan = '2' style = 'text-align:right;'>".form_submit('groupsubmit', lang('voc.i18n_save_selection'))."</td></tr>";
		}
			
	?>
</table>

<?=form_close()?>