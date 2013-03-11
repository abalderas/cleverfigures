<?=form_open("groupcreate/crgroup/$wiki")?>

<table id = "bodytable"><tr>
	<th><?=lang('voc.i18n_create_groups')?></th><td style ="text-align:center"><?=form_label(lang('voc.i18n_group_name'), 'groupname_label')." ".form_input('groupnameinput').form_submit('groupnamesubmit', lang('voc.i18n_save_group'))?></td></tr>
</table>

<?
	if(isset($errgroupnamenotset))
		echo "<em>".lang('voc.i18n_groupname_not_set')."</em>";
	if(isset($groupcreated))
		echo "<info>".lang('voc.i18n_groupcreated')."</info>";
	if(isset($groupsaved))
		echo "<info>".lang('voc.i18n_groupsaved')."</info>";
	if(isset($groupexists))
		echo "<em>".lang('voc.i18n_groupexists')."</em>";
?>
	
<?=form_close()?>

<br>

<?=form_open("groupsave/savegroup/$wiki")?>

<table id = "bodytable">
	<?
		if(isset($users)){
			echo "<tr><th>".lang('voc.i18n_username')."</th><th>".lang('voc.i18n_group')."</th></tr>";
			echo "<tr><td colspan = '2' style = 'text-align:right;'>".form_submit('groupsubmit', lang('voc.i18n_save_selection'))."</td></tr>";
	
			$grouplist[] = 'no group';
			if($this->wiki_model->get_group_list($wiki))
				$grouplist = array_merge($grouplist, $this->wiki_model->get_group_list($wiki));
			
			foreach($grouplist as $group)
				$menulist[$group] = $group;
			
			foreach($users as $user)
				echo "<tr><td>$user</td><td>".form_dropdown($user."group", $menulist, $this->group_model->get_member_group($user))."</td></tr>";
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