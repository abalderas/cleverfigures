
<?="<h1>".lang('voc.i18n_performed_analisis')."</h1></br>"?>
<table id = "bodytable">
<tr>
	<th><?=lang('voc.i18n_date_hour')?></th>
	<th><?=lang('voc.i18n_wiki')?></th>
	<th><?=lang('voc.i18n_color')?></th>
	<th><?=lang('voc.i18n_date_range_a')?></th>
	<th><?=lang('voc.i18n_date_range_b')?></th>
	<th><?=lang('voc.i18n_options')?></th>
</tr>

<? 
	if(isset($adate))
		for($i = 0; $i < count($adate); $i++){
			echo "<tr>";
				echo "<td>".$adate[$i]."</td>";
				echo "<td>".$awiki[$i]."</td>";
				echo "<td>".$acolor[$i]."</td>";
				echo "<td>".$arangea[$i]."</td>";
				echo "<td>".$arangeb[$i]."</td>";
				form_open('options_form');
				echo "<td>".form_submit('view', lang('voc.i18n_view'))." ".form_submit('download',lang('voc.i18n_download'))." ".form_submit('delete', lang('voc.i18n_delete'))."</td>";
				form_close();
			echo "</tr>";
		}
	else echo "<tr><td colspan = \"6\">".lang('voc.i18n_no_analisis')."</td></tr>";
?>

</table>