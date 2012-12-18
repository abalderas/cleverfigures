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
<?="<h1>".lang('voc.i18n_check_results')."</h1></br>"?>

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
                                'legendPosition': 'newRow',}
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
                                'legendPosition': 'newRow',}
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
                                'legendPosition': 'newRow',}
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
                                'legendPosition': 'newRow',}
                                );
                                
                        var data44 = new google.visualization.DataTable();
			data44.addColumn('datetime', 'Date');
			data44.addColumn('number', 'Total');
			data44.addRows([
			<?
				foreach(array_keys($data['totalcategories']) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['totalcategories'][$key].
					"]";
					if($key != end(array_keys($data['totalcategories']))) echo ",";
				}
			?>
			]);

			var chartcats = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalcategories'));
			chartcats.draw(data44, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',}
                                );
			
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
			
			var data10 = new google.visualization.DataTable();
			data10.addColumn('datetime', 'Date');
			data10.addColumn('number', '#Uploads');
			data10.addRows([
			<?
				foreach(array_keys($data['totaluploads']) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['totaluploads'][$key]."]";
					if($key != end(array_keys($data['totaluploads']))) echo ",";
				}
			?>
			]);

			var charttotaluploads = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaluploads'));
			charttotaluploads.draw(data10, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',}
                                );
			
			var data11 = new google.visualization.DataTable();
			data11.addColumn('datetime', 'Date');
			data11.addColumn('number', 'Upload Bytes');
			data11.addRows([
			<?
				foreach(array_keys($data['totalupsize']) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['totalupsize'][$key]."]";
					if($key != end(array_keys($data['totalupsize']))) echo ",";
				}
			?>
			]);

			var charttotalupsize = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalupsize'));
			charttotalupsize.draw(data11, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',}
                                );
			
			var data12 = new google.visualization.DataTable();
			data12.addColumn('datetime', 'Date');
			data12.addColumn('number', 'Average Grade');
			data12.addRows([
			<?
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
			?>
			]);

			var charttotalquality = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalquality'));
			charttotalquality.draw(data12, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',}
                                );
			
			var data13 = new google.visualization.DataTable();
			data13.addColumn('datetime', 'Date');
			data13.addColumn('number', 'Bytes X Quality');
			data13.addColumn('number', 'Bytes');
			data13.addRows([
			<?
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
			?>
			]);
			
			var charttotalbytesxquality = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytesxquality'));
			charttotalbytesxquality.draw(data13, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',}
                                );
			
			var data14 = new google.visualization.DataTable();
			data14.addColumn('number', 'Hour');
			data14.addColumn('number', 'Quality');
			data14.addRows([
			<?
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
			?>
			]);
			
			var options = {
				hAxis: {title: 'Hour', titleTextStyle: {data: 'green'}},
				vAxis: {title: 'Quality', titleTextStyle: {data: 'green'}, minValue:0}
			};
			
			var chartqualityhour = new google.visualization.ScatterChart(document.getElementById('qualityhourchart'));
			chartqualityhour.draw(data14, options);
			
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
			<? if(isset($data['useruploads'])) echo "data.addColumn('number', 'Uploads');";?>
			<? if(isset($data['useruploads'])) echo "data.addColumn('number', 'Uploads %');";?>
			data.addColumn('number', 'Average Grade');
			data.addColumn('number', 'Standard Deviation');
			data.addColumn('number', 'Maximum Grade');
			data.addColumn('number', 'Minimum Grade');
			data.addColumn('number', 'Average Grade as revisor');
			data.addColumn('number', 'Maximum Grade as revisor');
			data.addColumn('number', 'Minimum Grade as revisor');
			data.addRows([
			<? 
				foreach(array_keys($data['useredits']) as $key){
					echo "['".$key."','".
						$data['userrealname'][$key]."',".
						round(end($data['useredits'][$key]), 3).",".
						round(end($data['useredits_per'][$key]), 3).",".
						(isset($data['useredits_art'][$key])?round(end($data['useredits_art'][$key]), 3):"0").",".
						(isset($data['useredits_art_per'][$key])?round(end($data['useredits_art_per'][$key]), 3):"0").",".
						round(end($data['userbytes'][$key]), 3).",".
						round(end($data['userbytes_per'][$key]), 3).",".
						(isset($data['userbytes_art'][$key])?round(end($data['userbytes_art'][$key]), 3):"0").",".
						(isset($data['userbytes_art_per'][$key])?round(end($data['userbytes_art_per'][$key]), 3):"0").",";
					if(isset($data['useruploads'][$key])) 
						echo round(end($data['useruploads'][$key]), 3).",".
							round(end($data['useruploads_per'][$key]), 3).",";
					else
						echo "0, 0, ";
					
					if(isset($data['useraverage'][$data['iduser'][$key]])) 
						echo round(end($data['useraverage'][$data['iduser'][$key]]), 3).",".
							round(end($data['usersd'][$data['iduser'][$key]]), 3).",".
							round(end($data['usermaxvalue'][$data['iduser'][$key]]), 3).",".
							round(end($data['userminvalue'][$data['iduser'][$key]]), 3).",";
					else
						echo "0, 0, 0, 0, ";
						
					if(isset($data['revisoraverage'][$data['iduser'][$key]])) 
						echo round(end($data['revisoraverage'][$data['iduser'][$key]]), 3).",".
							round(end($data['revisormaxvalue'][$data['iduser'][$key]]), 3).",".
							round(end($data['revisorminvalue'][$data['iduser'][$key]]), 3);
					else
						echo "0, 0, 0";
					echo "]\n";
					
					if($key != end(array_keys($data['useredits']))) echo ",";
				}
			?>
			]);


			var table = new google.visualization.Table(document.getElementById('user_table'));
			table.draw(data, {showRowNumber: true});
			
			var pagedata = new google.visualization.DataTable();
			pagedata.addColumn('string', 'Name');
			pagedata.addColumn('number', 'Namespace');
			pagedata.addColumn('number', 'Edits');
			pagedata.addColumn('number', 'Edits %');
			pagedata.addColumn('number', 'Bytes');
			pagedata.addColumn('number', 'Bytes %');
			<? if(isset($data['pageuploads'])) echo "pagedata.addColumn('number', 'Uploads');";?>
			<? if(isset($data['pageuploads'])) echo "pagedata.addColumn('number', 'Uploads %');";?>
			pagedata.addColumn('number', 'Average Grade');
			pagedata.addColumn('number', 'Standard Deviation');
			pagedata.addColumn('number', 'Min Grade');
			pagedata.addColumn('number', 'Max Grade');
			pagedata.addColumn('number', 'Visits');
			pagedata.addColumn('number', 'Visits %');
			pagedata.addRows([
			<? 
				foreach(array_keys($data['pageedits']) as $key){
					echo "['".$key."', ".
						$data['pagenamespace'][$key].", ".
						round(end($data['pageedits'][$key]), 3).",".
						round(end($data['pageedits_per'][$key]), 3).",".
						round(end($data['pagebytes'][$key]), 3).",".
						round(end($data['pagebytes_per'][$key]), 3);
					if(isset($data['pageuploads'][$key])) 
						echo ", ".round(end($data['pageuploads'][$key]), 3).",".
							round(end($data['pageuploads_per'][$key]), 3);
					else
						echo ", 0, 0";
					
					if(isset($data['pageaveragevalue'][$key])) 
						echo ", ".round(end($data['pageaveragevalue'][$key]), 3).",".
							round(end($data['pagesd'][$key]), 3).",".
							round(end($data['pageminvalue'][$key]), 3).",".
							round(end($data['pagemaxvalue'][$key]), 3);
					else
						echo ", 0, 0, 0, 0";
						
					echo ", ".$data['pagevisits'][$key].", ".round($data['pagevisits'][$key] / array_sum($data['pagevisits']), 3);
					
					echo "]\n";
					
					if($key != end(array_keys($data['pageedits']))) echo ",";
				}
			?>
			]);


			var pagetable = new google.visualization.Table(document.getElementById('pages_table'));
			pagetable.draw(pagedata, {showRowNumber: true});
			
			var catdata = new google.visualization.DataTable();
			catdata.addColumn('string', 'Name');
			catdata.addColumn('number', 'Edits');
			catdata.addColumn('number', 'Edits %');
			catdata.addColumn('number', 'Bytes');
			catdata.addColumn('number', 'Bytes %');
			catdata.addColumn('number', 'Pages');
			catdata.addColumn('number', 'Pages %');
			<? if(isset($data['catuploads'])) echo "catdata.addColumn('number', 'Uploads');";?>
			<? if(isset($data['catuploads'])) echo "catdata.addColumn('number', 'Uploads %');";?>
			catdata.addRows([
			<? 
				foreach(array_keys($data['catedits']) as $key){
					echo "['".$key."', ".
						round(end($data['catedits'][$key]), 3).",".
						round(end($data['catedits_per'][$key]), 3).",".
						round(end($data['catbytes'][$key]), 3).",".
						round(end($data['catbytes_per'][$key]), 3).",".
						round(end($data['catpages'][$key]), 3).", ".
						round(end($data['catpages_per'][$key]), 3);
					if(isset($data['catuploads'][$key])) 
						echo ", ".round(end($data['catuploads'][$key]), 3).",".
							round(end($data['catuploads_per'][$key]), 3);
					else
						echo ", 0, 0";
					
					echo "]\n";
					
					if($key != end(array_keys($data['catedits']))) echo ",";
				}
			?>
			]);


			var cattable = new google.visualization.Table(document.getElementById('categories_table'));
			cattable.draw(catdata, {showRowNumber: true});
		}
	</script>

	<!--<table id = "bodytable">
	<tr>
		<th colspan = "2"><?=lang('voc.i18n_filter_by')?></th>
	</tr>
	<tr>
		<td style = "width:400px"><?
			echo form_open('filters_form');
			echo form_dropdown('select_filter', array(lang('voc.i18n_user') => lang('voc.i18n_user'),
								lang('voc.i18n_page') => lang('voc.i18n_page'),
								lang('voc.i18n_category') => lang('voc.i18n_category')
								//lang('voc.i18n_criteria') => lang('voc.i18n_criteria'))
								));
		?></td>
		<td style = "width:400px"><?
			echo form_input('filterstring');
			echo form_close();
		?></td>
	</tr>
	</table>
	
	<br><br>-->
	
<!-- CHARTS -->

	<table id = "bodytable">
	<tr>
		<th><?=lang('voc.i18n_edits')?></th>
		<th><?=lang('voc.i18n_bytes')?></th>
	</tr>
	<tr>
		<td><div id='chartfinaledits' style='width: 400px; height: 400px; border: 0px; padding: 0px;'></div></td>
		<td><div id='chartfinalbytes' style='width: 400px; height: 400px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_pages')?></th>
		<th><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id='chartfinalpages' style='width: 400px; height: 400px; border: 0px; padding: 0px;'></div></td>
		<td><div id='chartfinalusers' style='width: 400px; height: 400px; border: 0px; padding: 0px;'></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<table id = "bodytable">
	<tr>
		<th><?=lang('voc.i18n_edits_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotaledits' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_content_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytes' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_pages')?></th>
	</tr>
	<tr>
		<td><div id='charttotalpages' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id='charttotalusers' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_categories')?></th>
	</tr>
	<tr>
		<td><div id='charttotalcategories' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_hour')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityhour' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_wday')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitywday' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_week')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityweek' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_month')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitymonth' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_year')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityyear' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<? if (!isset($data['totaluploads'])) echo "<!--";?>
	<tr>
		<th><?=lang('voc.i18n_uploads')?></th>
	</tr>
	<tr>
		<td><div id='charttotaluploads' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_upsize')?></th>
	</tr>
	<tr>
		<td><div id='charttotalupsize' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<? if (!isset($data['totaluploads'])) echo "-->";?>
	<? if (!isset($data['totalaverage'])) echo "<!--";?>
	<tr>
		<th><?=lang('voc.i18n_average_quality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalquality' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_bytesxquality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytesxquality' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_hourquality')?></th>
	</tr>
	<tr>
		<td><div id='qualityhourchart' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<? if (!isset($data['totalaverage'])) echo "-->";?>
	</table>
	
	<br><br>
	
	<table id = "usertable">
	<tr>
		<th><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id = "user_table"></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<table id = "pagetable">
	<tr>
		<th><?=lang('voc.i18n_pages')?></th>
	</tr>
	<tr>
		<td><div id = "pages_table"></div></td>
	</tr>
	</table>
	
	<br><br>
	
	<table id = "pagetable">
	<tr>
		<th><?=lang('voc.i18n_categories')?></th>
	</tr>
	<tr>
		<td><div id = "categories_table"></div></td>
	</tr>
	</table>
			
<!-- [2] www.christophermonnat.com/2008/08/generating-pdf-files-using-codeigniter -->
<!--[2] TO_DO: generate pdf-->