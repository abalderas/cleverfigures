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
		google.setOnLoadCallback(drawChart<?=$categoryname?>);
		function drawChart<?=$categoryname?>() {
			var data1<?=$categoryname?> = new google.visualization.DataTable();
			data1<?=$categoryname?>.addColumn('datetime', 'Date');
			data1<?=$categoryname?>.addColumn('number', 'Editions');
			data1<?=$categoryname?>.addRows([
			<?
				foreach(array_keys($data['catedits'][$categoryname]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['catedits'][$categoryname][$key].
						"]";
					if($key != end(array_keys($data['catedits'][$categoryname]))) echo ",";
				}
			?>
			]);

			var chartedits<?=$categoryname?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaledits<?=$categoryname?>'));
			chartedits<?=$categoryname?>.draw(data1<?=$categoryname?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
			
			
			var data2<?=$categoryname?> = new google.visualization.DataTable();
			data2<?=$categoryname?>.addColumn('datetime', 'Date');
			data2<?=$categoryname?>.addColumn('number', 'Bytes');
			data2<?=$categoryname?>.addRows([
			<?
				foreach(array_keys($data['catbytes'][$categoryname]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['catbytes'][$categoryname][$key].
					"]";
					if($key != end(array_keys($data['catbytes'][$categoryname]))) echo ",";
				}
			?>
			]);

			var chartbytes<?=$categoryname?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytes<?=$categoryname?>'));
			chartbytes<?=$categoryname?>.draw(data2<?=$categoryname?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
                                
                        var data4<?=$categoryname?> = new google.visualization.DataTable();
			data4<?=$categoryname?>.addColumn('datetime', 'Date');
			data4<?=$categoryname?>.addColumn('number', 'Users');
			data4<?=$categoryname?>.addRows([
			<?
				foreach(array_keys($data['catusers'][$categoryname]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['catusers'][$categoryname][$key].
					"]";
					if($key != end(array_keys($data['catusers'][$categoryname]))) echo ",";
				}
			?>
			]);

			var chartusers<?=$categoryname?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalusers<?=$categoryname?>'));
			chartusers<?=$categoryname?>.draw(data4<?=$categoryname?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'
                                }
                        );
                        
                        var data3<?=$categoryname?> = new google.visualization.DataTable();
			data3<?=$categoryname?>.addColumn('datetime', 'Date');
			data3<?=$categoryname?>.addColumn('number', 'Pages');
			data3<?=$categoryname?>.addRows([
			<?
				foreach(array_keys($data['catpages'][$categoryname]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['catpages'][$categoryname][$key].
					"]";
					if($key != end(array_keys($data['catpages'][$categoryname]))) echo ",";
				}
			?>
			]);

			var chartpages<?=$categoryname?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalpages<?=$categoryname?>'));
			chartpages<?=$categoryname?>.draw(data4<?=$categoryname?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'
                                }
                        );
                        
                        var data5<?=$categoryname?> = new google.visualization.arrayToDataTable([
				['Hour', 'Editions'],
			<?
				foreach(array_keys($data['catactivityhour'][$categoryname]) as $key){
					echo "[".$key.", ".
					$data['catactivityhour'][$categoryname][$key].
					"]";
					if($key != end(array_keys($data['catactivityhour'][$categoryname]))) echo ",";
				}
			?>
			]);
			
			var options5<?=$categoryname?> = {
				hAxis: {title: 'Hour', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityhour<?=$categoryname?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityhour<?=$categoryname?>'));
			charttotalactivityhour<?=$categoryname?>.draw(data5<?=$categoryname?>, options5<?=$categoryname?>);
			
			
			var data6<?=$categoryname?> = new google.visualization.arrayToDataTable([
				['Week Day', 'Editions'],
			<?
				foreach(array_keys($data['catactivitywday'][$categoryname]) as $key){
					echo "['".$key."', ".
					$data['catactivitywday'][$categoryname][$key].
					"]";
					if($key != end(array_keys($data['catactivitywday'][$categoryname]))) echo ",";
				}
			?>
			]);
			
			var options6<?=$categoryname?> = {
				hAxis: {title: 'Week Day', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivitywday<?=$categoryname?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivitywday<?=$categoryname?>'));
			charttotalactivitywday<?=$categoryname?>.draw(data6<?=$categoryname?>, options6<?=$categoryname?>);
			
			
			var data7<?=$categoryname?> = new google.visualization.arrayToDataTable([
				['Week', 'Editions'],
			<?
				foreach(array_keys($data['catactivityweek'][$categoryname]) as $key){
					echo "['".$key."', ".
					$data['catactivityweek'][$categoryname][$key].
					"]";
					if($key != end(array_keys($data['catactivityweek'][$categoryname]))) echo ",";
				}
			?>
			]);
			
			var options7<?=$categoryname?> = {
				hAxis: {title: 'Week', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityweek<?=$categoryname?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityweek<?=$categoryname?>'));
			charttotalactivityweek<?=$categoryname?>.draw(data7<?=$categoryname?>, options7<?=$categoryname?>);
			
			var data8<?=$categoryname?> = new google.visualization.arrayToDataTable([
				['Month', 'Editions'],
			<?
				foreach(array_keys($data['catactivitymonth'][$categoryname]) as $key){
					echo "['".$key."', ".
					$data['catactivitymonth'][$categoryname][$key].
					"]";
					if($key != end(array_keys($data['catactivitymonth'][$categoryname]))) echo ",";
				}
			?>
			]);
			
			var options8<?=$categoryname?> = {
				hAxis: {title: 'Month', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivitymonth<?=$categoryname?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivitymonth<?=$categoryname?>'));
			charttotalactivitymonth<?=$categoryname?>.draw(data8<?=$categoryname?>, options8<?=$categoryname?>);
			
			var data9<?=$categoryname?> = new google.visualization.arrayToDataTable([
				['Year', 'Editions'],
			<?
				foreach(array_keys($data['catactivityyear'][$categoryname]) as $key){
					echo "['".$key."', ".
					$data['catactivityyear'][$categoryname][$key].
					"]";
					if($key != end(array_keys($data['catactivityyear'][$categoryname]))) echo ",";
				}
			?>
			]);
			
			var options9<?=$categoryname?> = {
				hAxis: {title: 'Year', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityyear<?=$categoryname?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityyear<?=$categoryname?>'));
			charttotalactivityyear<?=$categoryname?>.draw(data9<?=$categoryname?>, options9<?=$categoryname?>);
			
			
			<?
			if(isset($data['catuploads'][$categoryname])){
					echo "var data10".$categoryname." = new google.visualization.DataTable();
				data10".$categoryname.".addColumn('datetime', 'Date');
				data10".$categoryname.".addColumn('number', 'Uploads');
				data10".$categoryname.".addRows([";
				
					foreach(array_keys($data['catuploads'][$categoryname]) as $key){
						echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['catuploads'][$categoryname][$key]."]";
						if($key != end(array_keys($data['catuploads'][$categoryname]))) echo ",";
					}
				
				echo "]);

				var charttotaluploads".$categoryname." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaluploads".$categoryname."'));
				charttotaluploads".$categoryname.".draw(data10".$categoryname.", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow'}
					);
				
				var data11".$categoryname." = new google.visualization.DataTable();
				data11".$categoryname.".addColumn('datetime', 'Date');
				data11".$categoryname.".addColumn('number', 'Upload Bytes');
				data11".$categoryname.".addRows([";
				
					foreach(array_keys($data['catupsize'][$categoryname]) as $key){
						echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['catupsize'][$categoryname][$key]."]";
						if($key != end(array_keys($data['catupsize'][$categoryname]))) echo ",";
					}
				
				echo "]);

				var charttotalupsize".$categoryname." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalupsize".$categoryname."'));
				charttotalupsize".$categoryname.".draw(data11".$categoryname.", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow'}
					);";
					
				echo "var imgs".$categoryname." = new google.visualization.DataTable();
				imgs".$categoryname.".addColumn('string', 'Name');
				imgs".$categoryname.".addColumn('number', 'Size');
				imgs".$categoryname.".addColumn('datetime', 'Date');
				imgs".$categoryname.".addRows([";
					foreach(array_keys($data['catimages'][$categoryname]) as $key){
						echo "['".$data['catimages'][$categoryname][$key]."',";
						echo $data['imagesize'][$data['catimages'][$categoryname][$key]].",";
						echo "new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key).")]";
						
						if($key != end(array_keys($data['catimages'][$categoryname]))) echo ",";
					}
				echo "]);


				var imgtable".$categoryname." = new google.visualization.Table(document.getElementById('img_table".$categoryname."'));
				imgtable".$categoryname.".draw(imgs".$categoryname.", {showRowNumber: true});";
			}
			?>
			
			<?
			if(isset($data['cataveragevalue'][$categoryname])){
			
				echo "var data12".$categoryname." = new google.visualization.DataTable();
				data12".$categoryname.".addColumn('datetime', 'Date');
				data12".$categoryname.".addColumn('number', 'Average Grade');
				data12".$categoryname.".addRows([";
			
					foreach(array_keys($data['cataveragevalue'][$categoryname]) as $key){
						$date = $data['revisiondate'][$key];
						echo "[new Date(".
						date('Y', $date).", ".
						date('m', $date)." ,".
						date('d', $date)." ,".
						date('H', $date)." ,".
						date('i', $date)."), ".
						$data['cataveragevalue'][$categoryname][$key]."]";
						if($key != end(array_keys($data['cataveragevalue'][$categoryname]))) echo ",";
					}
				echo "]);

				var charttotalquality".$categoryname." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalquality".$categoryname."'));
				charttotalquality".$categoryname.".draw(data12".$categoryname.", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow'}
					);
				
				var data13".$categoryname." = new google.visualization.DataTable();
				data13".$categoryname.".addColumn('datetime', 'Date');
				data13".$categoryname.".addColumn('number', 'Bytes X Quality');
				data13".$categoryname.".addColumn('number', 'Bytes');
				data13".$categoryname.".addRows([";
					$result = 0;
					foreach(array_keys($data['catbytes'][$categoryname]) as $date){
						$rev = $data['daterevision'][$date];
						$grade = isset($data['cataveragevalue'][$categoryname][$rev])? $data['cataveragevalue'][$categoryname][$rev] : 5;
						
						$result += $data['totalbytesdiff'][$date] + ($grade - 5) * ($data['totalbytesdiff'][$date]/5);
						echo "[new Date(".
						date('Y', $date).", ".
						date('m', $date)." ,".
						date('d', $date)." ,".
						date('H', $date)." ,".
						date('i', $date)."), ".
						$result.", ".
						$data['catbytes'][$categoryname][$date].
						"]";
						if($date != end(array_keys($data['catbytes'][$categoryname]))) echo ",";
					}
				echo "]);
				
				var charttotalbytesxquality".$categoryname." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytesxquality".$categoryname."'));
				charttotalbytesxquality".$categoryname.".draw(data13".$categoryname.", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow'}
					);";
			}
			?>
			
			var data<?=$categoryname?> = new google.visualization.DataTable();
			data<?=$categoryname?>.addColumn('string', 'Nick');
			data<?=$categoryname?>.addColumn('string', 'Name');
			data<?=$categoryname?>.addColumn('number', 'Edits');
			data<?=$categoryname?>.addColumn('number', 'Edits %');
			data<?=$categoryname?>.addColumn('number', 'Bytes');
			data<?=$categoryname?>.addColumn('number', 'Bytes %');
			data<?=$categoryname?>.addRows([
			<? 
				foreach(array_keys($data['catuser'][$categoryname]) as $key){
					echo "['".$key."','".
						$data['userrealname'][$key]."',".
						round(end($data['catuseredits'][$categoryname][$key]), 2).",".
						round(end($data['catuseredits'][$categoryname][$key])/end($data['catedits'][$categoryname]), 2).",";
					if(end($data['catbytes'][$categoryname]) != 0){
						echo round(end($data['catuserbytes'][$categoryname][$key]), 2).",".
						round(end($data['catuserbytes'][$categoryname][$key])/end($data['catbytes'][$categoryname]), 2);
					}else
						echo "0, 0";
						
					echo "]\n";
					
					if($key != end(array_keys($data['catuser'][$categoryname]))) echo ",";
				}
			?>
			]);


			var table<?=$categoryname?> = new google.visualization.Table(document.getElementById('user_table<?=$categoryname?>'));
			table<?=$categoryname?>.draw(data<?=$categoryname?>, {showRowNumber: true});
			
		}
	</script>
	
<!-- CHARTS -->
	<table id = "charttable">
	<tr>
		<th><?=lang('voc.i18n_edits_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotaledits<?=$categoryname?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_content_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytes<?=$categoryname?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id='charttotalusers<?=$categoryname?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_pages')?></th>
	</tr>
	<tr>
		<td><div id='charttotalpages<?=$categoryname?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_hour')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityhour<?=$categoryname?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_wday')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitywday<?=$categoryname?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_week')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityweek<?=$categoryname?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_month')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitymonth<?=$categoryname?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_year')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityyear<?=$categoryname?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<? if (!isset($data['catuploads'][$categoryname])) echo "<!--";?>
	<tr>
		<th><?=lang('voc.i18n_uploads')?></th>
	</tr>
	<tr>
		<td><div id='charttotaluploads<?=$categoryname?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_upsize')?></th>
	</tr>
	<tr>
		<td><div id='charttotalupsize<?=$categoryname?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<? if (!isset($data['catuploads'][$categoryname])) echo "-->";?>
	<? if (!isset($data['cataveragevalue'][$categoryname])) echo "<!--";?>
	<tr>
		<th><?=lang('voc.i18n_average_quality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalquality<?=$categoryname?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_bytesxquality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytesxquality<?=$categoryname?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_hourquality')?></th>
	</tr>
	<tr>
		<td><div id='qualityhourchart<?=$categoryname?>' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<? if (!isset($data['cataveragevalue'][$categoryname])) echo "-->";?>
	</table>
	
	<br><br>
	
	<table id = "charttable">
	<tr>
		<th><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id = "user_table<?=$categoryname?>"></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<? if(!isset($data['catimages'][$categoryname])) echo "<!--";?>
	<table id = "charttable">
	<tr>
		<th><?=lang('voc.i18n_images')?></th>
	</tr>
	<tr>
		<td><div id = "img_table<?=$categoryname?>"></div></td>
	</tr>
	</table>
	<? if(!isset($data['catimages'][$categoryname])) echo "-->";?>
			
<!-- [2] www.christophermonnat.com/2008/08/generating-pdf-files-using-codeigniter -->
<!--[2] TO_DO: generate pdf-->