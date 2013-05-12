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



<script language="javascript">
function tooglethis(chartname) {
	var chart = document.getElementById(chartname);
	if (chart.style.display == "none"){
		chart.style.display = "block";
	}
	else{
		chart.style.display = "none";
	}
}﻿
</script>

<h3><?=$groupname?></h3>

<!-- CHARTS -->
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id = "users_table"></div></td>
	</tr>
	</table>
	
	
	<!-- CHARTS SCRIPTS -->

	
	<script type='text/javascript'>
		google.load('visualization', '1', {'packages':['annotatedtimeline', 'corechart', 'table']});
		function drawChart() {
			
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Nick');
			data.addColumn('string', 'Name');
			data.addColumn('number', 'Edits');
			data.addColumn('number', 'Edits %');
			data.addColumn('number', 'Edits in articles');
			data.addColumn('number', 'Edits in articles %');
			data.addColumn('number', 'Bytes');
			data.addColumn('number', 'Bytes %');
			data.addColumn('number', 'Bytes in articles');
			data.addColumn('number', 'Bytes in articles %');
			<? if(isset($data['useruploads'])) echo "
				data.addColumn('number', 'Uploads');
				data.addColumn('number', 'Uploads %');";
			?>
			<? if(isset($data['useraverage'])) echo "
				data.addColumn('number', 'Average Grade');
				data.addColumn('number', 'Standard Deviation');
				data.addColumn('number', 'Maximum Grade');
				data.addColumn('number', 'Minimum Grade');
				data.addColumn('number', 'Average Grade as revisor');
				data.addColumn('number', 'Maximum Grade as revisor');
				data.addColumn('number', 'Minimum Grade as revisor');";
			?>
			data.addRows([
			<? 
				$members = $this->group_model->get_members($groupname);
				$edits = 0;
				$bytes = 0;
				$edits_art = 0;
				$bytes_art = 0;
				if(isset($data['useruploads'])){
					$uploads = 0;
				}
				
				foreach($members as $member){
					if(isset($data['useredits'][$member]))
						$edits += round(end($data['useredits'][$member]));
					if(isset($data['userbytes'][$member]))
						$bytes += round(end($data['userbytes'][$member]));
					if(isset($data['useredits_art'][$member]))
						$edits_art += round(end($data['useredits_art'][$member]));
					if(isset($data['userbytes_art'][$member]))
						$bytes_art += round(end($data['userbytes_art'][$member]));
					if(isset($data['useruploads'][$member])){
						$uploads += round(end($data['useruploads'][$member]));
					}
				}
				
				if($edits == 0){
					$edits = 1;
					$edits_art = 1;
				}
				else if($edits_art == 0){
					$edits_art = 1;
				}
				
				if($bytes == 0){
					$bytes = 1;
					$bytes_art = 1;
				}
				else if($bytes_art == 0){
					$bytes_art = 1;
				}
				
				foreach($members as $key){
					if(isset($data['useredits'][$key])){
						echo "['".anchor("filters_form/filter/".$aname."/user/".$key, $key, array('target' => '_blank'))."','".
							utf8_encode($data['userrealname'][$key])."',".
							round(end($data['useredits'][$key]), 2).",".
							round((end($data['useredits'][$key])/$edits)*100, 2).",".
							round(end($data['useredits_art'][$key]), 3).",".
							round((end($data['useredits_art'][$key])/$edits_art)*100, 2).",".
							round(end($data['userbytes'][$key]), 3).",".
							round((end($data['userbytes'][$key])/$bytes)*100, 2).",".
							round(end($data['userbytes_art'][$key]), 3).",".
							round((end($data['userbytes_art'][$key])/$bytes_art)*100, 2);
						if(isset($data['useruploads'][$member]) and $uploads != 0){
							echo ", ".round(end($data['useruploads'][$key]), 3).",".
							round((end($data['useruploads'][$key]) / $uploads)*100, 2);
						}
						else if (isset($data['useruploads']))
							echo ", 0, 0";
							
						if(isset($data['useraverage'])){
							if(isset($data['useraverage'][$data['userid'][$key]])) 
								echo ",".round(end($data['useraverage'][$data['userid'][$key]]), 2).",".
									round(end($data['usersd'][$data['userid'][$key]]), 2).",".
									round(end($data['usermaxvalue'][$data['userid'][$key]]), 3).",".
									round(end($data['userminvalue'][$data['userid'][$key]]), 3);
							else
								echo ", -1, -1, -1, -1";
								
							if(isset($data['revisoraverage'][$data['userid'][$key]])) 
								echo ",".round(end($data['revisoraverage'][$data['userid'][$key]]), 2).",".
									round(end($data['revisormaxvalue'][$data['userid'][$key]]), 3).",".
									round(end($data['revisorminvalue'][$data['userid'][$key]]), 3);
							else
								echo ", -1, -1, -1";
						}
							
						echo "]\n";
						
						if($key != end(array_keys($data['useredits']))) echo ",";
					}
					else{
						echo "['".$key."','";
						$name = $this->user_model->get_real_name($key);
						
						echo	($name ? $name : $key)."',".
							"0".",".
							"0".",".
							"0".",".
							"0".",".
							"0".",".
							"0".",".
							"0".",".
							"0".",".
							"0".",".
							"0";
							
						if(isset($data['useraverage'])){
							echo ", -1, -1, -1, -1";
							echo ", -1, -1, -1";
						}
							
						echo "]\n";
						
						if($key != end(array_keys($data['useredits']))) echo ",";
					}
				}
				echo "]);
					
				var grouptable = new google.visualization.Table(document.getElementById('users_table'));
				grouptable.draw(data, {showRowNumber: true,
					page: 'enable',
					allowHtml: true,
					pageSize: 20});";
			?>
		}
	</script>
	
	<script>drawChart();</script>