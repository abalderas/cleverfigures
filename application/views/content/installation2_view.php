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

echo form_open('create_user_form');
?>

</br>

<table id = "formins">
	<tr>
		<th colspan = "2" ><?=lang('voc.i18n_create_user')?></th>
	</tr>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_email')?>:</td>
		<td><?= form_input('email') ?></td>
	</tr>
	<?php if(form_error('email')) echo "<tr><td><em>".form_error('email')."</em></td></tr>"; ?>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_username')?>:</td>
		<td><?= form_input('username') ?></td>
	</tr>
	<?php if(form_error('username')) echo "<tr><td><em>".form_error('username')."</em></td></tr>"; ?>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_real_name')?>:</td>
		<td><?= form_input('real_name') ?></td>
	</tr>
	<?php if(form_error('real_name')) echo "<tr><td><em>".form_error('real_name')."</em></td></tr>"; ?>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_password')?>:</td>
		<td><?= form_password('password') ?></td>
	</tr>
	<?php if(form_error('password')) echo "<tr><td><em>".form_error('password')."</em></td></tr>"; ?>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_retype_password')?>:</td>
		<td><?= form_password('password_confirmation') ?></td>
	</tr>
	<?php if(form_error('password_confirmation')) echo "<tr><td><em>".form_error('password_confirmation')."</em></td></tr>"; ?>
	<tr>
		<th class="next" colspan = "2"><?=form_submit(array('id' => 'submit', 'value' => lang('voc.i18n_next'), 'class' => 'next'));?></th>
	</tr>
</table>

<?
echo form_close();
?>
