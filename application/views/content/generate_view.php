<?= "<h1>".lang('i18n_analise')."</h1></br>"?>

<table>
	<tr>
		<th><?=lang('i18n_wiki')?>:</th>
		<th><?=lang('i18n_color')?></th>
		<th><?=lang('i18n_date_hour')?></th>
	</tr>
	<tr>
		<td><?= $wikiname?>:</td>
		<td><?= $colorname?>:</td>
		<td><?= $timestamp?>:</td>
	</tr>
</table>
<?= form_close() ?>