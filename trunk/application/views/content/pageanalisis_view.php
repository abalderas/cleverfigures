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

<!-- CHARTS SCRIPTS -->

<script type='text/javascript' src='http://www.google.com/jsapi'></script>
	<script type='text/javascript'>
		google.load('visualization', '1', {'packages':['annotatedtimeline', 'corechart', 'table']});
		google.setOnLoadCallback(drawChart<?=$data['pageid'][$pagename]?>);
		function drawChart<?=$data['pageid'][$pagename]?>() {
			var data1<?=$data['pageid'][$pagename]?> = new google.visualization.DataTable();
			data1<?=$data['pageid'][$pagename]?>.addColumn('datetime', 'Date');
			data1<?=$data['pageid'][$pagename]?>.addColumn('number', 'Editions');
			data1<?=$data['pageid'][$pagename]?>.addRows([
			<?
				foreach(array_keys($data['pageedits'][$pagename]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['pageedits'][$pagename][$key].
						"]";
					if($key != end(array_keys($data['pageedits'][$pagename]))) echo ",";
				}
			?>
			]);

			var chartedits<?=$data['pageid'][$pagename]?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaledits<?=$data['pageid'][$pagename]?>'));
			chartedits<?=$data['pageid'][$pagename]?>.draw(data1<?=$data['pageid'][$pagename]?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
			
			
			var data2<?=$data['pageid'][$pagename]?> = new google.visualization.DataTable();
			data2<?=$data['pageid'][$pagename]?>.addColumn('datetime', 'Date');
			data2<?=$data['pageid'][$pagename]?>.addColumn('number', 'Bytes');
			data2<?=$data['pageid'][$pagename]?>.addRows([
			<?
				foreach(array_keys($data['pagebytes'][$pagename]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['pagebytes'][$pagename][$key].
					"]";
					if($key != end(array_keys($data['pagebytes'][$pagename]))) echo ",";
				}
			?>
			]);

			var chartbytes<?=$data['pageid'][$pagename]?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytes<?=$data['pageid'][$pagename]?>'));
			chartbytes<?=$data['pageid'][$pagename]?>.draw(data2<?=$data['pageid'][$pagename]?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
                                
                        var data4<?=$data['pageid'][$pagename]?> = new google.visualization.DataTable();
			data4<?=$data['pageid'][$pagename]?>.addColumn('datetime', 'Date');
			data4<?=$data['pageid'][$pagename]?>.addColumn('number', 'Users');
			data4<?=$data['pageid'][$pagename]?>.addRows([
			<?
				foreach(array_keys($data['pageusercount'][$pagename]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['pageusercount'][$pagename][$key].
					"]";
					if($key != end(array_keys($data['pageusercount'][$pagename]))) echo ",";
				}
			?>
			]);

			var chartusers<?=$data['pageid'][$pagename]?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalusers<?=$data['pageid'][$pagename]?>'));
			chartusers<?=$data['pageid'][$pagename]?>.draw(data4<?=$data['pageid'][$pagename]?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'
                                }
                        );
                        
                        
                        var data5<?=$data['pageid'][$pagename]?> = new google.visualization.arrayToDataTable([
				['Hour', 'Editions'],
			<?
				foreach(array_keys($data['pageactivityhour'][$pagename]) as $key){
					echo "[".$key.", ".
					$data['pageactivityhour'][$pagename][$key].
					"]";
					if($key != end(array_keys($data['pageactivityhour'][$pagename]))) echo ",";
				}
			?>
			]);
			
			var options5<?=$data['pageid'][$pagename]?> = {
				hAxis: {title: 'Hour', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityhour<?=$data['pageid'][$pagename]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityhour<?=$data['pageid'][$pagename]?>'));
			charttotalactivityhour<?=$data['pageid'][$pagename]?>.draw(data5<?=$data['pageid'][$pagename]?>, options5<?=$data['pageid'][$pagename]?>);
			
			
			var data6<?=$data['pageid'][$pagename]?> = new google.visualization.arrayToDataTable([
				['Week Day', 'Editions'],
			<?
				foreach(array_keys($data['pageactivitywday'][$pagename]) as $key){
					echo "['".$key."', ".
					$data['pageactivitywday'][$pagename][$key].
					"]";
					if($key != end(array_keys($data['pageactivitywday'][$pagename]))) echo ",";
				}
			?>
			]);
			
			var options6<?=$data['pageid'][$pagename]?> = {
				hAxis: {title: 'Week Day', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivitywday<?=$data['pageid'][$pagename]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivitywday<?=$data['pageid'][$pagename]?>'));
			charttotalactivitywday<?=$data['pageid'][$pagename]?>.draw(data6<?=$data['pageid'][$pagename]?>, options6<?=$data['pageid'][$pagename]?>);
			
			
			var data7<?=$data['pageid'][$pagename]?> = new google.visualization.arrayToDataTable([
				['Week', 'Editions'],
			<?
				foreach(array_keys($data['pageactivityweek'][$pagename]) as $key){
					echo "['".$key."', ".
					$data['pageactivityweek'][$pagename][$key].
					"]";
					if($key != end(array_keys($data['pageactivityweek'][$pagename]))) echo ",";
				}
			?>
			]);
			
			var options7<?=$data['pageid'][$pagename]?> = {
				hAxis: {title: 'Week', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityweek<?=$data['pageid'][$pagename]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityweek<?=$data['pageid'][$pagename]?>'));
			charttotalactivityweek<?=$data['pageid'][$pagename]?>.draw(data7<?=$data['pageid'][$pagename]?>, options7<?=$data['pageid'][$pagename]?>);
			
			var data8<?=$data['pageid'][$pagename]?> = new google.visualization.arrayToDataTable([
				['Month', 'Editions'],
			<?
				foreach(array_keys($data['pageactivitymonth'][$pagename]) as $key){
					echo "['".$key."', ".
					$data['pageactivitymonth'][$pagename][$key].
					"]";
					if($key != end(array_keys($data['pageactivitymonth'][$pagename]))) echo ",";
				}
			?>
			]);
			
			var options8<?=$data['pageid'][$pagename]?> = {
				hAxis: {title: 'Month', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivitymonth<?=$data['pageid'][$pagename]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivitymonth<?=$data['pageid'][$pagename]?>'));
			charttotalactivitymonth<?=$data['pageid'][$pagename]?>.draw(data8<?=$data['pageid'][$pagename]?>, options8<?=$data['pageid'][$pagename]?>);
			
			var data9<?=$data['pageid'][$pagename]?> = new google.visualization.arrayToDataTable([
				['Year', 'Editions'],
			<?
				foreach(array_keys($data['pageactivityyear'][$pagename]) as $key){
					echo "['".$key."', ".
					$data['pageactivityyear'][$pagename][$key].
					"]";
					if($key != end(array_keys($data['pageactivityyear'][$pagename]))) echo ",";
				}
			?>
			]);
			
			var options9<?=$data['pageid'][$pagename]?> = {
				hAxis: {title: 'Year', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityyear<?=$data['pageid'][$pagename]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityyear<?=$data['pageid'][$pagename]?>'));
			charttotalactivityyear<?=$data['pageid'][$pagename]?>.draw(data9<?=$data['pageid'][$pagename]?>, options9<?=$data['pageid'][$pagename]?>);
			<?
			if(isset($data['pageuploads'][$pagename])){
					echo "var data10".$data['pageid'][$pagename]." = new google.visualization.DataTable();
				data10".$data['pageid'][$pagename].".addColumn('datetime', 'Date');
				data10".$data['pageid'][$pagename].".addColumn('number', 'Uploads');
				data10".$data['pageid'][$pagename].".addRows([";
				
					foreach(array_keys($data['pageuploads'][$pagename]) as $key){
						echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['pageuploads'][$pagename][$key]."]";
						if($key != end(array_keys($data['pageuploads'][$pagename]))) echo ",";
					}
				
				echo "]);

				var charttotaluploads".$data['pageid'][$pagename]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaluploads".$data['pageid'][$pagename]."'));
				charttotaluploads".$data['pageid'][$pagename].".draw(data10".$data['pageid'][$pagename].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow'}
					);
				
				var data11".$data['pageid'][$pagename]." = new google.visualization.DataTable();
				data11".$data['pageid'][$pagename].".addColumn('datetime', 'Date');
				data11".$data['pageid'][$pagename].".addColumn('number', 'Upload Bytes');
				data11".$data['pageid'][$pagename].".addRows([";
				
					foreach(array_keys($data['pageupsize'][$pagename]) as $key){
						echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['pageupsize'][$pagename][$key]."]";
						if($key != end(array_keys($data['pageupsize'][$pagename]))) echo ",";
					}
				
				echo "]);

				var charttotalupsize".$data['pageid'][$pagename]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalupsize".$data['pageid'][$pagename]."'));
				charttotalupsize".$data['pageid'][$pagename].".draw(data11".$data['pageid'][$pagename].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow'}
					);";
			}
			?>
			
			<?
			if(isset($data['pageaveragevalue'][$pagename])){
			
				echo "var data12".$data['pageid'][$pagename]." = new google.visualization.DataTable();
				data12".$data['pageid'][$pagename].".addColumn('datetime', 'Date');
				data12".$data['pageid'][$pagename].".addColumn('number', 'Average Grade');
				data12".$data['pageid'][$pagename].".addRows([";
			
					foreach(array_keys($data['pageaveragevalue'][$pagename]) as $key){
						$date = $data['revisiondate'][$key];
						echo "[new Date(".
						date('Y', $date).", ".
						date('m', $date)." ,".
						date('d', $date)." ,".
						date('H', $date)." ,".
						date('i', $date)."), ".
						$data['pageaveragevalue'][$pagename][$key]."]";
						if($key != end(array_keys($data['pageaveragevalue'][$pagename]))) echo ",";
					}
				echo "]);

				var charttotalquality".$data['pageid'][$pagename]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalquality".$data['pageid'][$pagename]."'));
				charttotalquality".$data['pageid'][$pagename].".draw(data12".$data['pageid'][$pagename].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow'}
					);
				
				var data13".$data['pageid'][$pagename]." = new google.visualization.DataTable();
				data13".$data['pageid'][$pagename].".addColumn('datetime', 'Date');
				data13".$data['pageid'][$pagename].".addColumn('number', 'Bytes X Quality');
				data13".$data['pageid'][$pagename].".addColumn('number', 'Bytes');
				data13".$data['pageid'][$pagename].".addRows([";
					$result = 0;
					foreach(array_keys($data['pagebytes'][$pagename]) as $date){
						$rev = $data['daterevision'][$date];
						$grade = isset($data['pageaveragevalue'][$pagename][$rev])? $data['pageaveragevalue'][$pagename][$rev] : 5;
						
						$result += $data['totalbytesdiff'][$date] + ($grade - 5) * ($data['totalbytesdiff'][$date]/5);
						echo "[new Date(".
						date('Y', $date).", ".
						date('m', $date)." ,".
						date('d', $date)." ,".
						date('H', $date)." ,".
						date('i', $date)."), ".
						$result.", ".
						$data['pagebytes'][$pagename][$date].
						"]";
						if($date != end(array_keys($data['pagebytes'][$pagename]))) echo ",";
					}
				echo "]);
				
				var charttotalbytesxquality".$data['pageid'][$pagename]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytesxquality".$data['pageid'][$pagename]."'));
				charttotalbytesxquality".$data['pageid'][$pagename].".draw(data13".$data['pageid'][$pagename].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow'}
					);
				
				var data14".$data['pageid'][$pagename]." = new google.visualization.DataTable();
				data14".$data['pageid'][$pagename].".addColumn('number', 'Hour');
				data14".$data['pageid'][$pagename].".addColumn('number', 'Quality');
				data14".$data['pageid'][$pagename].".addRows([";
					foreach(array_keys($data['pagegrades'][$pagename]) as $revision){
						$date = $data['revisiondate'][$revision];
						$accum[date('H', $date)] = 0;
						$nrevs[date('H', $date)] = 0;
					}
					
					foreach(array_keys($data['pagegrades'][$pagename]) as $revision){
						$date = $data['revisiondate'][$revision];
						$grade = $data['pagegrades'][$pagename][$revision];
						$accum[date('H', $date)] += $grade;
						$nrevs[date('H', $date)] += 1;
					}
					
					foreach(array_keys($accum) as $hour){
						echo "[".$hour.", ".($accum[$hour]/$nrevs[$hour])."]";
						if($hour != end(array_keys($accum))) echo ",";
					}
				echo "]);
				
				var options".$data['pageid'][$pagename]." = {
					hAxis: {title: 'Hour', titleTextStyle: {data: 'green'}},
					vAxis: {title: 'Quality', titleTextStyle: {data: 'green'}, minValue:0}
				};
				
				var chartqualityhour".$data['pageid'][$pagename]." = new google.visualization.ScatterChart(document.getElementById('qualityhourchart".$data['pageid'][$pagename]."'));
				chartqualityhour".$data['pageid'][$pagename].".draw(data14".$data['pageid'][$pagename].", options".$data['pageid'][$pagename].");";
			}
			?>
			
			var data<?=$data['pageid'][$pagename]?> = new google.visualization.DataTable();
			data<?=$data['pageid'][$pagename]?>.addColumn('string', 'Nick');
			data<?=$data['pageid'][$pagename]?>.addColumn('string', 'Name');
			data<?=$data['pageid'][$pagename]?>.addColumn('number', 'Edits');
			data<?=$data['pageid'][$pagename]?>.addColumn('number', 'Edits %');
			data<?=$data['pageid'][$pagename]?>.addColumn('number', 'Bytes');
			data<?=$data['pageid'][$pagename]?>.addColumn('number', 'Bytes %');
			data<?=$data['pageid'][$pagename]?>.addColumn('number', 'Average Grade');
			data<?=$data['pageid'][$pagename]?>.addColumn('number', 'Standard Deviation');
			data<?=$data['pageid'][$pagename]?>.addRows([
			<? 
				foreach(array_keys($data['pageuser'][$pagename]) as $key){
					echo "['".$key."','".
						$data['userrealname'][$key]."',".
						round(end($data['pageuseredits'][$pagename][$key]), 2).",".
						round(end($data['pageuseredits'][$pagename][$key])/end($data['pageedits'][$pagename]), 2).",";
					if(end($data['pagebytes'][$pagename]) != 0){
						echo round(end($data['pageuserbytes'][$pagename][$key]), 2).",".
						round(end($data['pageuserbytes'][$pagename][$key])/end($data['pagebytes'][$pagename]), 2);
					}else
						echo "0, 0";
					
					if(isset($data['pageuseraveragevalue'][$pagename][$key])) 
						echo ", ".round(end($data['pageuseraveragevalue'][$pagename][$key]), 2).",".
							round(end($data['pageusersd'][$pagename][$key]), 2);
					else
						echo ", -1, -1";
						
					echo "]\n";
					
					if($key != end(array_keys($data['pageuser'][$pagename]))) echo ",";
				}
			?>
			]);


			var table<?=$data['pageid'][$pagename]?> = new google.visualization.Table(document.getElementById('user_table<?=$data['pageid'][$pagename]?>'));
			table<?=$data['pageid'][$pagename]?>.draw(data<?=$data['pageid'][$pagename]?>, {showRowNumber: true});
			
			<?
			if(isset($data['pagecat'][$pagename])){
				echo "var catdata".$data['pageid'][$pagename]." = new google.visualization.DataTable();
				catdata".$data['pageid'][$pagename].".addColumn('string', 'Name');
				catdata".$data['pageid'][$pagename].".addRows([";
					foreach(array_keys($data['pagecat'][$pagename]) as $key){
						echo "['".$key."']\n";
						
						if($key != end(array_keys($data['pagecat'][$pagename]))) echo ",";
					}
				echo "]);


				var cattable".$data['pageid'][$pagename]." = new google.visualization.Table(document.getElementById('categories_table".$data['pageid'][$pagename]."'));
				cattable".$data['pageid'][$pagename].".draw(catdata".$data['pageid'][$pagename].", {showRowNumber: true});";
			}
			?>
		}
	</script>
	
<!-- CHARTS -->
	
	<table id = "charttable">
	<tr>
		<th><?=lang('voc.i18n_edits_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotaledits<?=$data['pageid'][$pagename]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_content_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytes<?=$data['pageid'][$pagename]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id='charttotalusers<?=$data['pageid'][$pagename]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_hour')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityhour<?=$data['pageid'][$pagename]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_wday')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitywday<?=$data['pageid'][$pagename]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_week')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityweek<?=$data['pageid'][$pagename]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_month')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitymonth<?=$data['pageid'][$pagename]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_year')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityyear<?=$data['pageid'][$pagename]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<? if (!isset($data['pageuploads'][$pagename])) echo "<!--";?>
	<tr>
		<th><?=lang('voc.i18n_uploads')?></th>
	</tr>
	<tr>
		<td><div id='charttotaluploads<?=$data['pageid'][$pagename]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_upsize')?></th>
	</tr>
	<tr>
		<td><div id='charttotalupsize<?=$data['pageid'][$pagename]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<? if (!isset($data['pageuploads'][$pagename])) echo "-->";?>
	<? if (!isset($data['pageaveragevalue'][$pagename])) echo "<!--";?>
	<tr>
		<th><?=lang('voc.i18n_average_quality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalquality<?=$data['pageid'][$pagename]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_bytesxquality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytesxquality<?=$data['pageid'][$pagename]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<? if (!isset($data['pageaveragevalue'][$pagename])) echo "-->";?>
	</table>
	
	<br><br>
	
	<table id = "charttable">
	<tr>
		<th><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id = "user_table<?=$data['pageid'][$pagename]?>"></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<? if(!isset($data['pagecat'][$pagename])) echo "<!--";?>
	<table id = "charttable">
	<tr>
		<th><?=lang('voc.i18n_categories')?></th>
	</tr>
	<tr>
		<td><div id = "categories_table<?=$data['pageid'][$pagename]?>"></div></td>
	</tr>
	</table>
	<? if(!isset($data['pagecat'][$pagename])) echo "-->";?>
			
<!-- [2] www.christophermonnat.com/2008/08/generating-pdf-files-using-codeigniter -->
<!--[2] TO_DO: generate pdf-->