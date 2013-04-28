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


<h3><?=$pagename?></h3>

<!-- CHARTS -->
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_edits_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotaledits<?=$data['pageid'][rawurldecode($pagename)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px;  margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_content_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytes<?=$data['pageid'][rawurldecode($pagename)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px;  margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id='charttotalusers<?=$data['pageid'][rawurldecode($pagename)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px;  margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_activity_hour')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityhour<?=$data['pageid'][rawurldecode($pagename)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px;  margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_activity_wday')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitywday<?=$data['pageid'][rawurldecode($pagename)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px;  margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_activity_week')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityweek<?=$data['pageid'][rawurldecode($pagename)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px;  margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_activity_month')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitymonth<?=$data['pageid'][rawurldecode($pagename)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px;  margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_activity_year')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityyear<?=$data['pageid'][rawurldecode($pagename)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px;  margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<? if (!isset($data['pageuploads'][rawurldecode($pagename)])) echo "<!--";?>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_uploads')?></th>
	</tr>
	<tr>
		<td><div id='charttotaluploads<?=$data['pageid'][rawurldecode($pagename)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px;  margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_upsize')?></th>
	</tr>
	<tr>
		<td><div id='charttotalupsize<?=$data['pageid'][rawurldecode($pagename)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px;  margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<? if (!isset($data['pageuploads'][rawurldecode($pagename)])) echo "-->";?>
	<? if (!isset($data['pageaveragevalue'][rawurldecode($pagename)])) echo "<!--";?>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_average_quality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalquality<?=$data['pageid'][rawurldecode($pagename)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px;  margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_bytesxquality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytesxquality<?=$data['pageid'][rawurldecode($pagename)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px;  margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_hourquality')?></th>
	</tr>
	<tr>
		<td><div id='qualityhourchart<?=$data['pageid'][rawurldecode($pagename)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px;  margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	<? if (!isset($data['pageaveragevalue'][rawurldecode($pagename)])) echo "-->";?>
	
	<tr>
		<th class = 'only'><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id = "user_table<?=$data['pageid'][rawurldecode($pagename)]?>"></div></td>
	</tr>
	
	<? if(!isset($data['pagecat'][rawurldecode($pagename)])) echo "<!--";?>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_categories')?></th>
	</tr>
	<tr>
		<td><div id = "categories_table<?=$data['pageid'][rawurldecode($pagename)]?>"></div></td>
	</tr>
	<? if(!isset($data['pagecat'][rawurldecode($pagename)])) echo "-->";?>
	</table>
	
	
	<!-- CHARTS SCRIPTS -->

	
	<script type='text/javascript'>
		google.load('visualization', '1', {'packages':['annotatedtimeline', 'corechart', 'table']});
		function drawChart<?=$data['pageid'][rawurldecode($pagename)]?>() {
			var data1<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.DataTable();
			data1<?=$data['pageid'][rawurldecode($pagename)]?>.addColumn('datetime', 'Date');
			data1<?=$data['pageid'][rawurldecode($pagename)]?>.addColumn('number', 'Editions');
			data1<?=$data['pageid'][rawurldecode($pagename)]?>.addRows([
			<?
				foreach(array_keys($data['pageedits'][rawurldecode($pagename)]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['pageedits'][rawurldecode($pagename)][$key].
						"]";
					if($key != end(array_keys($data['pageedits'][rawurldecode($pagename)]))) echo ",";
				}
			?>
			]);

			var chartedits<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaledits<?=$data['pageid'][rawurldecode($pagename)]?>'));
			chartedits<?=$data['pageid'][rawurldecode($pagename)]?>.draw(data1<?=$data['pageid'][rawurldecode($pagename)]?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
			
			
			var data2<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.DataTable();
			data2<?=$data['pageid'][rawurldecode($pagename)]?>.addColumn('datetime', 'Date');
			data2<?=$data['pageid'][rawurldecode($pagename)]?>.addColumn('number', 'Bytes');
			data2<?=$data['pageid'][rawurldecode($pagename)]?>.addRows([
			<?
				foreach(array_keys($data['pagebytes'][rawurldecode($pagename)]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['pagebytes'][rawurldecode($pagename)][$key].
					"]";
					if($key != end(array_keys($data['pagebytes'][rawurldecode($pagename)]))) echo ",";
				}
			?>
			]);

			var chartbytes<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytes<?=$data['pageid'][rawurldecode($pagename)]?>'));
			chartbytes<?=$data['pageid'][rawurldecode($pagename)]?>.draw(data2<?=$data['pageid'][rawurldecode($pagename)]?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
                                
                        var data4<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.DataTable();
			data4<?=$data['pageid'][rawurldecode($pagename)]?>.addColumn('datetime', 'Date');
			data4<?=$data['pageid'][rawurldecode($pagename)]?>.addColumn('number', 'Users');
			data4<?=$data['pageid'][rawurldecode($pagename)]?>.addRows([
			<?
				foreach(array_keys($data['pageusercount'][rawurldecode($pagename)]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['pageusercount'][rawurldecode($pagename)][$key].
					"]";
					if($key != end(array_keys($data['pageusercount'][rawurldecode($pagename)]))) echo ",";
				}
			?>
			]);

			var chartusers<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalusers<?=$data['pageid'][rawurldecode($pagename)]?>'));
			chartusers<?=$data['pageid'][rawurldecode($pagename)]?>.draw(data4<?=$data['pageid'][rawurldecode($pagename)]?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'
                                }
                        );
                        
                        
                        var data5<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.arrayToDataTable([
				['Hour', 'Editions'],
			<?
				foreach(array_keys($data['pageactivityhour'][rawurldecode($pagename)]) as $key){
					echo "[".$key.", ".
					$data['pageactivityhour'][rawurldecode($pagename)][$key].
					"]";
					if($key != end(array_keys($data['pageactivityhour'][rawurldecode($pagename)]))) echo ",";
				}
			?>
			]);
			
			var options5<?=$data['pageid'][rawurldecode($pagename)]?> = {
				hAxis: {title: 'Hour', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityhour<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityhour<?=$data['pageid'][rawurldecode($pagename)]?>'));
			charttotalactivityhour<?=$data['pageid'][rawurldecode($pagename)]?>.draw(data5<?=$data['pageid'][rawurldecode($pagename)]?>, options5<?=$data['pageid'][rawurldecode($pagename)]?>);
			
			
			var data6<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.arrayToDataTable([
				['Week Day', 'Editions'],
			<?
				foreach(array_keys($data['pageactivitywday'][rawurldecode($pagename)]) as $key){
					echo "['".$key."', ".
					$data['pageactivitywday'][rawurldecode($pagename)][$key].
					"]";
					if($key != end(array_keys($data['pageactivitywday'][rawurldecode($pagename)]))) echo ",";
				}
			?>
			]);
			
			var options6<?=$data['pageid'][rawurldecode($pagename)]?> = {
				hAxis: {title: 'Week Day', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivitywday<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivitywday<?=$data['pageid'][rawurldecode($pagename)]?>'));
			charttotalactivitywday<?=$data['pageid'][rawurldecode($pagename)]?>.draw(data6<?=$data['pageid'][rawurldecode($pagename)]?>, options6<?=$data['pageid'][rawurldecode($pagename)]?>);
			
			
			var data7<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.arrayToDataTable([
				['Week', 'Editions'],
			<?
				foreach(array_keys($data['pageactivityweek'][rawurldecode($pagename)]) as $key){
					echo "['".$key."', ".
					$data['pageactivityweek'][rawurldecode($pagename)][$key].
					"]";
					if($key != end(array_keys($data['pageactivityweek'][rawurldecode($pagename)]))) echo ",";
				}
			?>
			]);
			
			var options7<?=$data['pageid'][rawurldecode($pagename)]?> = {
				hAxis: {title: 'Week', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityweek<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityweek<?=$data['pageid'][rawurldecode($pagename)]?>'));
			charttotalactivityweek<?=$data['pageid'][rawurldecode($pagename)]?>.draw(data7<?=$data['pageid'][rawurldecode($pagename)]?>, options7<?=$data['pageid'][rawurldecode($pagename)]?>);
			
			var data8<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.arrayToDataTable([
				['Month', 'Editions'],
			<?
				foreach(array_keys($data['pageactivitymonth'][rawurldecode($pagename)]) as $key){
					echo "['".$key."', ".
					$data['pageactivitymonth'][rawurldecode($pagename)][$key].
					"]";
					if($key != end(array_keys($data['pageactivitymonth'][rawurldecode($pagename)]))) echo ",";
				}
			?>
			]);
			
			var options8<?=$data['pageid'][rawurldecode($pagename)]?> = {
				hAxis: {title: 'Month', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivitymonth<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivitymonth<?=$data['pageid'][rawurldecode($pagename)]?>'));
			charttotalactivitymonth<?=$data['pageid'][rawurldecode($pagename)]?>.draw(data8<?=$data['pageid'][rawurldecode($pagename)]?>, options8<?=$data['pageid'][rawurldecode($pagename)]?>);
			
			var data9<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.arrayToDataTable([
				['Year', 'Editions'],
			<?
				foreach(array_keys($data['pageactivityyear'][rawurldecode($pagename)]) as $key){
					echo "['".$key."', ".
					$data['pageactivityyear'][rawurldecode($pagename)][$key].
					"]";
					if($key != end(array_keys($data['pageactivityyear'][rawurldecode($pagename)]))) echo ",";
				}
			?>
			]);
			
			var options9<?=$data['pageid'][rawurldecode($pagename)]?> = {
				hAxis: {title: 'Year', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityyear<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityyear<?=$data['pageid'][rawurldecode($pagename)]?>'));
			charttotalactivityyear<?=$data['pageid'][rawurldecode($pagename)]?>.draw(data9<?=$data['pageid'][rawurldecode($pagename)]?>, options9<?=$data['pageid'][rawurldecode($pagename)]?>);
			<?
			if(isset($data['pageuploads'][rawurldecode($pagename)])){
					echo "var data10".$data['pageid'][rawurldecode($pagename)]." = new google.visualization.DataTable();
				data10".$data['pageid'][rawurldecode($pagename)].".addColumn('datetime', 'Date');
				data10".$data['pageid'][rawurldecode($pagename)].".addColumn('number', 'Uploads');
				data10".$data['pageid'][rawurldecode($pagename)].".addRows([";
				
					foreach(array_keys($data['pageuploads'][rawurldecode($pagename)]) as $key){
						echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['pageuploads'][rawurldecode($pagename)][$key]."]";
						if($key != end(array_keys($data['pageuploads'][rawurldecode($pagename)]))) echo ",";
					}
				
				echo "]);

				var charttotaluploads".$data['pageid'][rawurldecode($pagename)]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaluploads".$data['pageid'][rawurldecode($pagename)]."'));
				charttotaluploads".$data['pageid'][rawurldecode($pagename)].".draw(data10".$data['pageid'][rawurldecode($pagename)].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow',
					'wmode': 'transparent'}
					);
				
				var data11".$data['pageid'][rawurldecode($pagename)]." = new google.visualization.DataTable();
				data11".$data['pageid'][rawurldecode($pagename)].".addColumn('datetime', 'Date');
				data11".$data['pageid'][rawurldecode($pagename)].".addColumn('number', 'Upload Bytes');
				data11".$data['pageid'][rawurldecode($pagename)].".addRows([";
				
					foreach(array_keys($data['pageupsize'][rawurldecode($pagename)]) as $key){
						echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['pageupsize'][rawurldecode($pagename)][$key]."]";
						if($key != end(array_keys($data['pageupsize'][rawurldecode($pagename)]))) echo ",";
					}
				
				echo "]);

				var charttotalupsize".$data['pageid'][rawurldecode($pagename)]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalupsize".$data['pageid'][rawurldecode($pagename)]."'));
				charttotalupsize".$data['pageid'][rawurldecode($pagename)].".draw(data11".$data['pageid'][rawurldecode($pagename)].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow',
					'wmode': 'transparent'}
					);";
			}
			?>
			
			<?
			if(isset($data['pageaveragevalue'][rawurldecode($pagename)])){
			
				echo "var data12".$data['pageid'][rawurldecode($pagename)]." = new google.visualization.DataTable();
				data12".$data['pageid'][rawurldecode($pagename)].".addColumn('datetime', 'Date');
				data12".$data['pageid'][rawurldecode($pagename)].".addColumn('number', 'Average Grade');
				data12".$data['pageid'][rawurldecode($pagename)].".addRows([";
			
					foreach(array_keys($data['pageaveragevalue'][rawurldecode($pagename)]) as $key){
						$date = $data['revisiondate'][$key];
						echo "[new Date(".
						date('Y', $date).", ".
						date('m', $date)." ,".
						date('d', $date)." ,".
						date('H', $date)." ,".
						date('i', $date)."), ".
						$data['pageaveragevalue'][rawurldecode($pagename)][$key]."]";
						if($key != end(array_keys($data['pageaveragevalue'][rawurldecode($pagename)]))) echo ",";
					}
				echo "]);

				var charttotalquality".$data['pageid'][rawurldecode($pagename)]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalquality".$data['pageid'][rawurldecode($pagename)]."'));
				charttotalquality".$data['pageid'][rawurldecode($pagename)].".draw(data12".$data['pageid'][rawurldecode($pagename)].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow',
					'wmode': 'transparent'}
					);
				
				var data13".$data['pageid'][rawurldecode($pagename)]." = new google.visualization.DataTable();
				data13".$data['pageid'][rawurldecode($pagename)].".addColumn('datetime', 'Date');
				data13".$data['pageid'][rawurldecode($pagename)].".addColumn('number', 'Bytes X Quality');
				data13".$data['pageid'][rawurldecode($pagename)].".addColumn('number', 'Bytes');
				data13".$data['pageid'][rawurldecode($pagename)].".addRows([";
					$result = 0;
					foreach(array_keys($data['pagebytes'][rawurldecode($pagename)]) as $date){
						$rev = $data['daterevision'][$date];
						$grade = isset($data['pageaveragevalue'][rawurldecode($pagename)][$rev])? $data['pageaveragevalue'][rawurldecode($pagename)][$rev] : 5;
						
						$result += $data['totalbytesdiff'][$date] + ($grade - 5) * ($data['totalbytesdiff'][$date]/5);
						echo "[new Date(".
						date('Y', $date).", ".
						date('m', $date)." ,".
						date('d', $date)." ,".
						date('H', $date)." ,".
						date('i', $date)."), ".
						$result.", ".
						$data['pagebytes'][rawurldecode($pagename)][$date].
						"]";
						if($date != end(array_keys($data['pagebytes'][rawurldecode($pagename)]))) echo ",";
					}
				echo "]);
				
				var charttotalbytesxquality".$data['pageid'][rawurldecode($pagename)]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytesxquality".$data['pageid'][rawurldecode($pagename)]."'));
				charttotalbytesxquality".$data['pageid'][rawurldecode($pagename)].".draw(data13".$data['pageid'][rawurldecode($pagename)].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow',
					'wmode': 'transparent'}
					);
				
				var data14".$data['pageid'][rawurldecode($pagename)]." = new google.visualization.DataTable();
				data14".$data['pageid'][rawurldecode($pagename)].".addColumn('number', 'Hour');
				data14".$data['pageid'][rawurldecode($pagename)].".addColumn('number', 'Quality');
				data14".$data['pageid'][rawurldecode($pagename)].".addRows([";
					foreach(array_keys($data['pagegrades'][rawurldecode($pagename)]) as $revision){
						$date = $data['revisiondate'][$revision];
						$accum[date('H', $date)] = 0;
						$nrevs[date('H', $date)] = 0;
					}
					
					foreach(array_keys($data['pagegrades'][rawurldecode($pagename)]) as $revision){
						$date = $data['revisiondate'][$revision];
						$grade = $data['pagegrades'][rawurldecode($pagename)][$revision];
						$accum[date('H', $date)] += $grade;
						$nrevs[date('H', $date)] += 1;
					}
					
					foreach(array_keys($accum) as $hour){
						echo "[".$hour.", ".($accum[$hour]/$nrevs[$hour])."]";
						if($hour != end(array_keys($accum))) echo ",";
					}
				echo "]);
				
				var options".$data['pageid'][rawurldecode($pagename)]." = {
					hAxis: {title: 'Hour', titleTextStyle: {data: 'green'}},
					vAxis: {title: 'Quality', titleTextStyle: {data: 'green'}, minValue:0}
				};
				
				var chartqualityhour".$data['pageid'][rawurldecode($pagename)]." = new google.visualization.ScatterChart(document.getElementById('qualityhourchart".$data['pageid'][rawurldecode($pagename)]."'));
				chartqualityhour".$data['pageid'][rawurldecode($pagename)].".draw(data14".$data['pageid'][rawurldecode($pagename)].", options".$data['pageid'][rawurldecode($pagename)].");";
			}
			?>
			
			var data<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.DataTable();
			data<?=$data['pageid'][rawurldecode($pagename)]?>.addColumn('string', 'Nick');
			data<?=$data['pageid'][rawurldecode($pagename)]?>.addColumn('string', 'Name');
			data<?=$data['pageid'][rawurldecode($pagename)]?>.addColumn('number', 'Edits');
			data<?=$data['pageid'][rawurldecode($pagename)]?>.addColumn('number', 'Edits %');
			data<?=$data['pageid'][rawurldecode($pagename)]?>.addColumn('number', 'Bytes');
			data<?=$data['pageid'][rawurldecode($pagename)]?>.addColumn('number', 'Bytes %');
			data<?=$data['pageid'][rawurldecode($pagename)]?>.addColumn('number', 'Average Grade');
			data<?=$data['pageid'][rawurldecode($pagename)]?>.addColumn('number', 'Standard Deviation');
			data<?=$data['pageid'][rawurldecode($pagename)]?>.addRows([
			<? 
				foreach(array_keys($data['pageuser'][rawurldecode($pagename)]) as $key){
					echo "['".anchor("filters_form/filter/".$this->session->userdata('analysis')."/user/".$key, $key, array('target' => '_blank'))."','".
						$data['userrealname'][rawurldecode($key)]."',".
						round(end($data['pageuseredits'][rawurldecode($pagename)][$key]), 2).",".
						round(end($data['pageusereditscount'][rawurldecode($pagename)][$key])/end($data['pageedits'][rawurldecode($pagename)]), 2).",";
					if(end($data['pagebytes'][rawurldecode($pagename)]) != 0){
						echo round(end($data['pageuserbytes'][rawurldecode($pagename)][$key]), 2).",".
						round(end($data['pageuserbytescount'][rawurldecode($pagename)][$key])/end($data['pagebytes'][rawurldecode($pagename)]), 2);
					}else
						echo "0, 0";
					
					if(isset($data['pageuseraveragevalue'][rawurldecode($pagename)][$key])) 
						echo ", ".round(end($data['pageuseraveragevalue'][rawurldecode($pagename)][$key]), 2).",".
							round(end($data['pageusersd'][rawurldecode($pagename)][$key]), 2);
					else
						echo ", -1, -1";
						
					echo "]\n";
					
					if($key != end(array_keys($data['pageuser'][rawurldecode($pagename)]))) echo ",";
				}
			?>
			]);


			var table<?=$data['pageid'][rawurldecode($pagename)]?> = new google.visualization.Table(document.getElementById('user_table<?=$data['pageid'][rawurldecode($pagename)]?>'));
			table<?=$data['pageid'][rawurldecode($pagename)]?>.draw(data<?=$data['pageid'][rawurldecode($pagename)]?>, {
						showRowNumber: true,
						page: 'enable',
						allowHtml: true,
						pageSize: 20});
			
			<?
			if(isset($data['pagecat'][rawurldecode($pagename)])){
				echo "var catdata".$data['pageid'][rawurldecode($pagename)]." = new google.visualization.DataTable();
				catdata".$data['pageid'][rawurldecode($pagename)].".addColumn('string', 'Name');
				catdata".$data['pageid'][rawurldecode($pagename)].".addRows([";
					foreach(array_keys($data['pagecat'][rawurldecode($pagename)]) as $key){
						echo "['".anchor("filters_form/filter/".$this->session->userdata('analysis')."/category/".$key, $key, array('target' => '_blank'))."']\n";
						
						if($key != end(array_keys($data['pagecat'][rawurldecode($pagename)]))) echo ",";
					}
				echo "]);


				var cattable".$data['pageid'][rawurldecode($pagename)]." = new google.visualization.Table(document.getElementById('categories_table".$data['pageid'][rawurldecode($pagename)]."'));
				cattable".$data['pageid'][rawurldecode($pagename)].".draw(catdata".$data['pageid'][rawurldecode($pagename)].", {
						showRowNumber: true,
						page: 'enable',
						allowHtml: true,
						pageSize: 20});";
			}
			?>
		}
	</script>
	
	<script>drawChart<?=$data['pageid'][rawurldecode($pagename)]?>();</script>