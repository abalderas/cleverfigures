<!--
	INPUT: i18n_installation_end, i18n_go_to_login
	OUTPUT: installation_end_form(go_to_login_submit)
-->

<?
echo img('images/logo/logotrans.png');
echo br();

echo "</b><p align = \"center\">".lang('voc.i18n_installation_end')."</p></b>";
?>

<?echo form_open('installation_end_form');?>
<table id = "formins" class = "next">
	<tr><th><? echo form_submit(array('id' => 'go_to_login_submit', 'value' => lang('voc.i18n_go_to_login'), 'class' => 'next'));?></th></tr>
</table>
<? echo form_close();?>