<!--
	OUTPUT: login_form(username, password)
-->

<!--Login form. Gets login information-->
<?
echo img('images/logo/logotrans.png');
echo br();
?>

<?= form_open('login_form') ?>
<table id = "formins">
	<tr>
		<th colspan = "2"><?= lang('voc.i18n_login')?></th>
	</tr>
	<tr>
		<td><?=lang('voc.i18n_username')?></td>
		<td><?= form_input('username') ?></td>
	</tr>
		<?php if(form_error('username')) echo "<tr><td><em>".form_error('username')."</em></td></tr>"; ?>
	<tr>
		<td><?=lang('voc.i18n_password')?></td>
		<td><?= form_password('password') ?></td>
	</tr>
		<?php if(form_error('password')) echo "<tr><td><em>".form_error('password')."</em></td></tr>"; ?>
	<tr>
		<th colspan="2">
		<?= form_submit(array('id' => 'submit', 'value' => lang('voc.i18n_submit'), 'class' => 'next')) ?>
		</th>
	</tr>
</table>
<?= form_close() ?>