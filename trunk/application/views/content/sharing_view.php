<?
	echo form_open('share');
	echo form_hidden('analysis_date_backup', $analysis_date);
	echo form_hidden('wiki_name', $this->analisis_model->get_analisis_wiki($analysis_date));
?>
<script language="javascript">
	function checkall(){
		var checkboxes = new Array(); 
		checkboxes = document.getElementsByTagName('input');
		
		for (var i=0; i<checkboxes.length; i++){
			if (checkboxes[i].type == 'checkbox'){
				checkboxes[i].checked = true;
			}
		}
	}
	
	function uncheckall(){
		var checkboxes = new Array(); 
		checkboxes = document.getElementsByTagName('input');
		
		for (var i=0; i<checkboxes.length; i++){
			if (checkboxes[i].type == 'checkbox'){
				checkboxes[i].checked = false;
			}
		}
	}
</script>

<table id = 'bodytable'>
<tr>
	<th class = 'only' colspan = '2'><?=lang('voc.i18n_sharing_options')?></th>
</tr>
<?
	echo "<tr><td colspan = '2' align = 'right'>".form_button(array('id' => 'sharewithall', 'name' => 'sharewithall', 'content' => lang('voc.i18n_check_all'), 'onClick' => 'checkall()')).
	form_button(array('id' => 'sharewithnoone', 'name' => 'sharewithnoone', 'content' => lang('voc.i18n_uncheck_all'), 'onClick' => 'uncheckall()'))."</td></tr>";
	
	$users = $this->wiki_model->get_user_list($this->analisis_model->get_analisis_wiki($analysis_date));
	foreach($users as $user)
		echo "<tr><td align = 'center'>$user</td><td>".form_checkbox('sharewith'.$user, 'sharewith'.$user, $this->analisis_model->shared_with($analysis_date, $user))."</td></tr>";
?>
<tr>
	<th class = 'low' colspan = '2'><?=form_submit('share_submit', lang('voc.i18n_share'))?></th>
</tr>
</table>

<?=form_close()?>