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


echo img('images/logo/logotrans.png');
echo br();

echo form_open('create_database_form');
?>

</br>

<table id = "formins">
	<tr>
		<th colspan = "2" ><?=lang('voc.i18n_config_database')?></th>
	</tr>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_dbserver')?>:</td>
		<td><?= form_input('dbserver') ?></td>
	</tr>
	<?php if(form_error('dbserver')) echo "<tr><td colspan = \"2\"><em>".form_error('dbserver')."</em></td></tr>"; ?>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_dbuser')?>:</td>
		<td><?= form_input('dbuser') ?></td>
	</tr>
	<?php if(form_error('dbuser')) echo "<tr><td colspan = \"2\"><em>".form_error('dbuser')."</em></td></tr>"; ?>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_dbpassword')?>:</td>
		<td><?= form_password('dbpassword') ?></td>
	</tr>
	<?php if(form_error('dbpassword')) echo "<tr><td colspan = \"2\"><em>".form_error('dbpassword')."</em></td></tr>"; ?>
	<?php if(isset($connection_error)) echo "<tr><td colspan = \"2\"><em>$connection_error</em></td></tr>"; ?>
	<tr>
		<th class="next" colspan = "2"><?=form_submit(array('id' => 'submit', 'value' => lang('voc.i18n_next'), 'class' => 'next'));?></th>
	</tr>
</table>

<?
echo form_close();
?>
