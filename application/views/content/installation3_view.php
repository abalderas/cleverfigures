<!--
	INPUT: i18n_installation_end, i18n_go_to_login
	OUTPUT: installation_end_form(go_to_login_submit)
-->

<?
echo lang('i18n_installation_end');

echo form_open('installation_end_form');
	<?= form_submit('go_to_login_submit', lang('i18n_go_to_login')) ?>
echo form_close();
?>