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


echo form_open('add_color');
?>

</br>

<table id = "variabletable">
	<tr>
		<th  class = 'only' colspan = "2" ><?=lang('voc.i18n_config_database')?></th>
	</tr>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_color_name')?>:</td>
		<td><?= form_input('color_name') ?></td>
	</tr>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_dbname')?>:</td>
		<td><?= form_input('dbname') ?></td>
	</tr>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_dbserver')?>:</td>
		<td><?= form_input('dbserver') ?></td>
	</tr>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_dbuser')?>:</td>
		<td><?= form_input('dbuser') ?></td>
	</tr>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_dbpassword')?>:</td>
		<td><?= form_password('dbpassword') ?></td>
	</tr>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_wiki')?>:</td>
      		<td><?=form_dropdown('related_wiki', $wikis, 0);?></td>
	</tr>
	<tr>
		<th  class = 'low' colspan = "2"><?=form_submit(array('id' => 'submit', 'value' => lang('voc.i18n_save')));?></th>
	</tr>
</table>

<?
echo form_close();
?>

<?if(isset($connection_error)) { ?><div id="message_box" class="error"><p><?=$connection_error?></p></div><? } ?>
<?if(isset($fields_error)) { ?><div id="message_box" class="error"><p><?=$fields_error?></p></div><? } ?>
