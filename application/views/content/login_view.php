<!--
	OUTPUT: login_form(username, password)
-->

<!--Login form. Gets login information-->
<?= "<h1>".lang('voc.i18n_login')."</h1></br>"?>

<?= form_open('login_form') ?>
<table id = "form">
	<tr>
		<td width = "40%"></td>
		<td><?=lang('voc.i18n_username')?></td>
		<td><?= form_input('username') ?></td>
		<td width = "40%"></td>
	</tr>
	<tr>
		<td width = "40%"></td>
		<td><?=lang('voc.i18n_password')?></td>
		<td><?= form_password('password') ?></td>
		<td width = "40%"></td>
	</tr>
	<tr height = "30px">
		<td width = "40%"></td>
		<td colspan="2">
		<?= form_submit(array('id' => 'submit', 'value' => lang('voc.i18n_submit'), 'class' => 'submit')) ?>
		</br>
		</td>
		<td width = "40%"></td>
	</tr>
</table>
<?= form_close() ?>