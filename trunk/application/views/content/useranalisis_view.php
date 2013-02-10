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
// 		google.setOnLoadCallback(drawChart<?=$data['userid'][$username]?>);
		function drawChart<?=$data['userid'][$username]?>() {
			var data1<?=$data['userid'][$username]?> = new google.visualization.DataTable();
			data1<?=$data['userid'][$username]?>.addColumn('datetime', 'Date');
			data1<?=$data['userid'][$username]?>.addColumn('number', 'Editions');
			data1<?=$data['userid'][$username]?>.addRows([
			<?
				foreach(array_keys($data['useredits'][$username]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['useredits'][$username][$key].
						"]";
					if($key != end(array_keys($data['useredits'][$username]))) echo ",";
				}
			?>
			]);

			var chartedits<?=$data['userid'][$username]?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaledits<?=$data['userid'][$username]?>'));
			chartedits<?=$data['userid'][$username]?>.draw(data1<?=$data['userid'][$username]?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
			
			
			var data2<?=$data['userid'][$username]?> = new google.visualization.DataTable();
			data2<?=$data['userid'][$username]?>.addColumn('datetime', 'Date');
			data2<?=$data['userid'][$username]?>.addColumn('number', 'Bytes');
			data2<?=$data['userid'][$username]?>.addRows([
			<?
				foreach(array_keys($data['userbytes'][$username]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['userbytes'][$username][$key].
					"]";
					if($key != end(array_keys($data['userbytes'][$username]))) echo ",";
				}
			?>
			]);

			var chartbytes<?=$data['userid'][$username]?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytes<?=$data['userid'][$username]?>'));
			chartbytes<?=$data['userid'][$username]?>.draw(data2<?=$data['userid'][$username]?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
                        
                        
                        var data5<?=$data['userid'][$username]?> = new google.visualization.arrayToDataTable([
				['Hour', 'Editions'],
			<?
				foreach(array_keys($data['useractivityhour'][$username]) as $key){
					echo "[".$key.", ".
					$data['useractivityhour'][$username][$key].
					"]";
					if($key != end(array_keys($data['useractivityhour'][$username]))) echo ",";
				}
			?>
			]);
			
			var options5<?=$data['userid'][$username]?> = {
				hAxis: {title: 'Hour', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityhour<?=$data['userid'][$username]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityhour<?=$data['userid'][$username]?>'));
			charttotalactivityhour<?=$data['userid'][$username]?>.draw(data5<?=$data['userid'][$username]?>, options5<?=$data['userid'][$username]?>);
			
			
			var data6<?=$data['userid'][$username]?> = new google.visualization.arrayToDataTable([
				['Week Day', 'Editions'],
			<?
				foreach(array_keys($data['useractivitywday'][$username]) as $key){
					echo "['".$key."', ".
					$data['useractivitywday'][$username][$key].
					"]";
					if($key != end(array_keys($data['useractivitywday'][$username]))) echo ",";
				}
			?>
			]);
			
			var options6<?=$data['userid'][$username]?> = {
				hAxis: {title: 'Week Day', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivitywday<?=$data['userid'][$username]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivitywday<?=$data['userid'][$username]?>'));
			charttotalactivitywday<?=$data['userid'][$username]?>.draw(data6<?=$data['userid'][$username]?>, options6<?=$data['userid'][$username]?>);
			
			
			var data7<?=$data['userid'][$username]?> = new google.visualization.arrayToDataTable([
				['Week', 'Editions'],
			<?
				foreach(array_keys($data['useractivityweek'][$username]) as $key){
					echo "['".$key."', ".
					$data['useractivityweek'][$username][$key].
					"]";
					if($key != end(array_keys($data['useractivityweek'][$username]))) echo ",";
				}
			?>
			]);
			
			var options7<?=$data['userid'][$username]?> = {
				hAxis: {title: 'Week', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityweek<?=$data['userid'][$username]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityweek<?=$data['userid'][$username]?>'));
			charttotalactivityweek<?=$data['userid'][$username]?>.draw(data7<?=$data['userid'][$username]?>, options7<?=$data['userid'][$username]?>);
			
			var data8<?=$data['userid'][$username]?> = new google.visualization.arrayToDataTable([
				['Month', 'Editions'],
			<?
				foreach(array_keys($data['useractivitymonth'][$username]) as $key){
					echo "['".$key."', ".
					$data['useractivitymonth'][$username][$key].
					"]";
					if($key != end(array_keys($data['useractivitymonth'][$username]))) echo ",";
				}
			?>
			]);
			
			var options8<?=$data['userid'][$username]?> = {
				hAxis: {title: 'Month', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivitymonth<?=$data['userid'][$username]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivitymonth<?=$data['userid'][$username]?>'));
			charttotalactivitymonth<?=$data['userid'][$username]?>.draw(data8<?=$data['userid'][$username]?>, options8<?=$data['userid'][$username]?>);
			
			var data9<?=$data['userid'][$username]?> = new google.visualization.arrayToDataTable([
				['Year', 'Editions'],
			<?
				foreach(array_keys($data['useractivityyear'][$username]) as $key){
					echo "['".$key."', ".
					$data['useractivityyear'][$username][$key].
					"]";
					if($key != end(array_keys($data['useractivityyear'][$username]))) echo ",";
				}
			?>
			]);
			
			var options9<?=$data['userid'][$username]?> = {
				hAxis: {title: 'Year', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityyear<?=$data['userid'][$username]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityyear<?=$data['userid'][$username]?>'));
			charttotalactivityyear<?=$data['userid'][$username]?>.draw(data9<?=$data['userid'][$username]?>, options9<?=$data['userid'][$username]?>);
			<?
			if(isset($data['useruploads'][$username])){
					echo "var data10".$data['userid'][$username]." = new google.visualization.DataTable();
				data10".$data['userid'][$username].".addColumn('datetime', 'Date');
				data10".$data['userid'][$username].".addColumn('number', 'Uploads');
				data10".$data['userid'][$username].".addRows([";
				
					foreach(array_keys($data['useruploads'][$username]) as $key){
						echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['useruploads'][$username][$key]."]";
						if($key != end(array_keys($data['useruploads'][$username]))) echo ",";
					}
				
				echo "]);

				var charttotaluploads".$data['userid'][$username]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaluploads".$data['userid'][$username]."'));
				charttotaluploads".$data['userid'][$username].".draw(data10".$data['userid'][$username].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow'}
					);
				
				var data11".$data['userid'][$username]." = new google.visualization.DataTable();
				data11".$data['userid'][$username].".addColumn('datetime', 'Date');
				data11".$data['userid'][$username].".addColumn('number', 'Upload Bytes');
				data11".$data['userid'][$username].".addRows([";
				
					foreach(array_keys($data['userupsize'][$username]) as $key){
						echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['userupsize'][$username][$key]."]";
						if($key != end(array_keys($data['userupsize'][$username]))) echo ",";
					}
				
				echo "]);

				var charttotalupsize".$data['userid'][$username]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalupsize".$data['userid'][$username]."'));
				charttotalupsize".$data['userid'][$username].".draw(data11".$data['userid'][$username].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow'}
					);";
					
					
				echo "var imgs".$data['userid'][$username]." = new google.visualization.DataTable();
				imgs".$data['userid'][$username].".addColumn('string', 'Name');
				imgs".$data['userid'][$username].".addColumn('number', 'Size');
				imgs".$data['userid'][$username].".addColumn('datetime', 'Date');
				imgs".$data['userid'][$username].".addRows([";
					foreach(array_keys($data['userimages'][$username]) as $key){
						echo "['".$data['userimages'][$username][$key]."',";
						echo $data['imagesize'][$data['userimages'][$username][$key]].",";
						echo "new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key).")]";
						
						if($key != end(array_keys($data['userimages'][$username]))) echo ",";
					}
				echo "]);


				var imgtable".$data['userid'][$username]." = new google.visualization.Table(document.getElementById('img_table".$data['userid'][$username]."'));
				imgtable".$data['userid'][$username].".draw(imgs".$data['userid'][$username].", {showRowNumber: true});";
			}
			?>
			
			<?
			if(isset($data['useraveragevalue'][$username])){
			
				echo "var data12".$data['userid'][$username]." = new google.visualization.DataTable();
				data12".$data['userid'][$username].".addColumn('datetime', 'Date');
				data12".$data['userid'][$username].".addColumn('number', 'Average Grade');
				data12".$data['userid'][$username].".addRows([";
			
					foreach(array_keys($data['useraveragevalue'][$username]) as $key){
						$date = $data['revisiondate'][$key];
						echo "[new Date(".
						date('Y', $date).", ".
						date('m', $date)." ,".
						date('d', $date)." ,".
						date('H', $date)." ,".
						date('i', $date)."), ".
						$data['useraveragevalue'][$username][$key]."]";
						if($key != end(array_keys($data['useraveragevalue'][$username]))) echo ",";
					}
				echo "]);

				var charttotalquality".$data['userid'][$username]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalquality".$data['userid'][$username]."'));
				charttotalquality".$data['userid'][$username].".draw(data12".$data['userid'][$username].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow'}
					);
				
				var data13".$data['userid'][$username]." = new google.visualization.DataTable();
				data13".$data['userid'][$username].".addColumn('datetime', 'Date');
				data13".$data['userid'][$username].".addColumn('number', 'Bytes X Quality');
				data13".$data['userid'][$username].".addColumn('number', 'Bytes');
				data13".$data['userid'][$username].".addRows([";
					$result = 0;
					foreach(array_keys($data['userbytes'][$username]) as $date){
						$rev = $data['daterevision'][$date];
						$grade = isset($data['useraveragevalue'][$username][$rev])? $data['useraveragevalue'][$username][$rev] : 5;
						
						$result += $data['totalbytesdiff'][$date] + ($grade - 5) * ($data['totalbytesdiff'][$date]/5);
						echo "[new Date(".
						date('Y', $date).", ".
						date('m', $date)." ,".
						date('d', $date)." ,".
						date('H', $date)." ,".
						date('i', $date)."), ".
						$result.", ".
						$data['userbytes'][$username][$date].
						"]";
						if($date != end(array_keys($data['userbytes'][$username]))) echo ",";
					}
				echo "]);
				
				var charttotalbytesxquality".$data['userid'][$username]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytesxquality".$data['userid'][$username]."'));
				charttotalbytesxquality".$data['userid'][$username].".draw(data13".$data['userid'][$username].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow'}
					);
				
				var data14".$data['userid'][$username]." = new google.visualization.DataTable();
				data14".$data['userid'][$username].".addColumn('number', 'Hour');
				data14".$data['userid'][$username].".addColumn('number', 'Quality');
				data14".$data['userid'][$username].".addRows([";
					foreach(array_keys($data['usergrades'][$username]) as $revision){
						$date = $data['revisiondate'][$revision];
						$accum[date('H', $date)] = 0;
						$nrevs[date('H', $date)] = 0;
					}
					
					foreach(array_keys($data['usergrades'][$username]) as $revision){
						$date = $data['revisiondate'][$revision];
						$grade = $data['usergrades'][$username][$revision];
						$accum[date('H', $date)] += $grade;
						$nrevs[date('H', $date)] += 1;
					}
					
					foreach(array_keys($accum) as $hour){
						echo "[".$hour.", ".($accum[$hour]/$nrevs[$hour])."]";
						if($hour != end(array_keys($accum))) echo ",";
					}
				echo "]);
				
				var options".$data['userid'][$username]." = {
					hAxis: {title: 'Hour', titleTextStyle: {data: 'green'}},
					vAxis: {title: 'Quality', titleTextStyle: {data: 'green'}, minValue:0}
				};
				
				var chartqualityhour".$data['userid'][$username]." = new google.visualization.ScatterChart(document.getElementById('qualityhourchart".$data['userid'][$username]."'));
				chartqualityhour".$data['userid'][$username].".draw(data14".$data['userid'][$username].", options".$data['userid'][$username].");";
			}
			?>
			
			var data<?=$data['userid'][$username]?> = new google.visualization.DataTable();
			data<?=$data['userid'][$username]?>.addColumn('string', 'Name');
			data<?=$data['userid'][$username]?>.addColumn('string', 'Namespace');
			data<?=$data['userid'][$username]?>.addColumn('number', 'Edits');
			data<?=$data['userid'][$username]?>.addColumn('number', 'Edits %');
			data<?=$data['userid'][$username]?>.addColumn('number', 'Bytes');
			data<?=$data['userid'][$username]?>.addColumn('number', 'Bytes %');
			data<?=$data['userid'][$username]?>.addColumn('number', 'Average Grade');
			data<?=$data['userid'][$username]?>.addColumn('number', 'Standard Deviation');
			data<?=$data['userid'][$username]?>.addRows([<? 
				foreach(array_keys($data['userpage'][$username]) as $key){
					echo "['".$key."','".
						$data['pagenamespace'][$key]."',".
						round(end($data['pageuseredits'][$key][$username]), 2).",".
						round(end($data['pageusereditscount'][$key][$username])/end($data['useredits'][$username]), 2).",";
					if(end($data['userbytes'][$username]) != 0){
						echo round(end($data['pageuserbytes'][$key][$username]), 2).",".
						round(end($data['pageuserbytescount'][$key][$username])/end($data['userbytes'][$username]), 2);
					}else
						echo "0, 0";
					
					if(isset($data['pageuseraveragevalue'][$key][$username])) 
						echo ", ".round(end($data['pageuseraveragevalue'][$key][$username]), 2).",".
							round(end($data['pageusersd'][$key][$username]), 2);
					else
						echo ", -1, -1";
						
					echo "]\n";
					
					if($key != end(array_keys($data['userpage'][$username]))) echo ",";
				}
			?>]);


			var table<?=$data['userid'][$username]?> = new google.visualization.Table(document.getElementById('page_table<?=$data['userid'][$username]?>'));
			table<?=$data['userid'][$username]?>.draw(data<?=$data['userid'][$username]?>, {showRowNumber: true});
			
			<?
			if(isset($data['usercat'][$username])){
								
				echo "var catdata".$data['userid'][$username]." = new google.visualization.DataTable();
				catdata".$data['userid'][$username].".addColumn('string', 'Name');
				catdata".$data['userid'][$username].".addRows([";
					foreach(array_keys($data['usercat'][$username]) as $key){
						echo "['".$key."']\n";
						if($key != end(array_keys($data['usercat'][$username]))) echo ",";
					}
				echo "]);


				var cattable".$data['userid'][$username]." = new google.visualization.Table(document.getElementById('categories_table".$data['userid'][$username]."'));
				cattable".$data['userid'][$username].".draw(catdata".$data['userid'][$username].", {showRowNumber: true});";
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
		<td><div id='charttotaledits<?=$data['userid'][$username]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_content_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytes<?=$data['userid'][$username]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_hour')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityhour<?=$data['userid'][$username]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_wday')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitywday<?=$data['userid'][$username]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_week')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityweek<?=$data['userid'][$username]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_month')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitymonth<?=$data['userid'][$username]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_year')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityyear<?=$data['userid'][$username]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<? if (!isset($data['useruploads'][$username])) echo "<!--";?>
	<tr>
		<th><?=lang('voc.i18n_uploads')?></th>
	</tr>
	<tr>
		<td><div id='charttotaluploads<?=$data['userid'][$username]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_upsize')?></th>
	</tr>
	<tr>
		<td><div id='charttotalupsize<?=$data['userid'][$username]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<? if (!isset($data['useruploads'][$username])) echo "-->";?>
	<? if (!isset($data['useraveragevalue'][$username])) echo "<!--";?>
	<tr>
		<th><?=lang('voc.i18n_average_quality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalquality<?=$data['userid'][$username]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_bytesxquality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytesxquality<?=$data['userid'][$username]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_hourquality')?></th>
	</tr>
	<tr>
		<td><div id='qualityhourchart<?=$data['userid'][$username]?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<? if (!isset($data['useraveragevalue'][$username])) echo "-->";?>
	</table>
	
	<br><br>
	
	<table id = "charttable">
	<tr>
		<th><?=lang('voc.i18n_pages')?></th>
	</tr>
	<tr>
		<td><div id = "page_table<?=$data['userid'][$username]?>"></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<? if(!isset($data['usercat'][$username])) echo "<!--";?>
	<table id = "charttable">
	<tr>
		<th><?=lang('voc.i18n_categories')?></th>
	</tr>
	<tr>
		<td><div id = "categories_table<?=$data['userid'][$username]?>"></div></td>
	</tr>
	</table>
	<? if(!isset($data['usercat'][$username])) echo "-->";?>
	
	<br><br>
	
	<? if(!isset($data['userimages'][$username])) echo "<!--";?>
	<table id = "charttable">
	<tr>
		<th><?=lang('voc.i18n_images')?></th>
	</tr>
	<tr>
		<td><div id = "img_table<?=$data['userid'][$username]?>"></div></td>
	</tr>
	</table>
	<? if(!isset($data['userimages'][$username])) echo "-->";?>
	
	<script>
		drawChart<?=$data['userid'][$username]?>();
	</script>