<?=form_open('parameters')?>

<table id = 'bodytable'>
<tr>
	<th class = 'only' colspan = '2'><?=lang('voc.i18n_parameters')?></th>
</tr>
<tr>
	<td><?=lang('voc.i18n_quality_function')?></td><td><?=form_textarea(array('id' => 'function', 'name' => 'function', 'value' => '', 'maxlength' => '100', 'rows' => '2', 'cols' => '80')/*, $this->parameter_model->get_quality_function($wiki)*/)?></td>
</tr>
<tr>
	<th class = 'low' colspan = '2'><?=form_submit('save_parameters', lang('voc.i18n_save'))?></th>
</tr>
</table>

<?=form_close()?>