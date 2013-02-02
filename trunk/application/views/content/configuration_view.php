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
	<td><?=form_dropdown('select_language', $languages, 'english');?><?=form_submit(array('name' => 'save_conf', 'value' => lang('voc.i18n_save_conf'), 'class' => 'next'));?></td>
</tr>
</table>
<br>
<table id = "bodytable">
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
</table>
<br>
<? if(!isset($admin) || !$admin) echo "<!--" ?>
<table id = "bodytable">
<tr>
	<th colspan = "2"><?=lang('voc.i18n_users');?></th>
</tr>
<tr>
	<td><?=form_label(lang('voc.i18n_add_user'), 'add_user');?></td>
	<td><?=form_submit('add_user', lang('voc.i18n_add_user'));?></td>
</tr>
<!--<tr>
	<td><?//=form_label(lang('voc.i18n_erase_user'), 'erase_user');?></td>
	<td><?//=form_submit('erase_user', lang('voc.i18n_erase_user'));?></td>
</tr>-->
</table>
<? if(!isset($admin) || !$admin) echo "-->" ?>

<?=form_close();?>

<div id ="footer">
	<table>
	<tr>
		<th><?=safe_mailto('alvaro.almagrodoello@alum.uca.es', lang('voc.i18n_contact'))?></th>
		<th><?=anchor('license/gpl.txt',lang('voc.i18n_license'))?></th>
		<th><?=anchor('about',lang('voc.i18n_about'))?></th>
		</tr>
	</table>
</div>