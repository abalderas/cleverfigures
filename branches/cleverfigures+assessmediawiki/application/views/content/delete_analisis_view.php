<?
	echo "<h1>".lang('voc.i18n_delete_analisis')."</h1>";
	echo "<table id = \"formins\">";
	echo "<tr>";
	echo "<th colspan = \"2\">".lang("voc.i18n_confirm_delete")."</th>";
	echo "</tr>";
	echo "<tr>";
	echo form_open('confirm_delete');
		echo form_hidden('aname', $analisis);
		echo "<td>".form_submit('confirm', lang('voc.i18n_confirm')).form_submit('cancel', lang('voc.i18n_cancel'))."</td>";
	echo form_close();
	echo "</tr>";
	echo "</table>";
?>