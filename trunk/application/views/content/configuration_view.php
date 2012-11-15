<?

// <<Copyright 2013 Alvaro Almagro Doello>>
// 
// This file is part of CleverFigures.
// 
// CleverFigures is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// CleverFigures is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with CleverFigures.  If not, see <http://www.gnu.org/licenses/>.

echo "<h1>".lang('voc.i18n_configuration')."</h1></br>";

echo form_open('configuration_form');

	$languages = array(
           	//'spanish'  => lang('voc.i18n_spanish'),
                'english'    => lang('voc.i18n_english')
                //'french'   => lang('voc.i18n_french'),
                //'russian' => lang('voc.i18n_russian'),
                //'german' => lang('voc.i18n_german'),
             );
?>

<table id = "bodytable">
<tr>
	<th colspan = "2"><?=lang('voc.i18n_language');?></th>
</tr>
<tr>
	<td><?=form_label(lang('voc.i18n_select_language'), 'select_language');?></td>
	<td><?=form_dropdown('select_language', $languages, 'english');?></td>
</tr>
<tr>
	<th colspan = "2"><?=lang('voc.i18n_filters');?></th>
</tr>
<tr>
	<td><?=form_label(lang('voc.i18n_select_filter'), 'select_filter');?></td>
	<td><?=form_dropdown('select_filter', $filters, $userdefaultfilter);?><?=form_submit('add_filter', lang('voc.i18n_add_filter'));?></td>
</tr>
<tr>
	<th colspan = "2"><?=lang('voc.i18n_data_source');?></th>
</tr>
<tr>
	<td><?=form_label(lang('voc.i18n_add_wiki'), 'add_wiki');?></td>
	<td><?=form_submit('add_wiki', lang('voc.i18n_add_wiki'));?></td>
</tr>
<tr>
	<td><?=form_label(lang('voc.i18n_add_color'), 'add_color');?></td>
	<td><?=form_submit('add_color', lang('voc.i18n_add_color'));?></td>
</tr>
<tr>
	<th colspan = "2">
	<?=form_submit(array('name' => 'save_conf', 'value' => lang('voc.i18n_save_conf'), 'class' => 'next'));?>
	<?=form_submit(array('name' => 'cancel_conf', 'value' => lang('voc.i18n_cancel_conf'), 'class' => 'next'));?>
	</th>
</tr>
</table>

<?=form_close();?>