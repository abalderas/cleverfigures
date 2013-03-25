<?=form_open('share')?>

<table id = 'bodytable'>
<tr>
	<th class = 'only' colspan = '2'><?=lang('voc.i18n_sharing_options')?></th>
</tr>
<?
	echo "<tr><td align = 'center' >".lang('voc.i18n_select_all')."</td><td>".form_checkbox('sharewithall', 'sharewithall', false)."</td></tr>";
	$users = $this->wiki_model->get_user_list($this->analisis_model->get_analisis_wiki($analysis_date));
	foreach($users as $user)
		echo "<tr><td align = 'center'>$user</td><td>".form_checkbox('sharewith'.$user, 'sharewith'.$user, $this->analisis_model->shared_with($analysis_date, $user))."</td></tr>";
?>
<tr>
	<th class = 'low' colspan = '2'><?=form_submit('share_submit', lang('voc.i18n_share'))?></th>
</tr>
</table>

<?=form_close()?>