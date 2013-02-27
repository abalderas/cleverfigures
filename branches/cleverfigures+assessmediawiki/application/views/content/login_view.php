<!--
<<Copyright 2013 Alvaro Almagro Doello>>

This file is part of CleverFigures.

CleverFigures is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

CleverFigures is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with CleverFigures.  If not, see <http://www.gnu.org/licenses/>.
-->


<!--Login form. Gets login information-->
<table id = "maintable">
<tr>
	<td>
		<?
			echo img('images/logo/logotrans.png');
		?>
	</td>
	<td>
		<?= form_open('login_form') ?>
		<table id = "formins">
			<tr>
				<td><?=lang('voc.i18n_username')?></td>
				<td><?= form_input('username') ?></td>
			</tr>
			<tr>
				<td><?=lang('voc.i18n_password')?></td>
				<td><?= form_password('password') ?></td>
			</tr>
			
			<? if(isset($error)) echo "<tr><td colspan=\"2\"><em>".lang('voc.i18n_incorrect_login')."</em><td></tr>";?>
			<? if(isset($emailsent)) echo "<tr><td colspan=\"2\"><em>".lang('voc.i18n_email_sent')."</em><td></tr>";?>
			
			<tr>
				<th colspan="2">
					<?= form_submit('submit', lang('voc.i18n_submit')) ?>
					<? //echo form_submit('forgot', lang('voc.i18n_forgot_login_data')) ?>
				</th>
			</tr>
		</table>
		<?= form_close() ?>
	</td>
</tr>
</table>