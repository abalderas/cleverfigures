<!--
	INPUT: i18n_installation_intro, i18n_create_user, i18n_email, i18n_username, i18n_password, i18n_next
	OUTPUT: create_user_form(email, username, password, next)
-->

<?

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
