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


<!-- CHARTS -->
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_edits_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotaledits<?=$data['catid'][$categoryname]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_content_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytes<?=$data['catid'][$categoryname]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id='charttotalusers<?=$data['catid'][$categoryname]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_pages')?></th>
	</tr>
	<tr>
		<td><div id='charttotalpages<?=$data['catid'][$categoryname]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_activity_hour')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityhour<?=$data['catid'][$categoryname]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_activity_wday')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitywday<?=$data['catid'][$categoryname]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_activity_week')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityweek<?=$data['catid'][$categoryname]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_activity_month')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitymonth<?=$data['catid'][$categoryname]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_activity_year')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityyear<?=$data['catid'][$categoryname]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<? if (!isset($data['catuploads'][$categoryname])) echo "<!--";?>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_uploads')?></th>
	</tr>
	<tr>
		<td><div id='charttotaluploads<?=$data['catid'][$categoryname]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_upsize')?></th>
	</tr>
	<tr>
		<td><div id='charttotalupsize<?=$data['catid'][$categoryname]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<? if (!isset($data['catuploads'][$categoryname])) echo "-->";?>
	<? if (!isset($data['cataveragevalue'][$categoryname])) echo "<!--";?>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_average_quality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalquality<?=$data['catid'][$categoryname]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_bytesxquality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytesxquality<?=$data['catid'][$categoryname]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<? if (!isset($data['cataveragevalue'][$categoryname])) echo "-->";?>
	
	<tr>
		<th class = 'only'><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id = "user_table<?=$data['catid'][$categoryname]?>"></div></td>
	</tr>
	
	<? if(!isset($data['catimages'][$categoryname])) echo "<!--";?>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_images')?></th>
	</tr>
	<tr>
		<td><div id = "img_table<?=$data['catid'][$categoryname]?>"></div></td>
	</tr>
	<? if(!isset($data['catimages'][$categoryname])) echo "-->";?>
	</table>
	
	
	<!-- CHARTS SCRIPTS -->


	<script type='text/javascript'>
		google.load('visualization', '1', {'packages':['annotatedtimeline', 'corechart', 'table']});
		function drawChart<?=$data['catid'][$categoryname]?>() {
			var data1<?=$data['catid'][$categoryname]?> = new google.visualization.DataTable();
			data1<?=$data['catid'][$categoryname]?>.addColumn('datetime', 'Date');
			data1<?=$data['catid'][$categoryname]?>.addColumn('number', 'Editions');
			data1<?=$data['catid'][$categoryname]?>.addRows([
			<?
				foreach(array_keys($data['catedits'][$categoryname]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['catedits'][$categoryname][$key].
						"]";
					if($key != end(array_keys($data['catedits'][$categoryname]))) echo ",";
				}
			?>
			]);

			var chartedits<?=$data['catid'][$categoryname]?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaledits<?=$data['catid'][$categoryname]?>'));
			chartedits<?=$data['catid'][$categoryname]?>.draw(data1<?=$data['catid'][$categoryname]?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
			
			
			var data2<?=$data['catid'][$categoryname]?> = new google.visualization.DataTable();
			data2<?=$data['catid'][$categoryname]?>.addColumn('datetime', 'Date');
			data2<?=$data['catid'][$categoryname]?>.addColumn('number', 'Bytes');
			data2<?=$data['catid'][$categoryname]?>.addRows([
			<?
				foreach(array_keys($data['catbytes'][$categoryname]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['catbytes'][$categoryname][$key].
					"]";
					if($key != end(array_keys($data['catbytes'][$categoryname]))) echo ",";
				}
			?>
			]);

			var chartbytes<?=$data['catid'][$categoryname]?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytes<?=$data['catid'][$categoryname]?>'));
			chartbytes<?=$data['catid'][$categoryname]?>.draw(data2<?=$data['catid'][$categoryname]?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
                                
                        var data4<?=$data['catid'][$categoryname]?> = new google.visualization.DataTable();
			data4<?=$data['catid'][$categoryname]?>.addColumn('datetime', 'Date');
			data4<?=$data['catid'][$categoryname]?>.addColumn('number', 'Users');
			data4<?=$data['catid'][$categoryname]?>.addRows([
			<?
				foreach(array_keys($data['catusers'][$categoryname]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['catusers'][$categoryname][$key].
					"]";
					if($key != end(array_keys($data['catusers'][$categoryname]))) echo ",";
				}
			?>
			]);

			var chartusers<?=$data['catid'][$categoryname]?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalusers<?=$data['catid'][$categoryname]?>'));
			chartusers<?=$data['catid'][$categoryname]?>.draw(data4<?=$data['catid'][$categoryname]?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'
                                }
                        );
                        
                        var data3<?=$data['catid'][$categoryname]?> = new google.visualization.DataTable();
			data3<?=$data['catid'][$categoryname]?>.addColumn('datetime', 'Date');
			data3<?=$data['catid'][$categoryname]?>.addColumn('number', 'Pages');
			data3<?=$data['catid'][$categoryname]?>.addRows([
			<?
				foreach(array_keys($data['catpages'][$categoryname]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['catpages'][$categoryname][$key].
					"]";
					if($key != end(array_keys($data['catpages'][$categoryname]))) echo ",";
				}
			?>
			]);

			var chartpages<?=$data['catid'][$categoryname]?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalpages<?=$data['catid'][$categoryname]?>'));
			chartpages<?=$data['catid'][$categoryname]?>.draw(data4<?=$data['catid'][$categoryname]?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'
                                }
                        );
                        
                        var data5<?=$data['catid'][$categoryname]?> = new google.visualization.arrayToDataTable([
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
			
			var options5<?=$data['catid'][$categoryname]?> = {
				hAxis: {title: 'Hour', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityhour<?=$data['catid'][$categoryname]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityhour<?=$data['catid'][$categoryname]?>'));
			charttotalactivityhour<?=$data['catid'][$categoryname]?>.draw(data5<?=$data['catid'][$categoryname]?>, options5<?=$data['catid'][$categoryname]?>);
			
			
			var data6<?=$data['catid'][$categoryname]?> = new google.visualization.arrayToDataTable([
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
			
			var options6<?=$data['catid'][$categoryname]?> = {
				hAxis: {title: 'Week Day', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivitywday<?=$data['catid'][$categoryname]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivitywday<?=$data['catid'][$categoryname]?>'));
			charttotalactivitywday<?=$data['catid'][$categoryname]?>.draw(data6<?=$data['catid'][$categoryname]?>, options6<?=$data['catid'][$categoryname]?>);
			
			
			var data7<?=$data['catid'][$categoryname]?> = new google.visualization.arrayToDataTable([
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
			
			var options7<?=$data['catid'][$categoryname]?> = {
				hAxis: {title: 'Week', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityweek<?=$data['catid'][$categoryname]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityweek<?=$data['catid'][$categoryname]?>'));
			charttotalactivityweek<?=$data['catid'][$categoryname]?>.draw(data7<?=$data['catid'][$categoryname]?>, options7<?=$data['catid'][$categoryname]?>);
			
			var data8<?=$data['catid'][$categoryname]?> = new google.visualization.arrayToDataTable([
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
			
			var options8<?=$data['catid'][$categoryname]?> = {
				hAxis: {title: 'Month', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivitymonth<?=$data['catid'][$categoryname]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivitymonth<?=$data['catid'][$categoryname]?>'));
			charttotalactivitymonth<?=$data['catid'][$categoryname]?>.draw(data8<?=$data['catid'][$categoryname]?>, options8<?=$data['catid'][$categoryname]?>);
			
			var data9<?=$data['catid'][$categoryname]?> = new google.visualization.arrayToDataTable([
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
			
			var options9<?=$data['catid'][$categoryname]?> = {
				hAxis: {title: 'Year', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityyear<?=$data['catid'][$categoryname]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityyear<?=$data['catid'][$categoryname]?>'));
			charttotalactivityyear<?=$data['catid'][$categoryname]?>.draw(data9<?=$data['catid'][$categoryname]?>, options9<?=$data['catid'][$categoryname]?>);
			
			
			<?
			if(isset($data['catuploads'][$categoryname])){
					echo "var data10".$data['catid'][$categoryname]." = new google.visualization.DataTable();
				data10".$data['catid'][$categoryname].".addColumn('datetime', 'Date');
				data10".$data['catid'][$categoryname].".addColumn('number', 'Uploads');
				data10".$data['catid'][$categoryname].".addRows([";
				
					foreach(array_keys($data['catuploads'][$categoryname]) as $key){
						echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['catuploads'][$categoryname][$key]."]";
						if($key != end(array_keys($data['catuploads'][$categoryname]))) echo ",";
					}
				
				echo "]);

				var charttotaluploads".$data['catid'][$categoryname]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaluploads".$data['catid'][$categoryname]."'));
				charttotaluploads".$data['catid'][$categoryname].".draw(data10".$data['catid'][$categoryname].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow',
					'wmode': 'transparent'}
					);
				
				var data11".$data['catid'][$categoryname]." = new google.visualization.DataTable();
				data11".$data['catid'][$categoryname].".addColumn('datetime', 'Date');
				data11".$data['catid'][$categoryname].".addColumn('number', 'Upload Bytes');
				data11".$data['catid'][$categoryname].".addRows([";
				
					foreach(array_keys($data['catupsize'][$categoryname]) as $key){
						echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['catupsize'][$categoryname][$key]."]";
						if($key != end(array_keys($data['catupsize'][$categoryname]))) echo ",";
					}
				
				echo "]);

				var charttotalupsize".$data['catid'][$categoryname]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalupsize".$data['catid'][$categoryname]."'));
				charttotalupsize".$data['catid'][$categoryname].".draw(data11".$data['catid'][$categoryname].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow',
					'wmode': 'transparent'}
					);";
					
				echo "var imgs".$data['catid'][$categoryname]." = new google.visualization.DataTable();
				imgs".$data['catid'][$categoryname].".addColumn('string', 'Name');
				imgs".$data['catid'][$categoryname].".addColumn('number', 'Size');
				imgs".$data['catid'][$categoryname].".addColumn('datetime', 'Date');
				imgs".$data['catid'][$categoryname].".addRows([";
					foreach(array_keys($data['catimages'][$categoryname]) as $key){
						echo "['".$data['catimages'][$categoryname][$key]."',";
						echo $data['imagesize'][$data['catimages'][$categoryname][$key]].",";
						echo "new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key).")]";
						
						if($key != end(array_keys($data['catimages'][$categoryname]))) echo ",";
					}
				echo "]);


				var imgtable".$data['catid'][$categoryname]." = new google.visualization.Table(document.getElementById('img_table".$data['catid'][$categoryname]."'));
				imgtable".$data['catid'][$categoryname].".draw(imgs".$data['catid'][$categoryname].", {showRowNumber: true});";
			}
			?>
			
			<?
			if(isset($data['cataveragevalue'][$categoryname])){
			
				echo "var data12".$data['catid'][$categoryname]." = new google.visualization.DataTable();
				data12".$data['catid'][$categoryname].".addColumn('datetime', 'Date');
				data12".$data['catid'][$categoryname].".addColumn('number', 'Average Grade');
				data12".$data['catid'][$categoryname].".addRows([";
			
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

				var charttotalquality".$data['catid'][$categoryname]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalquality".$data['catid'][$categoryname]."'));
				charttotalquality".$data['catid'][$categoryname].".draw(data12".$data['catid'][$categoryname].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow',
					'wmode': 'transparent'}
					);
				
				var data13".$data['catid'][$categoryname]." = new google.visualization.DataTable();
				data13".$data['catid'][$categoryname].".addColumn('datetime', 'Date');
				data13".$data['catid'][$categoryname].".addColumn('number', 'Bytes X Quality');
				data13".$data['catid'][$categoryname].".addColumn('number', 'Bytes');
				data13".$data['catid'][$categoryname].".addRows([";
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
				
				var charttotalbytesxquality".$data['catid'][$categoryname]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytesxquality".$data['catid'][$categoryname]."'));
				charttotalbytesxquality".$data['catid'][$categoryname].".draw(data13".$data['catid'][$categoryname].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow',
					'wmode': 'transparent'}
					);";
			}
			?>
			
			var data<?=$data['catid'][$categoryname]?> = new google.visualization.DataTable();
			data<?=$data['catid'][$categoryname]?>.addColumn('string', 'Nick');
			data<?=$data['catid'][$categoryname]?>.addColumn('string', 'Name');
			data<?=$data['catid'][$categoryname]?>.addColumn('number', 'Edits');
			data<?=$data['catid'][$categoryname]?>.addColumn('number', 'Edits %');
			data<?=$data['catid'][$categoryname]?>.addColumn('number', 'Bytes');
			data<?=$data['catid'][$categoryname]?>.addColumn('number', 'Bytes %');
			data<?=$data['catid'][$categoryname]?>.addRows([
			<? 
				foreach(array_keys($data['catuser'][$categoryname]) as $key){
					echo "['".utf8_encode($key)."','".
						utf8_encode($data['userrealname'][$key])."',".
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


			var table<?=$data['catid'][$categoryname]?> = new google.visualization.Table(document.getElementById('user_table<?=$data['catid'][$categoryname]?>'));
			table<?=$data['catid'][$categoryname]?>.draw(data<?=$data['catid'][$categoryname]?>, {showRowNumber: true});
			
		}
	</script>
	
	<script>drawChart<?=$data['catid'][$categoryname]?>(); </script>