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

<?echo form_open('options_form');?>
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
				echo form_hidden('aname', $adate[$i]);
				$btn_view = array(
					'type' => 'image',
					'src' => base_url().'images/icons/Developer_Icons_PNG/PNG/Green/24/object_13.png',
					'name' => 'view',
					'id' => 'view',
					'width' => '24',
					'height' => '24',
					'alt' => 'view',
					'value' => '',
					'onclick' => 'overlay.show();'
				);
				$btn_delete = array(
					'type' => 'image',
					'src' => base_url().'images/icons/Developer_Icons_PNG/PNG/Green/24/Recycle.png',
					'name' => 'delete',
					'id' => 'delete',
					'width' => '24',
					'height' => '24',
					'alt' => 'delete',
					'value' => ''
				);
				$btn_locked = array(
					'type' => 'image',
					'src' => base_url().'images/icons/Developer_Icons_PNG/PNG/Green/24/locked.png',
					'name' => 'locked',
					'id' => 'locked',
					'width' => '24',
					'height' => '24',
					'alt' => 'locked',
					'value' => ''
				);
				$btn_shared = array(
					'type' => 'image',
					'src' => base_url().'images/icons/Developer_Icons_PNG/PNG/Green/24/unlocked.png',
					'name' => 'shared',
					'id' => 'shared',
					'width' => '24',
					'height' => '24',
					'alt' => 'shared',
					'value' => ''
				);
				echo "<td>".form_submit($btn_view)." ".form_submit($btn_delete)."</td>";
// 				if($isshared[$i])
// 					echo form_input($btn_shared)."</td>";
// 				else
// 					echo form_input($btn_locked)."</td>";
					
			echo "</tr>";
		}
	else echo "<tr><td colspan = \"4\">".lang('voc.i18n_no_analisis')."</td></tr>";
?>

</table>
<?echo form_close();?>