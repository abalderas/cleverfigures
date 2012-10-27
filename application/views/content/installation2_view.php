<!--
	INPUT: i18n_installation_intro, i18n_create_user, i18n_email, i18n_username, i18n_password, i18n_next
	OUTPUT: create_user_form(email, username, password, next)
-->

<?
echo "<h1>".lang('i18n_installation')."</h1></br>";

echo lang('i18n_installation_intro');

echo "<h3>".lang('i18n_create_user')."</h3>";
echo form_open('create_user_form');
<table cellspacing="0" cellpadding="5" border="0">
	<tr>
		<td class="fieldbox"><?=lang('i18n_email')?>:</td>
		<td><?= form_input('email') ?></td>
	</tr>
	<tr>
		<td class="fieldbox"><?=lang('i18n_username')?>:</td>
		<td><?= form_input('username') ?></td>
	</tr>
	<tr>
		<td class="fieldbox"><?=lang('i18n_password')?>:</td>
		<td><?= form_password('password') ?></td>
	</tr>
	<tr>
		<td class="fieldbox"><?=lang('i18n_retype_password')?>:</td>
		<td><?= form_password('retype_password') ?></td>
	</tr>
	<tr>
		<td colspan="2">
		<?= form_submit('next', $i18n_next) ?>
		</td>
	</tr>
</table>
echo form_close();
?>