<!--
<<Copyright 2013 Alvaro Almagro Doello>>

This file is part of CleverFigures.

CleverFigures is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

CleverFigures is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with CleverFigures.  If not, see <http://www.gnu.org/licenses/>.
-->

<?="<h1>".lang('voc.i18n_performed_analisis')."</h1></br>"?>
<table id = "bodytable">
<tr>
	<th><?=lang('voc.i18n_date_hour')?></th>
	<th><?=lang('voc.i18n_wiki')?></th>
	<th><?=lang('voc.i18n_color')?></th>
	<th><?=lang('voc.i18n_options')?></th>
</tr>

<? 
	if(isset($adate))
		for($i = 0; $i < count($adate); $i++){
			echo "<tr>";
				echo "<td>".unix_to_human($adate[$i])."</td>";
				echo "<td>".$awiki[$i]."</td>";
				echo "<td>".$acolor[$i]."</td>";
				echo form_open('options_form');
				echo form_hidden('aname', $adate[$i]);
				echo "<td>".form_submit('view', lang('voc.i18n_view'))." ".form_submit('delete', lang('voc.i18n_delete'))."</td>";
				echo form_close();
			echo "</tr>";
		}
	else echo "<tr><td colspan = \"4\">".lang('voc.i18n_no_analisis')."</td></tr>";
?>

</table>