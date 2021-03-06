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

<script type="text/javascript" src="application/libraries/mbostock/prtovis.js"></script>
    <style type="text/css">

#fig {
  width: 880px;
  height: 400px;
}

    </style>

<a name = 'top'></a>
	
	<div id = 'chartmenu' style = 'width:800px; display:block; margin:auto;'>
		<table id = 'variabletable'>
		<tr>
			<th colspan = '4'><?=lang('voc.i18n_chart_menu')?></th></tr>
		</tr>
		<tr>
			<td><a href = '#charttotaledits'><?=lang('voc.i18n_edits_evolution')?></a></td>
			<td><a href = '#charttotalbytes'><?=lang('voc.i18n_content_evolution')?></a></td>
			<td><a href = '#charttotalusers'><?=lang('voc.i18n_users_evolution')?></a></td>
			<td><a href = '#charttotalpages'><?=lang('voc.i18n_pages_evolution')?></a></td>
		</tr>
		<tr>
			<td><a href = '#charttotalactivityhour'><?=lang('voc.i18n_activity_hour')?></a></td>
			<td><a href = '#charttotalactivitywday'><?=lang('voc.i18n_activity_wday')?></a></td>
			<td><a href = '#charttotalactivityweek'><?=lang('voc.i18n_activity_week')?></a></td>
			<td><a href = '#charttotalactivitymonth'><?=lang('voc.i18n_activity_month')?></a></td>
		</tr>
		<tr>
			<td><a href = '#charttotalactivityyear'><?=lang('voc.i18n_activity_year')?></a></td>
			<td><a href = '#charttotaluploads'><?=lang('voc.i18n_uploads')?></a></td>
			<td><a href = '#charttotalupsize'><?=lang('voc.i18n_upsize')?></a></td>
			<td><a href = '#charttotalquality'><?=lang('voc.i18n_average_quality')?></a></td>
		</tr>
		<tr>
			<td><a href = '#charttotalbytesxquality'><?=lang('voc.i18n_bytesxquality')?></a></td>
			<td><a href = '#user_table'><?=lang('voc.i18n_users_table')?></a></td>
			<td><a href = '#images_table'><?=lang('voc.i18n_images_table')?></a></td>
		</tr>
		</table>
	</div>
	
	<br><br>
	
<!-- CHARTS -->


<h3><?=$categoryname?></h3>

	<a name = 'charttotaledits'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_edits_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotaledits<?=$data['catid'][rawurldecode($categoryname)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	</table>
	<br>
	<table id = 'charttable'>
	<tr><a name = 'charttotalbytes'></a>
	
		<th class = 'only'><?=lang('voc.i18n_content_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytes<?=$data['catid'][rawurldecode($categoryname)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	</table>
	<br>
	<table id = 'charttable'>
	<tr><a name = 'charttotalusers'></a>
	
		<th class = 'only'><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id='charttotalusers<?=$data['catid'][rawurldecode($categoryname)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	</table>
	<br>
	<table id = 'charttable'>
	<tr><a name = 'charttotalpages'></a>
	
		<th class = 'only'><?=lang('voc.i18n_pages')?></th>
	</tr>
	<tr>
		<td><div id='charttotalpages<?=$data['catid'][rawurldecode($categoryname)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	</table>
	<br>
	<table id = 'charttable'>
	<tr><a name = 'charttotalactivityhour'></a>
	
		<th class = 'only'><?=lang('voc.i18n_activity_hour')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityhour<?=$data['catid'][rawurldecode($categoryname)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	</table>
	<br>
	<table id = 'charttable'>
	<tr><a name = 'charttotalactivitywday'></a>
	
		<th class = 'only'><?=lang('voc.i18n_activity_wday')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitywday<?=$data['catid'][rawurldecode($categoryname)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	</table>
	<br>
	<table id = 'charttable'>
	<tr><a name = 'charttotalactivityweek'></a>
	
		<th class = 'only'><?=lang('voc.i18n_activity_week')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityweek<?=$data['catid'][rawurldecode($categoryname)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	</table>
	<br>
	<table id = 'charttable'>
	<tr><a name = 'charttotalactivitymonth'></a>
	
		<th class = 'only'><?=lang('voc.i18n_activity_month')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitymonth<?=$data['catid'][rawurldecode($categoryname)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	</table>
	<br>
	<table id = 'charttable'>
	<tr><a name = 'charttotalactivityyear'></a>
	
		<th class = 'only'><?=lang('voc.i18n_activity_year')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityyear<?=$data['catid'][rawurldecode($categoryname)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	</table>
	<? if (!isset($data['catuploads'][rawurldecode($categoryname)])) echo "<!--";?>
	<br>
	<table id = 'charttable'>
	<tr><a name = 'charttotaluploads'></a>
	
		<th class = 'only'><?=lang('voc.i18n_uploads')?></th>
	</tr>
	<tr>
		<td><div id='charttotaluploads<?=$data['catid'][rawurldecode($categoryname)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	</table>
	<br>
	<table id = 'charttable'>
	<tr><a name = 'charttotalupsize'></a>
	
		<th class = 'only'><?=lang('voc.i18n_upsize')?></th>
	</tr>
	<tr>
		<td><div id='charttotalupsize<?=$data['catid'][rawurldecode($categoryname)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	</table>
	<? if (!isset($data['catuploads'][rawurldecode($categoryname)])) echo "-->";?>
	<? if (!isset($data['cataveragevalue'][rawurldecode($categoryname)])) echo "<!--";?>
	<br>
	<table id = 'charttable'>
	<tr><a name = 'charttotalquality'></a>
	
		<th class = 'only'><?=lang('voc.i18n_average_quality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalquality<?=$data['catid'][rawurldecode($categoryname)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	</table>
	<br>
	<table id = 'charttable'>
	<tr><a name = 'charttotalbytesxquality'></a>
	
		<th class = 'only'><?=lang('voc.i18n_bytesxquality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytesxquality<?=$data['catid'][rawurldecode($categoryname)]?>' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block; display: block; margin: 0 auto;'></div></td>
	</tr>
	</table>
	<? if (!isset($data['cataveragevalue'][rawurldecode($categoryname)])) echo "-->";?>
	<br>
	<table id = 'charttable'>
	
	<tr><a name = 'user_table'></a>
	
		<th class = 'only'><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id = "user_table<?=$data['catid'][rawurldecode($categoryname)]?>"></div></td>
	</tr>
	
	</table>
	<? if(!isset($data['catimages'][rawurldecode($categoryname)])) echo "<!--";?>
	
	<br>
	<table id = 'charttable'>
	<tr><a name = 'images_table'></a>
	
		<th class = 'only'><?=lang('voc.i18n_images')?></th>
	</tr>
	<tr>
		<td><div id = "img_table<?=$data['catid'][rawurldecode($categoryname)]?>"></div></td>
	</tr>
	<? if(!isset($data['catimages'][rawurldecode($categoryname)])) echo "-->";?>
	</table>
	
	<table id = 'charttable'>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_relations_graph')?></th>
	</tr>
	<tr>
		<td style = "text-align:center; width:100%;"><?=anchor("charts/relations_graph/$aname/category/$categoryname", lang('voc.i18n_open_relations_graph'), array('target' => '_blank'))?></td>
	</tr>
	</table>
	
	
	<!-- CHARTS SCRIPTS -->


	<script type='text/javascript'>
		google.load('visualization', '1', {'packages':['annotatedtimeline', 'corechart', 'table']});
		function drawChart<?=$data['catid'][rawurldecode($categoryname)]?>() {
			var data1<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.DataTable();
			data1<?=$data['catid'][rawurldecode($categoryname)]?>.addColumn('datetime', 'Date');
			data1<?=$data['catid'][rawurldecode($categoryname)]?>.addColumn('number', 'Editions');
			data1<?=$data['catid'][rawurldecode($categoryname)]?>.addRows([
			<?
				foreach(array_keys($data['catedits'][rawurldecode($categoryname)]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['catedits'][rawurldecode($categoryname)][$key]."]";
					if($key != end(array_keys($data['catedits'][rawurldecode($categoryname)]))) echo ",";
				}
			?>
			]);

			var chartedits<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaledits<?=$data['catid'][rawurldecode($categoryname)]?>'));
			chartedits<?=$data['catid'][rawurldecode($categoryname)]?>.draw(data1<?=$data['catid'][rawurldecode($categoryname)]?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
			
			
			var data2<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.DataTable();
			data2<?=$data['catid'][rawurldecode($categoryname)]?>.addColumn('datetime', 'Date');
			data2<?=$data['catid'][rawurldecode($categoryname)]?>.addColumn('number', 'Bytes');
			data2<?=$data['catid'][rawurldecode($categoryname)]?>.addRows([
			<?
				foreach(array_keys($data['catbytes'][rawurldecode($categoryname)]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['catbytes'][rawurldecode($categoryname)][$key].
					"]";
					if($key != end(array_keys($data['catbytes'][rawurldecode($categoryname)]))) echo ",";
				}
			?>
			]);

			var chartbytes<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytes<?=$data['catid'][rawurldecode($categoryname)]?>'));
			chartbytes<?=$data['catid'][rawurldecode($categoryname)]?>.draw(data2<?=$data['catid'][rawurldecode($categoryname)]?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
                                
                        var data4<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.DataTable();
			data4<?=$data['catid'][rawurldecode($categoryname)]?>.addColumn('datetime', 'Date');
			data4<?=$data['catid'][rawurldecode($categoryname)]?>.addColumn('number', 'Users');
			data4<?=$data['catid'][rawurldecode($categoryname)]?>.addRows([
			<?
				foreach(array_keys($data['catusers'][rawurldecode($categoryname)]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['catusers'][rawurldecode($categoryname)][$key].
					"]";
					if($key != end(array_keys($data['catusers'][rawurldecode($categoryname)]))) echo ",";
				}
			?>
			]);

			var chartusers<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalusers<?=$data['catid'][rawurldecode($categoryname)]?>'));
			chartusers<?=$data['catid'][rawurldecode($categoryname)]?>.draw(data4<?=$data['catid'][rawurldecode($categoryname)]?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'
                                }
                        );
                        
                        var data3<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.DataTable();
			data3<?=$data['catid'][rawurldecode($categoryname)]?>.addColumn('datetime', 'Date');
			data3<?=$data['catid'][rawurldecode($categoryname)]?>.addColumn('number', 'Pages');
			data3<?=$data['catid'][rawurldecode($categoryname)]?>.addRows([
			<?
				foreach(array_keys($data['catpages'][rawurldecode($categoryname)]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['catpages'][rawurldecode($categoryname)][$key].
					"]";
					if($key != end(array_keys($data['catpages'][rawurldecode($categoryname)]))) echo ",";
				}
			?>
			]);

			var chartpages<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalpages<?=$data['catid'][rawurldecode($categoryname)]?>'));
			chartpages<?=$data['catid'][rawurldecode($categoryname)]?>.draw(data4<?=$data['catid'][rawurldecode($categoryname)]?>, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'
                                }
                        );
                        
                        var data5<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.arrayToDataTable([
				['Hour', 'Editions'],
			<?
				foreach(array_keys($data['catactivityhour'][rawurldecode($categoryname)]) as $key){
					echo "[".$key.", ".
					$data['catactivityhour'][rawurldecode($categoryname)][$key].
					"]";
					if($key != end(array_keys($data['catactivityhour'][rawurldecode($categoryname)]))) echo ",";
				}
			?>
			]);
			
			var options5<?=$data['catid'][rawurldecode($categoryname)]?> = {
				hAxis: {title: 'Hour', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityhour<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityhour<?=$data['catid'][rawurldecode($categoryname)]?>'));
			charttotalactivityhour<?=$data['catid'][rawurldecode($categoryname)]?>.draw(data5<?=$data['catid'][rawurldecode($categoryname)]?>, options5<?=$data['catid'][rawurldecode($categoryname)]?>);
			
			
			var data6<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.arrayToDataTable([
				['Week Day', 'Editions'],
			<?
				foreach(array_keys($data['catactivitywday'][rawurldecode($categoryname)]) as $key){
					echo "['".$key."', ".
					$data['catactivitywday'][rawurldecode($categoryname)][$key].
					"]";
					if($key != end(array_keys($data['catactivitywday'][rawurldecode($categoryname)]))) echo ",";
				}
			?>
			]);
			
			var options6<?=$data['catid'][rawurldecode($categoryname)]?> = {
				hAxis: {title: 'Week Day', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivitywday<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivitywday<?=$data['catid'][rawurldecode($categoryname)]?>'));
			charttotalactivitywday<?=$data['catid'][rawurldecode($categoryname)]?>.draw(data6<?=$data['catid'][rawurldecode($categoryname)]?>, options6<?=$data['catid'][rawurldecode($categoryname)]?>);
			
			
			var data7<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.arrayToDataTable([
				['Week', 'Editions'],
			<?
				foreach(array_keys($data['catactivityweek'][rawurldecode($categoryname)]) as $key){
					echo "['".$key."', ".
					$data['catactivityweek'][rawurldecode($categoryname)][$key].
					"]";
					if($key != end(array_keys($data['catactivityweek'][rawurldecode($categoryname)]))) echo ",";
				}
			?>
			]);
			
			var options7<?=$data['catid'][rawurldecode($categoryname)]?> = {
				hAxis: {title: 'Week', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityweek<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityweek<?=$data['catid'][rawurldecode($categoryname)]?>'));
			charttotalactivityweek<?=$data['catid'][rawurldecode($categoryname)]?>.draw(data7<?=$data['catid'][rawurldecode($categoryname)]?>, options7<?=$data['catid'][rawurldecode($categoryname)]?>);
			
			var data8<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.arrayToDataTable([
				['Month', 'Editions'],
			<?
				foreach(array_keys($data['catactivitymonth'][rawurldecode($categoryname)]) as $key){
					echo "['".$key."', ".
					$data['catactivitymonth'][rawurldecode($categoryname)][$key].
					"]";
					if($key != end(array_keys($data['catactivitymonth'][rawurldecode($categoryname)]))) echo ",";
				}
			?>
			]);
			
			var options8<?=$data['catid'][rawurldecode($categoryname)]?> = {
				hAxis: {title: 'Month', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivitymonth<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivitymonth<?=$data['catid'][rawurldecode($categoryname)]?>'));
			charttotalactivitymonth<?=$data['catid'][rawurldecode($categoryname)]?>.draw(data8<?=$data['catid'][rawurldecode($categoryname)]?>, options8<?=$data['catid'][rawurldecode($categoryname)]?>);
			
			var data9<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.arrayToDataTable([
				['Year', 'Editions'],
			<?
				foreach(array_keys($data['catactivityyear'][rawurldecode($categoryname)]) as $key){
					echo "['".$key."', ".
					$data['catactivityyear'][rawurldecode($categoryname)][$key].
					"]";
					if($key != end(array_keys($data['catactivityyear'][rawurldecode($categoryname)]))) echo ",";
				}
			?>
			]);
			
			var options9<?=$data['catid'][rawurldecode($categoryname)]?> = {
				hAxis: {title: 'Year', titleTextStyle: {data: 'green'}},
				isStacked:true,
			};

			var charttotalactivityyear<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.ColumnChart(document.getElementById('charttotalactivityyear<?=$data['catid'][rawurldecode($categoryname)]?>'));
			charttotalactivityyear<?=$data['catid'][rawurldecode($categoryname)]?>.draw(data9<?=$data['catid'][rawurldecode($categoryname)]?>, options9<?=$data['catid'][rawurldecode($categoryname)]?>);
			
			
			<?
			if(isset($data['catuploads'][rawurldecode($categoryname)])){
					echo "var data10".$data['catid'][rawurldecode($categoryname)]." = new google.visualization.DataTable();
				data10".$data['catid'][rawurldecode($categoryname)].".addColumn('datetime', 'Date');
				data10".$data['catid'][rawurldecode($categoryname)].".addColumn('number', 'Uploads');
				data10".$data['catid'][rawurldecode($categoryname)].".addRows([";
				
					foreach(array_keys($data['catuploads'][rawurldecode($categoryname)]) as $key){
						echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['catuploads'][rawurldecode($categoryname)][$key]."]";
						if($key != end(array_keys($data['catuploads'][rawurldecode($categoryname)]))) echo ",";
					}
				
				echo "]);

				var charttotaluploads".$data['catid'][rawurldecode($categoryname)]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaluploads".$data['catid'][rawurldecode($categoryname)]."'));
				charttotaluploads".$data['catid'][rawurldecode($categoryname)].".draw(data10".$data['catid'][rawurldecode($categoryname)].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow',
					'wmode': 'transparent'}
					);
				
				var data11".$data['catid'][rawurldecode($categoryname)]." = new google.visualization.DataTable();
				data11".$data['catid'][rawurldecode($categoryname)].".addColumn('datetime', 'Date');
				data11".$data['catid'][rawurldecode($categoryname)].".addColumn('number', 'Upload Bytes');
				data11".$data['catid'][rawurldecode($categoryname)].".addRows([";
				
					foreach(array_keys($data['catupsize'][rawurldecode($categoryname)]) as $key){
						echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['catupsize'][rawurldecode($categoryname)][$key]."]";
						if($key != end(array_keys($data['catupsize'][rawurldecode($categoryname)]))) echo ",";
					}
				
				echo "]);

				var charttotalupsize".$data['catid'][rawurldecode($categoryname)]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalupsize".$data['catid'][rawurldecode($categoryname)]."'));
				charttotalupsize".$data['catid'][rawurldecode($categoryname)].".draw(data11".$data['catid'][rawurldecode($categoryname)].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow',
					'wmode': 'transparent'}
					);";
					
				echo "var imgs".$data['catid'][rawurldecode($categoryname)]." = new google.visualization.DataTable();
				imgs".$data['catid'][rawurldecode($categoryname)].".addColumn('string', 'Name');
				imgs".$data['catid'][rawurldecode($categoryname)].".addColumn('number', 'Size');
				imgs".$data['catid'][rawurldecode($categoryname)].".addColumn('datetime', 'Date');
				imgs".$data['catid'][rawurldecode($categoryname)].".addRows([";
					foreach(array_keys($data['catimages'][rawurldecode($categoryname)]) as $key){
						echo "['".$data['catimages'][rawurldecode($categoryname)][$key]."',";
						echo $data['imagesize'][$data['catimages'][rawurldecode($categoryname)][$key]].",";
						echo "new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key).")]";
						
						if($key != end(array_keys($data['catimages'][rawurldecode($categoryname)]))) echo ",";
					}
				echo "]);


				var imgtable".$data['catid'][rawurldecode($categoryname)]." = new google.visualization.Table(document.getElementById('img_table".$data['catid'][rawurldecode($categoryname)]."'));
				imgtable".$data['catid'][rawurldecode($categoryname)].".draw(imgs".$data['catid'][rawurldecode($categoryname)].", {showRowNumber: true});";
			}
			?>
			
			<?
			if(isset($data['cataveragevalue'][rawurldecode($categoryname)])){
			
				echo "var data12".$data['catid'][rawurldecode($categoryname)]." = new google.visualization.DataTable();
				data12".$data['catid'][rawurldecode($categoryname)].".addColumn('datetime', 'Date');
				data12".$data['catid'][rawurldecode($categoryname)].".addColumn('number', 'Average Grade');
				data12".$data['catid'][rawurldecode($categoryname)].".addRows([";
			
					foreach(array_keys($data['cataveragevalue'][rawurldecode($categoryname)]) as $key){
						$date = $data['revisiondate'][$key];
						echo "[new Date(".
						date('Y', $date).", ".
						date('m', $date)." ,".
						date('d', $date)." ,".
						date('H', $date)." ,".
						date('i', $date)."), ".
						$data['cataveragevalue'][rawurldecode($categoryname)][$key]."]";
						if($key != end(array_keys($data['cataveragevalue'][rawurldecode($categoryname)]))) echo ",";
					}
				echo "]);

				var charttotalquality".$data['catid'][rawurldecode($categoryname)]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalquality".$data['catid'][rawurldecode($categoryname)]."'));
				charttotalquality".$data['catid'][rawurldecode($categoryname)].".draw(data12".$data['catid'][rawurldecode($categoryname)].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow',
					'wmode': 'transparent'}
					);
				
				var data13".$data['catid'][rawurldecode($categoryname)]." = new google.visualization.DataTable();
				data13".$data['catid'][rawurldecode($categoryname)].".addColumn('datetime', 'Date');
				data13".$data['catid'][rawurldecode($categoryname)].".addColumn('number', 'Bytes X Quality');
				data13".$data['catid'][rawurldecode($categoryname)].".addColumn('number', 'Bytes');
				data13".$data['catid'][rawurldecode($categoryname)].".addRows([";
					$result = 0;
					foreach(array_keys($data['catbytes'][rawurldecode($categoryname)]) as $date){
						$rev = $data['daterevision'][$date];
						$grade = isset($data['cataveragevalue'][rawurldecode($categoryname)][$rev])? $data['cataveragevalue'][rawurldecode($categoryname)][$rev] : 5;
						
						$result += $data['totalbytesdiff'][$date] + ($grade - 5) * ($data['totalbytesdiff'][$date]/5);
						echo "[new Date(".
						date('Y', $date).", ".
						date('m', $date)." ,".
						date('d', $date)." ,".
						date('H', $date)." ,".
						date('i', $date)."), ".
						$result.", ".
						$data['catbytes'][rawurldecode($categoryname)][$date].
						"]";
						if($date != end(array_keys($data['catbytes'][rawurldecode($categoryname)]))) echo ",";
					}
				echo "]);
				
				var charttotalbytesxquality".$data['catid'][rawurldecode($categoryname)]." = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytesxquality".$data['catid'][rawurldecode($categoryname)]."'));
				charttotalbytesxquality".$data['catid'][rawurldecode($categoryname)].".draw(data13".$data['catid'][rawurldecode($categoryname)].", {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow',
					'wmode': 'transparent'}
					);";
			}
			?>
			
			var data<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.DataTable();
			data<?=$data['catid'][rawurldecode($categoryname)]?>.addColumn('string', 'Nick');
			data<?=$data['catid'][rawurldecode($categoryname)]?>.addColumn('string', 'Name');
			data<?=$data['catid'][rawurldecode($categoryname)]?>.addColumn('number', 'Edits');
			data<?=$data['catid'][rawurldecode($categoryname)]?>.addColumn('number', 'Edits %');
			data<?=$data['catid'][rawurldecode($categoryname)]?>.addColumn('number', 'Bytes');
			data<?=$data['catid'][rawurldecode($categoryname)]?>.addColumn('number', 'Bytes %');
			data<?=$data['catid'][rawurldecode($categoryname)]?>.addRows([
			<? 
				foreach(array_keys($data['catuser'][rawurldecode($categoryname)]) as $key){
					echo "['".anchor("filters_form/filter/".$aname."/user/".$key, $key, array('target' => '_blank'))."','".
						$data['userrealname'][$key]."',".
						round(end($data['catuseredits'][rawurldecode($categoryname)][$key]), 2).",".
						round(end($data['catuseredits'][rawurldecode($categoryname)][$key])/end($data['catedits'][rawurldecode($categoryname)]), 2).",";
					if(end($data['catbytes'][rawurldecode($categoryname)]) != 0){
						echo round(end($data['catuserbytes'][rawurldecode($categoryname)][$key]), 2).",".
						round(end($data['catuserbytes'][rawurldecode($categoryname)][$key])/end($data['catbytes'][rawurldecode($categoryname)]), 2);
					}else
						echo "0, 0";
						
					echo "]\n";
					
					if($key != end(array_keys($data['catuser'][rawurldecode($categoryname)]))) echo ",";
				}
			?>
			]);


			var table<?=$data['catid'][rawurldecode($categoryname)]?> = new google.visualization.Table(document.getElementById('user_table<?=$data['catid'][rawurldecode($categoryname)]?>'));
			table<?=$data['catid'][rawurldecode($categoryname)]?>.draw(data<?=$data['catid'][rawurldecode($categoryname)]?>, {showRowNumber: true,
						page: 'enable',
						allowHtml: true,
						pageSize: 20});
			
		}
	</script>
	
	<script>drawChart<?=$data['catid'][rawurldecode($categoryname)]?>(); </script>
