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

<div id = 'overlay'><p>Loading charts...</p></div>

<script>
	function hideoverlay(){
		document.getElementById('overlay').style.visibility="hidden";
	}
</script>



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

<script>
	html2canvas(document.body, {
		onrendered: function(canvas) {
			document.body.appendChild(canvas);
		}
	});
</script>


<!-- CHARTS SCRIPTS -->

<script type='text/javascript' src='http://www.google.com/jsapi'></script>
	<script type='text/javascript'>
		
		google.load('visualization', '1', {'packages':['annotatedtimeline', 'corechart', 'table']});
		google.setOnLoadCallback(drawChart);
		
		
		function drawChart() {
			var data1 = new google.visualization.DataTable();
			data1.addColumn('datetime', 'Date');
			data1.addColumn('number', 'Total');
			data1.addColumn('number', 'Articles');
			data1.addColumn('number', 'Talks');
			data1.addColumn('number', 'Users');
			data1.addColumn('number', 'User Talks');
			data1.addColumn('number', 'Files');
			data1.addColumn('number', 'Template');
			data1.addColumn('number', 'Category');
			data1.addRows([
			<?
				foreach(array_keys($data['totaledits']) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['totaledits'][$key].", ".
						$data['totaledits_art'][$key].", ".
						$data['totaledits_talk'][$key].", ".
						$data['totaledits_us'][$key].", ".
						$data['totaledits_ustalk'][$key].", ".
						$data['totaledits_file'][$key].", ".
						$data['totaledits_temp'][$key].", ".
						$data['totaledits_cat'][$key].", ".
						"]";
					if($key != end(array_keys($data['totaledits']))) echo ",";
				}
			?>
			]);

			var chartedits = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaledits'));
			chartedits.draw(data1, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
			
			
			var data2 = new google.visualization.DataTable();
			data2.addColumn('datetime', 'Date');
			data2.addColumn('number', 'Total');
			data2.addColumn('number', 'Article');
			data2.addColumn('number', 'Talks');
			data2.addColumn('number', 'Users');
			data2.addColumn('number', 'User Talks');
			data2.addColumn('number', 'Files');
			data2.addColumn('number', 'Templates');
			data2.addColumn('number', 'Categories');
			data2.addRows([
			<?
				foreach(array_keys($data['totalbytes']) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['totalbytes'][$key].", ".
					$data['totalbytes_art'][$key].", ".
					$data['totalbytes_talk'][$key].", ".
					$data['totalbytes_us'][$key].", ".
					$data['totalbytes_ustalk'][$key].", ".
					$data['totalbytes_file'][$key].", ".
					$data['totalbytes_temp'][$key].", ".
					$data['totalbytes_cat'][$key].
					"]";
					if($key != end(array_keys($data['totalbytes']))) echo ",";
				}
			?>
			]);

			var chartbytes = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytes'));
			chartbytes.draw(data2, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
			
			var data3 = new google.visualization.DataTable();
			data3.addColumn('datetime', 'Date');
			data3.addColumn('number', 'Total');
			data3.addColumn('number', 'Articles');
			data3.addColumn('number', 'Talks');
			data3.addColumn('number', 'Users');
			data3.addColumn('number', 'User Talks');
			data3.addColumn('number', 'Files');
			data3.addColumn('number', 'Template');
			data3.addColumn('number', 'Category');
			data3.addRows([
			<?
				foreach(array_keys($data['totalpages']) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['totalpages'][$key].", ".
					$data['totalpages_art'][$key].", ".
					$data['totalpages_talk'][$key].", ".
					$data['totalpages_us'][$key].", ".
					$data['totalpages_ustalk'][$key].", ".
					$data['totalpages_file'][$key].", ".
					$data['totalpages_temp'][$key].", ".
					$data['totalpages_cat'][$key].
					"]";
					if($key != end(array_keys($data['totalpages']))) echo ",";
				}
			?>
			]);

			var chartpages = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalpages'));
			chartpages.draw(data3, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
			
			var data4 = new google.visualization.DataTable();
			data4.addColumn('datetime', 'Date');
			data4.addColumn('number', 'Total');
			data4.addColumn('number', 'Contributed to Articles');
			data4.addRows([
			<?
				foreach(array_keys($data['totalusers']) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['totalusers'][$key].", ".
					$data['totalusers_art'][$key].
					"]";
					if($key != end(array_keys($data['totalusers']))) echo ",";
				}
			?>
			]);

			var chartusers = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalusers'));
			chartusers.draw(data4, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
                                
                        <? 
				if(isset($data['totalcategories'])){
					echo "
						var data44 = new google.visualization.DataTable();
						data44.addColumn('datetime', 'Date');
						data44.addColumn('number', 'Total');
						data44.addRows([";
						
						foreach(array_keys($data['totalcategories']) as $key){
							echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
							$data['totalcategories'][$key].
							"]";
							if($key != end(array_keys($data['totalcategories']))) echo ",";
						}
					echo "]);
	
					var chartcats = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalcategories'));
					chartcats.draw(data44, {
						'displayAnnotations': false,
						'fill': 20,
						'legendPosition': 'newRow',
						'wmode': 'transparent'}
						);";
                                }
			
			?>
			
			var data5 = new google.visualization.arrayToDataTable([
				['Hour', 'Others', 'Articles'],
			<?
				foreach(array_keys($data['totalactivityhour']) as $key){
					echo "[".$key.", ".
					($data['totalactivityhour'][$key]-$data['totalactivityhour_art'][$key]).", ".
					$data['totalactivityhour_art'][$key].
					"]";
					if($key != end(array_keys($data['totalactivityhour']))) echo ",";
				}
			?>
			]);
			
			var options = {
				hAxis: {title: 'Hour', titleTextStyle: {data: 'green'}},
				isStacked:true
			};

			var charttotalactivityhour = new google.visualization.ColumnChart(document.getElementById('charttotalactivityhour'));
			charttotalactivityhour.draw(data5, options);
			
			var data6 = new google.visualization.arrayToDataTable([
				['Day', 'Others', 'Articles'],
			<?
				foreach(array_keys($data['totalactivitywday']) as $key){
					echo "['".$key."', ".
					($data['totalactivitywday'][$key]-$data['totalactivitywday_art'][$key]).", ".
					$data['totalactivitywday_art'][$key].
					"]";
					if($key != end(array_keys($data['totalactivitywday']))) echo ",";
				}
			?>
			]);
			
			var options = {
				hAxis: {title: 'Day', titleTextStyle: {data: 'green'}},
				isStacked:true
			};

			var charttotalactivitywday = new google.visualization.ColumnChart(document.getElementById('charttotalactivitywday'));
			charttotalactivitywday.draw(data6, options);
			
			var data7 = new google.visualization.arrayToDataTable([
				['Week', 'Others', 'Articles'],
			<?
				foreach(array_keys($data['totalactivityweek']) as $key){
					echo "['".$key."', ".
					($data['totalactivityweek'][$key] - $data['totalactivityweek_art'][$key]).", ".
					$data['totalactivityweek_art'][$key].
					"]";
					if($key != end(array_keys($data['totalactivityweek']))) echo ",";
				}
			?>
			]);
			
			var options = {
				hAxis: {title: 'Week', titleTextStyle: {data: 'green'}},
				isStacked:true
			};

			var charttotalactivityweek = new google.visualization.ColumnChart(document.getElementById('charttotalactivityweek'));
			charttotalactivityweek.draw(data7, options);
			
			var data8 = new google.visualization.arrayToDataTable([
				['Month', 'Others', 'Articles'],
			<?
				foreach(array_keys($data['totalactivitymonth']) as $key){
					echo "['".$key."', ".
					($data['totalactivitymonth'][$key]-$data['totalactivitymonth_art'][$key]).", ".
					$data['totalactivitymonth_art'][$key].
					"]";
					if($key != end(array_keys($data['totalactivitymonth']))) echo ",";
				}
			?>
			]);
			
			var options = {
				hAxis: {title: 'Month', titleTextStyle: {data: 'green'}},
				isStacked:true
			};

			var charttotalactivitymonth = new google.visualization.ColumnChart(document.getElementById('charttotalactivitymonth'));
			charttotalactivitymonth.draw(data8, options);
			
			var data9 = new google.visualization.arrayToDataTable([
				['Year', 'Others', 'Articles'],
			<?
				foreach(array_keys($data['totalactivityyear']) as $key){
					echo "['".$key."', ".
					($data['totalactivityyear'][$key]-$data['totalactivityyear_art'][$key]).", ".
					$data['totalactivityyear_art'][$key].
					"]";
					if($key != end(array_keys($data['totalactivityyear']))) echo ",";
				}
			?>
			]);
			
			var options = {
				hAxis: {title: 'Year', titleTextStyle: {data: 'green'}},
				isStacked:true
			};

			var charttotalactivityyear = new google.visualization.ColumnChart(document.getElementById('charttotalactivityyear'));
			charttotalactivityyear.draw(data9, options);
			
			<?
				if(isset($data['totaluploads'])){
					echo "
						var data10 = new google.visualization.DataTable();
						data10.addColumn('datetime', 'Date');
						data10.addColumn('number', '#Uploads');
						data10.addRows([";
					
					foreach(array_keys($data['totaluploads']) as $key){
						echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['totaluploads'][$key]."]";
						if($key != end(array_keys($data['totaluploads']))) echo ",";
					}
					
					echo "]);
	
					var charttotaluploads = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaluploads'));
					charttotaluploads.draw(data10, {
						'displayAnnotations': false,
						'fill': 20,
						'legendPosition': 'newRow',
						'wmode': 'transparent'}
						);
			
			
					var data11 = new google.visualization.DataTable();
					data11.addColumn('datetime', 'Date');
					data11.addColumn('number', 'Upload Bytes');
					data11.addRows([";
				
					foreach(array_keys($data['totalupsize']) as $key){
						echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['totalupsize'][$key]."]";
						if($key != end(array_keys($data['totalupsize']))) echo ",";
					}
					
					echo "]);

					var charttotalupsize = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalupsize'));
					charttotalupsize.draw(data11, {
						'displayAnnotations': false,
						'fill': 20,
						'legendPosition': 'newRow',
						'wmode': 'transparent'}
						);";
				}
			?>
			
			<?
				if(isset($data['totalaverage'])){
					echo "	var data12 = new google.visualization.DataTable();
						data12.addColumn('datetime', 'Date');
						data12.addColumn('number', 'Average Grade');
						data12.addRows([";
						
					foreach(array_keys($data['totalaverage']) as $key){
						$date = $data['revisiondate'][$key];
						echo "[new Date(".
							date('Y', $date).", ".
							date('m', $date)." ,".
							date('d', $date)." ,".
							date('H', $date)." ,".
							date('i', $date)."), ".
						$data['totalaverage'][$key]."]";
						if($key != end(array_keys($data['totalaverage']))) echo ",";
					}
					echo "]);

						var charttotalquality = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalquality'));
						charttotalquality.draw(data12, {
							'displayAnnotations': false,
							'fill': 20,
							'legendPosition': 'newRow',
							'wmode': 'transparent'}
							);
							
						var data13 = new google.visualization.DataTable();
						data13.addColumn('datetime', 'Date');
						data13.addColumn('number', 'Bytes X Quality');
						data13.addColumn('number', 'Bytes');
						data13.addRows([";
						
					$result = 0;
					foreach(array_keys($data['totalbytes']) as $date){
						$rev = $data['daterevision'][$date];
						$grade = isset($data['totalaverage'][$rev])? $data['totalaverage'][$rev] : 5;
						
						$result += $data['totalbytesdiff'][$date] + ($grade - 5) * ($data['totalbytesdiff'][$date]/5);
						echo "[new Date(".
							date('Y', $date).", ".
							date('m', $date)." ,".
							date('d', $date)." ,".
							date('H', $date)." ,".
							date('i', $date)."), ".
							$result.", ".
							$data['totalbytes'][$date].
						"]";
						if($date != end(array_keys($data['totalbytes']))) echo ",";
					}
					
					echo "]);
						var charttotalbytesxquality = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytesxquality'));
						charttotalbytesxquality.draw(data13, {
							'displayAnnotations': false,
							'fill': 20,
							'legendPosition': 'newRow',
							'wmode': 'transparent'}
							);
							
						var data14 = new google.visualization.DataTable();
						data14.addColumn('number', 'Hour');
						data14.addColumn('number', 'Quality');
						data14.addRows([";
					
					foreach(array_keys($data['totalmark']) as $revision){
						$date = $data['revisiondate'][$revision];
						$accum[date('H', $date)] = 0;
						$nrevs[date('H', $date)] = 0;
					}
				
					foreach(array_keys($data['totalmark']) as $revision){
						$date = $data['revisiondate'][$revision];
						$grade = $data['totalmark'][$revision];
						$accum[date('H', $date)] += $grade;
						$nrevs[date('H', $date)] += 1;
					}
				
					foreach(array_keys($accum) as $hour){
						echo "[".$hour.", ".($accum[$hour]/$nrevs[$hour])."]";
						if($hour != end(array_keys($accum))) echo ",";
					}
					
					echo "]);
					
						var options = {
							hAxis: {title: 'Hour', titleTextStyle: {data: 'green'}},
							vAxis: {title: 'Quality', titleTextStyle: {data: 'green'}, minValue:0}
						};
			
						var chartqualityhour = new google.visualization.ScatterChart(document.getElementById('qualityhourchart'));
						chartqualityhour.draw(data14, options);";
				}
			?>
			
			
			var data15 = google.visualization.arrayToDataTable([
				['Type', 	'Editions'],
				['Articles', 	<?=end($data['totaledits_art'])?>],
				['Talks', 	<?=end($data['totaledits_talk'])?>],
				['Users', 	<?=end($data['totaledits_us'])?>],
				['User Talks',	<?=end($data['totaledits_ustalk'])?>],
				['Templates', 	<?=end($data['totaledits_temp'])?>],
				['Categories', 	<?=end($data['totaledits_cat'])?>],
				['Files', 	<?=end($data['totaledits_file'])?>]
			]);
			
			new google.visualization.PieChart(document.getElementById('chartfinaledits'))
				.draw(data15,{
					chartArea:{width:"90%",height:"90%"},
					legend:{position: 'none'},
					is3D:true
				});
				
			var data16 = google.visualization.arrayToDataTable([
				['Type', 	'Bytes'],
				['Articles', 	<?=end($data['totalbytes_art'])?>],
				['Talks', 	<?=end($data['totalbytes_talk'])?>],
				['Users', 	<?=end($data['totalbytes_us'])?>],
				['User Talks',	<?=end($data['totalbytes_ustalk'])?>],
				['Templates', 	<?=end($data['totalbytes_temp'])?>],
				['Categories', 	<?=end($data['totalbytes_cat'])?>],
				['Files', 	<?=end($data['totalbytes_file'])?>]
			]);
			
			new google.visualization.PieChart(document.getElementById('chartfinalbytes'))
				.draw(data16,{
					chartArea:{width:"90%",height:"90%"},
					legend:{position: 'none'},
					is3D:true
				});
				
			var data17 = google.visualization.arrayToDataTable([
				['Type', 	'Pages'],
				['Articles', 	<?=end($data['totalpages_art'])?>],
				['Talks', 	<?=end($data['totalpages_talk'])?>],
				['Users', 	<?=end($data['totalpages_us'])?>],
				['User Talks',	<?=end($data['totalpages_ustalk'])?>],
				['Templates', 	<?=end($data['totalpages_temp'])?>],
				['Categories', 	<?=end($data['totalpages_cat'])?>],
				['Files', 	<?=end($data['totalpages_file'])?>]
			]);
			
			new google.visualization.PieChart(document.getElementById('chartfinalpages'))
				.draw(data17,{
					chartArea:{width:"90%",height:"90%"},
					legend:{position: 'none'},
					is3D:true
				});
				
			var data18 = google.visualization.arrayToDataTable([
				['Type', 				'Pages'],
				['Contributed to Articles', 		<?=end($data['totalusers_art'])?>],
				['Did not contribute to articles', 	<?=(end($data['totalusers']) - end($data['totalusers_art']))?>]
			]);
			
			new google.visualization.PieChart(document.getElementById('chartfinalusers'))
				.draw(data18,{
					chartArea:{width:"90%",height:"90%"},
					legend:{position: 'none'},
					is3D:true
				});
			
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
				foreach(array_keys($data['useredits']) as $key){
					echo "['".anchor("filters_form/filter/".$aname."/user/".$key, $key, array('target' => '_blank'))."','".
						utf8_encode($data['userrealname'][$key])."',".
						round(end($data['useredits'][$key]), 2).",".
						round((end($data['useredits'][$key])/end($data['totaledits']))*100, 2).",".
						round(end($data['useredits_art'][$key]), 3).",".
						round((end($data['useredits_art'][$key])/end($data['totaledits_art']))*100, 2).",".
						round(end($data['userbytes'][$key]), 3).",".
						round((end($data['userbytes'][$key])/end($data['totalbytes']))*100, 2).",".
						round(end($data['userbytes_art'][$key]), 3).",".
						round((end($data['userbytes_art'][$key])/end($data['totalbytes_art']))*100, 2);
					if(isset($data['useruploads'])){
						echo ", ".round(end($data['useruploads'][$key]), 3).",".
						round((end($data['useruploads'][$key]) / end($data['totaluploads']))*100, 2);
					}
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
			?>
			]);


			var table = new google.visualization.Table(document.getElementById('user_table'));
			table.draw(data, {showRowNumber: true,
						page: 'enable',
						allowHtml: true,
						pageSize: 20});
			
			var pagedata = new google.visualization.DataTable();
			pagedata.addColumn('string', 'Name');
			pagedata.addColumn('string', 'Namespace');
			pagedata.addColumn('number', 'Edits');
			pagedata.addColumn('number', 'Edits %');
			pagedata.addColumn('number', 'Bytes');
			pagedata.addColumn('number', 'Bytes %');
			pagedata.addColumn('number', 'Uploads');
			pagedata.addColumn('number', 'Uploads %');
			<? if(isset($data['pageaveragevalue'])) echo "
				pagedata.addColumn('number', 'Average Grade');
				pagedata.addColumn('number', 'Standard Deviation');
				pagedata.addColumn('number', 'Min Grade');
				pagedata.addColumn('number', 'Max Grade');";
			?>
			pagedata.addColumn('number', 'Visits');
			pagedata.addColumn('number', 'Visits %');
			pagedata.addRows([
			<? 
				foreach(array_keys($data['pageedits']) as $key){
					echo "['".anchor("filters_form/filter/".$aname."/page/".$key, $key, array('target' => '_blank'))."', '".
						utf8_encode($data['pagenamespace'][$key])."', ".
						round(end($data['pageedits'][$key]), 3).",".
						round((end($data['pageedits'][$key]) / end($data['totaledits']))*100, 2).",".
						round(end($data['pagebytes'][$key]), 3).",".
						round((end($data['pagebytes'][$key]) / end($data['totalbytes']))*100, 2);
						if(isset($data['pageuploads'][$key]))
							echo ", ".round(end($data['pageuploads'][$key]), 3).",".
							round((end($data['pageuploads'][$key]) / end($data['totaluploads']))*100, 2);
						else
							echo ", 0, 0";
					if(isset($data['pageaveragevalue']))
						if(isset($data['pageaveragevalue'][$key])) 
							echo ", ".round(end($data['pageaveragevalue'][$key]), 2).",".
								round(end($data['pagesd'][$key]), 2).",".
								round(end($data['pageminvalue'][$key]), 3).",".
								round(end($data['pagemaxvalue'][$key]), 3);
						else
							echo ", -1, -1, -1, -1";
						
					echo ", ".$data['pagevisits'][$key].", ".
						round($data['pagevisits'][$key] / array_sum($data['pagevisits']), 3);
					
					echo "]\n";
					
					if($key != end(array_keys($data['pageedits']))) echo ",";
				}
			?>
			]);


			var pagetable = new google.visualization.Table(document.getElementById('pages_table'));
			pagetable.draw(pagedata, {showRowNumber: true,
						page: 'enable',
						allowHtml: true,
						pageSize: 20});
			
			<?
				if(isset($data['catedits'])){
					echo "var catdata = new google.visualization.DataTable();
						catdata.addColumn('string', 'Name');
						catdata.addColumn('number', 'Edits');
						catdata.addColumn('number', 'Edits %');
						catdata.addColumn('number', 'Bytes');
						catdata.addColumn('number', 'Bytes %');
						catdata.addColumn('number', 'Pages');
						catdata.addColumn('number', 'Pages %');
						catdata.addColumn('number', 'Uploads');
						catdata.addColumn('number', 'Uploads %');";
			
					echo "catdata.addRows([";
					foreach(array_keys($data['catedits']) as $key){
						echo "['".anchor("filters_form/filter/".$aname."/category/".$key, $key, array('target' => '_blank'))."', ".
							round(end($data['catedits'][$key]), 3).",".
							round((end($data['catedits'][$key]) / end($data['totaledits'])) * 100, 2).",".
							round(end($data['catbytes'][$key]), 3).",".
							round((end($data['catbytes'][$key]) / end($data['totalbytes'])) * 100, 2).",".
							round(end($data['catpages'][$key]), 3).", ".
							round((end($data['catpages'][$key]) / end($data['totalpages'])) * 100, 2);
						if(isset($data['catuploads'][$key])) 
							echo ", ".round(end($data['catuploads'][$key]), 3).",".
								round((end($data['catuploads'][$key]) / end($data['totaluploads'])) * 100, 2);
						else
							echo ", 0, 0";
					
						echo "]\n";
					
						if($key != end(array_keys($data['catedits']))) echo ",";
					}
					echo "]);
					
					var cattable = new google.visualization.Table(document.getElementById('categories_table'));
					cattable.draw(catdata, {showRowNumber: true,
						page: 'enable',
						allowHtml: true,
						pageSize: 20});";
				}
			?>
		}
	</script>
	<script>
		hideoverlay();
	</script>
	
<!-- CHARTS -->

	<a name = 'top'></a>
	
	<div id = 'chartmenu' style = 'width:800px; display:block; margin:auto;'>
		<table id = 'variabletable'>
		<tr>
			<th colspan = '6'><?=lang('voc.i18n_chart_menu')?></th></tr>
		</tr>
		<tr>
			<td><a href = '#chartfinaledits'><?=lang('voc.i18n_edits')?></a></td>
			<td><a href = '#chartfinalbytes'><?=lang('voc.i18n_bytes')?></a></td>
			<td><a href = '#chartfinalpages'><?=lang('voc.i18n_pages')?></a></td>
			<td><a href = '#chartfinalusers'><?=lang('voc.i18n_users')?></a></td>
			<td class = 'type' colspan = '2'><?=lang('voc.i18n_percentage_charts')?></td>
		</tr>
		<tr>
			<td><a href = '#charttotaledits'><?=lang('voc.i18n_edits_evolution')?></a></td>
			<td><a href = '#charttotalbytes'><?=lang('voc.i18n_content_evolution')?></a></td>
			<td><a href = '#charttotalpages'><?=lang('voc.i18n_pages_evolution')?></a></td>
			<td><a href = '#charttotalusers'><?=lang('voc.i18n_users_evolution')?></a></td>
			<?
				if(isset($data['totalcategories'])) 
					echo "
					<td><a href = '#charttotalcategories'>".lang('voc.i18n_categories_evolution')."</a></td>
					<td class = 'type'>".lang('voc.i18n_evolution_charts')."</td>";
				else
					echo "
					<td colspan = '2' class = 'type'>".lang('voc.i18n_evolution_charts')."</td>";
			?>
		</tr>
		<tr>
			<td><a href = '#charttotalactivityhour'><?=lang('voc.i18n_activity_hour')?></a></td>
			<td><a href = '#charttotalactivitywday'><?=lang('voc.i18n_activity_wday')?></a></td>
			<td><a href = '#charttotalactivityweek'><?=lang('voc.i18n_activity_week')?></a></td>
			<td><a href = '#charttotalactivitymonth'><?=lang('voc.i18n_activity_month')?></a></td>
			<td><a href = '#charttotalactivityyear'><?=lang('voc.i18n_activity_year')?></a></td>
			<td class = 'type'><?=lang('voc.i18n_activity_charts')?></td>
		</tr>
		<? if (!isset($data['totaluploads'])) echo "<!--";?>
		<tr>
			<td><a href = '#charttotaluploads'><?=lang('voc.i18n_uploads')?></a></td>
			<td><a href = '#charttotalupsize'><?=lang('voc.i18n_upsize')?></a></td>
			<td class = 'type'  colspan = '4'><?=lang('voc.i18n_uploads_charts')?></td>
		</tr>
		<? if (!isset($data['totaluploads'])) echo "-->";?>
		<? if (!isset($data['totalaverage'])) echo "<!--";?>
		<tr>
			<td><a href = '#charttotalquality'><?=lang('voc.i18n_average_quality')?></a></td>
			<td><a href = '#charttotalbytesxquality'><?=lang('voc.i18n_bytesxquality')?></a></td>
			<td><a href = '#qualityhourchart'><?=lang('voc.i18n_hourquality')?></a></td>
			<td class = 'type'  colspan = '3'><?=lang('voc.i18n_quality_charts')?></td>
		</tr>
		<? if (!isset($data['totalaverage'])) echo "-->";?>
		<tr>
			<td><a href = '#user_table'><?=lang('voc.i18n_users_table')?></a></td>
			<td><a href = '#pages_table'><?=lang('voc.i18n_pages_table')?></a></td>
			<?
				if(isset($data['totalcategories'])) 
					echo "
					<td><a href = '#categories_table'>".lang('voc.i18n_categories_table')."</a></td>
					<td class = 'type' colspan = '3'>".lang('voc.i18n_tables')."</td>";
				else
					echo "
					<td class = 'type' colspan = '4'>".lang('voc.i18n_tables')."</td>";
			?>
		</tr>
		</table>
	</div>
	
	<br><br>
	
	<a name = 'chartfinaledits'></a>
	<a name = 'chartfinalbytes'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'leftside'><?=lang('voc.i18n_edits')?></th>
		<th class = 'rightside'><?=lang('voc.i18n_bytes')?></th>
	</tr>
	<tr>		
		<td><div id='chartfinaledits' style='width: 300px; height: 300px; border: 0px; padding: 0px; margin:auto; display:block;'></td>
		<td><div id='chartfinalbytes' style='width: 300px; height: 300px; border: 0px; padding: 0px; margin:auto; display:block;'></td>
	</tr>
	</table>
	
	<br><br>
	
	<a name = 'chartfinalpages'></a>
	<a name = 'chartfinalusers'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'leftside'><?=lang('voc.i18n_pages')?></th>
		<th class = 'rightside'><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id='chartfinalpages' style='width: 300px; height: 300px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
		<td><div id='chartfinalusers' style='width: 300px; height: 300px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<a name = 'charttotaledits'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_edits_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotaledits' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<a name = 'charttotalbytes'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_content_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytes' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<a name = 'charttotalpages'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_pages_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotalpages' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<a name = 'charttotalusers'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_users_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotalusers' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<?if(!isset($data['totalcategories'])) echo "<!--";?>
	
	<a name = 'charttotalcategories'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_categories_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotalcategories' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
	</tr>
	</table>
	<?if(!isset($data['totalcategories'])) echo "-->";?>
	
	<br><br>
	
	<a name = 'charttotalactivityhour'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_activity_hour')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityhour' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<a name = 'charttotalactivitywday'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_activity_wday')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitywday' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<a name = 'charttotalactivityweek'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_activity_week')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityweek' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<a name = 'charttotalactivitymonth'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_activity_month')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitymonth' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<a name = 'charttotalactivityyear'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_activity_year')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityyear' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<? if (!isset($data['totaluploads'])) echo "<!--";?>
	
	<a name = 'charttotaluploads'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_uploads')?></th>
	</tr>
	<tr>
		<td><div id='charttotaluploads' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<a name = 'charttotalupsize'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_upsize')?></th>
	</tr>
	<tr>
		<td><div id='charttotalupsize' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
	</tr>
	</table>
	
	<br><br>
	<? if (!isset($data['totaluploads'])) echo "-->";?>
	<? if (!isset($data['totalaverage'])) echo "<!--";?>
	
	<a name = 'charttotalquality'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_average_quality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalquality' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<a name = 'charttotalbytesxquality'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_bytesxquality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytesxquality' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<a name = 'qualityhourchart'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_hourquality')?></th>
	</tr>
	<tr>
		<td><div id='qualityhourchart' style='width: 600px; height: 500px; border: 0px; padding: 0px; margin:auto; display:block;'></div></td>
	</tr>
	</table>
	
	<br><br>
	<? if (!isset($data['totalaverage'])) echo "-->";?>
	
	<br><br>
	
	<a name = 'user_table'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_users_table')?></th>
	</tr>
	<tr>
		<td><div id = "user_table"></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<a name = 'pages_table'></a>
	
	<table id = "charttable">
	<tr>
		<th class = 'only'><?=lang('voc.i18n_pages_table')?></th>
	</tr>
	<tr>
		<td><div id = "pages_table"></div></td>
	</tr>
	</table>
	
	<br><br>
	<?if(!isset($data['catedits'])) echo "<!--";?>
	
	<a name = 'categories_table'></a>
	
	<table id = 'charttable'>
	<tr>
		<th class = 'only'><?=lang('voc.i18n_categories_table')?></th>
	</tr>
	<tr>
		<td><div id = 'categories_table'></div></td>
	</tr>
	</table>
	<?if(!isset($data['catedits'])) echo "-->";?>
	
	
	<script>
		html2canvas('charttable');
	</script>
	
<!-- [2] www.christophermonnat.com/2008/08/generating-pdf-files-using-codeigniter -->
<!--[2] TO_DO: generate pdf-->
