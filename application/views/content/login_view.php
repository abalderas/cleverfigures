<!--
	INPUT: i18n_password, i18n_submit, i18n_username
	OUTPUT: login_form(username, password)
-->

<!--Login form. Gets login information-->
<?= form_open('login_form') ?>
<table cellspacing="0" cellpadding="5" border="0">
	<tr>
		<td class="fieldbox"><?=$i18n_username?>:</td>
		<td><?= form_input('username') ?></td>
	</tr>
	<tr>
		<td class="fieldbox"><?=$i18n_password?>:</td>
		<td><?= form_password('password') ?></td>
	</tr>
	<tr>
		<td colspan="2">
		<?= form_submit('submit', $i18n_submit) ?>
		</td>
	</tr>
</table>
<?= form_close() ?>

<!--[1] TO_DO: forgot your login info?-->