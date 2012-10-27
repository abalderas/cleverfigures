<!--
	OUTPUT: login_form(username, password)
-->

<!--Login form. Gets login information-->
<?= "<h1>".lang('i18n_login')."</h1></br>"?>

<?= form_open('login_form') ?>
<table cellspacing="0" cellpadding="5" border="0">
	<tr>
		<td class="fieldbox"><?=lang('i18n_username')?>:</td>
		<td><?= form_input('username') ?></td>
	</tr>
	<tr>
		<td class="fieldbox"><?=lang('i18n_password')?>:</td>
		<td><?= form_password('password') ?></td>
	</tr>
	<tr>
		<td colspan="2">
		<?= form_submit('submit', lang('i18n_submit')) ?>
		</td>
	</tr>
</table>
<?= form_close() ?>