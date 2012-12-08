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
			var data = new google.visualization.DataTable();
			data.addColumn('date', 'Date');
			data.addColumn('number', 'Total');
			data.addColumn('number', 'Articles');
			data.addColumn('number', 'Talks');
			data.addColumn('number', 'Users');
			data.addColumn('number', 'User Talks');
			data.addColumn('number', 'Files');
			data.addColumn('number', 'Template');
			data.addColumn('number', 'Category');
			data.addRows([
			<?
				foreach(array_keys($data['totaledits']) as $key){
					echo "[new Date(".date('Y', $key).", ".
						date('m', $key)." ,".date('d', $key)."), ".
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
			chartedits.draw(data, {displayAnnotations: false});
			
			
			var data2 = new google.visualization.DataTable();
			data2.addColumn('datetime', 'Date');
			data2.addColumn('number', 'Total');
			data2.addColumn('number', 'Article');
			data2.addRows([
			<?
				foreach(array_keys($data['totalbytes']) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key)." ,".date('d', $key)."), ".$data['totalbytes'][$key].", ".$data['totalbytes_art'][$key]."]";
					if($key != end(array_keys($data['totalbytes']))) echo ",";
				}
			?>
			]);

			var chartbytes = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytes'));
			chartbytes.draw(data2, {displayAnnotations: false});
			
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
			chartpages.draw(data3, {displayAnnotations: false});
			
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
			chartusers.draw(data4, {displayAnnotations: false});
			
			var data5 = new google.visualization.arrayToDataTable([
				['Hour', 'Editions'],
			<?
				foreach(array_keys($data['totalactivityhour']) as $key){
					echo "[".$key.", ".$data['totalactivityhour'][$key]."]";
					if($key != end(array_keys($data['totalactivityhour']))) echo ",";
				}
			?>
			]);
			
			var options = {
				title: 'Activity per hour',
				hAxis: {title: 'Hour', titleTextStyle: {data: 'green'}}
			};

			var charttotalactivityhour = new google.visualization.ColumnChart(document.getElementById('charttotalactivityhour'));
			charttotalactivityhour.draw(data5, options);
			
			var data6 = new google.visualization.arrayToDataTable([
				['Day', 'Editions'],
			<?
				foreach(array_keys($data['totalactivitywday']) as $key){
					echo "['".$key."', ".$data['totalactivitywday'][$key]."]";
					if($key != end(array_keys($data['totalactivitywday']))) echo ",";
				}
			?>
			]);
			
			var options = {
				title: 'Activity per day of the week',
				hAxis: {title: 'Day', titleTextStyle: {data: 'green'}}
			};

			var charttotalactivitywday = new google.visualization.ColumnChart(document.getElementById('charttotalactivitywday'));
			charttotalactivitywday.draw(data6, options);
			
			var data7 = new google.visualization.arrayToDataTable([
				['Week', 'Editions'],
			<?
				foreach(array_keys($data['totalactivityweek']) as $key){
					echo "['".$key."', ".$data['totalactivityweek'][$key]."]";
					if($key != end(array_keys($data['totalactivityweek']))) echo ",";
				}
			?>
			]);
			
			var options = {
				title: 'Activity per week',
				hAxis: {title: 'Week', titleTextStyle: {data: 'green'}}
			};

			var charttotalactivityweek = new google.visualization.ColumnChart(document.getElementById('charttotalactivityweek'));
			charttotalactivityweek.draw(data7, options);
			
			var data8 = new google.visualization.arrayToDataTable([
				['Month', 'Editions'],
			<?
				foreach(array_keys($data['totalactivitymonth']) as $key){
					echo "['".$key."', ".$data['totalactivitymonth'][$key]."]";
					if($key != end(array_keys($data['totalactivitymonth']))) echo ",";
				}
			?>
			]);
			
			var options = {
				title: 'Activity per month',
				hAxis: {title: 'Month', titleTextStyle: {data: 'green'}}
			};

			var charttotalactivitymonth = new google.visualization.ColumnChart(document.getElementById('charttotalactivitymonth'));
			charttotalactivitymonth.draw(data8, options);
			
			var data9 = new google.visualization.arrayToDataTable([
				['Year', 'Editions'],
			<?
				foreach(array_keys($data['totalactivityyear']) as $key){
					echo "['".$key."', ".$data['totalactivityyear'][$key]."]";
					if($key != end(array_keys($data['totalactivityyear']))) echo ",";
				}
			?>
			]);
			
			var options = {
				title: 'Activity per year',
				hAxis: {title: 'Year', titleTextStyle: {data: 'green'}}
			};

			var charttotalactivityyear = new google.visualization.ColumnChart(document.getElementById('charttotalactivityyear'));
			charttotalactivityyear.draw(data9, options);
			
			var data10 = new google.visualization.DataTable();
			data10.addColumn('date', 'Date');
			data10.addColumn('number', '#Uploads');
			data10.addRows([
			<?
				foreach(array_keys($data['totaluploads']) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key)." ,".date('d', $key)."), ".$data['totaluploads'][$key]."]";
					if($key != end(array_keys($data['totaluploads']))) echo ",";
				}
			?>
			]);

			var charttotaluploads = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaluploads'));
			charttotaluploads.draw(data10, {displayAnnotations: false});
			
			var data11 = new google.visualization.DataTable();
			data11.addColumn('date', 'Date');
			data11.addColumn('number', 'Upload Bytes');
			data11.addRows([
			<?
				foreach(array_keys($data['totalupsize']) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key)." ,".date('d', $key)."), ".$data['totalupsize'][$key]."]";
					if($key != end(array_keys($data['totalupsize']))) echo ",";
				}
			?>
			]);

			var charttotalupsize = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalupsize'));
			charttotalupsize.draw(data11, {displayAnnotations: false});
			
			var data12 = new google.visualization.DataTable();
			data12.addColumn('datetime', 'Date');
			data12.addColumn('number', 'Average Mark');
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
			charttotalquality.draw(data12, {displayAnnotations: false});
			
			var data13 = new google.visualization.DataTable();
			data13.addColumn('datetime', 'Date');
			data13.addColumn('number', 'Bytes X Quality');
			data13.addRows([
			<?
				foreach(array_keys($data['totalmark']) as $key){
					$date = $data['revisiondate'][$key];
					$bytes = $data['totalbytes'][$date];
					$mark = $data['totalaverage'][$key];
					$result = $bytes + ($mark - 5) * ($bytes/5);
					echo "[new Date(".
					date('Y', $date).", ".
					date('m', $date)." ,".
					date('d', $date)." ,".
					date('H', $date)." ,".
					date('i', $date)."), ".
					$result."]";
					if($key != end(array_keys($data['totalmark']))) echo ",";
				}
			?>
			]);
			
			var charttotalbytesxquality = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytesxquality'));
			charttotalbytesxquality.draw(data13, {displayAnnotations: false});
			
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
			data.addColumn('number', 'Average Mark');
			data.addColumn('number', 'Maximum Mark');
			data.addColumn('number', 'Minimum Mark');
			data.addColumn('number', 'Average Mark as revisor');
			data.addColumn('number', 'Maximum Mark as revisor');
			data.addColumn('number', 'Minimum Mark as revisor');
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
							round(end($data['usermaxvalue'][$data['iduser'][$key]]), 3).",".
							round(end($data['userminvalue'][$data['iduser'][$key]]), 3).",";
					else
						echo "0, 0, 0, ";
						
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
			pagedata.addColumn('string', 'Namespace');
			pagedata.addColumn('number', 'Edits');
			pagedata.addColumn('number', 'Edits %');
			pagedata.addColumn('number', 'Bytes');
			pagedata.addColumn('number', 'Bytes %');
			<? if(isset($data['pageuploads'])) echo "pagedata.addColumn('number', 'Uploads');";?>
			<? if(isset($data['pageuploads'])) echo "pagedata.addColumn('number', 'Uploads %');";?>
			pagedata.addColumn('number', 'Average Mark');
			pagedata.addColumn('number', 'Maximum Mark');
			pagedata.addColumn('number', 'Minimum Mark');
			pagedata.addColumn('number', 'Visits');
			pagedata.addColumn('number', 'Visits %');
			pagedata.addRows([
			<? 
				foreach(array_keys($data['pageedits']) as $key){
					echo "['".$key."','".
						$data['pagenamespace'][$key]."',".
						round(end($data['pageedits'][$key]), 3).",".
						round(end($data['pageedits_per'][$key]), 3).",".
						round(end($data['pagebytes'][$key]), 3).",".
						round(end($data['pagebytes_per'][$key]), 3).",";
					if(isset($data['pageuploads'][$key])) 
						echo round(end($data['pageuploads'][$key]), 3).",".
							round(end($data['pageuploads_per'][$key]), 3).",";
					else
						echo "0, 0, ";
					
					if(isset($data['pageaverage'][$key])) 
						echo round(end($data['pageaverage'][$key]), 3).",".
							round(end($data['pagemaxvalue'][$key]), 3).",".
							round(end($data['pageminvalue'][$key]), 3).",";
					else
						echo "0, 0, 0, ";
						
					echo $data['pagevisits'][$key].", ".round($data['pagevisits'][$key] / array_sum($data['pagevisits']), 3);
					
					echo "]\n";
					
					if($key != end(array_keys($data['pageedits']))) echo ",";
				}
			?>
			]);


			var pagetable = new google.visualization.Table(document.getElementById('pages_table'));
			pagetable.draw(pagedata, {showRowNumber: true});
		}
	</script>

	
<!-- CHARTS -->
	<table id = "bodytable">
	<tr>
		<th><?=lang('voc.i18n_edits_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotaledits' style='border: 0px; width: 1000px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_content_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytes' style='width: 1000px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_pages')?></th>
	</tr>
	<tr>
		<td><div id='charttotalpages' style='width: 1000px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id='charttotalusers' style='width: 1000px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_hour')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityhour' style='width: 1000px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_wday')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitywday' style='width: 1000px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_week')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityweek' style='width: 1000px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_month')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivitymonth' style='width: 1000px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_year')?></th>
	</tr>
	<tr>
		<td><div id='charttotalactivityyear' style='width: 1000px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_uploads')?></th>
	</tr>
	<tr>
		<td><div id='charttotaluploads' style='width: 1000px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_upsize')?></th>
	</tr>
	<tr>
		<td><div id='charttotalupsize' style='width: 1000px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_average_quality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalquality' style='width: 1000px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_bytesxquality')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytesxquality' style='width: 1000px; height: 700px; border: 0px; padding: 0px;'></div></td>
	</tr>
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
			
<!-- [2] www.christophermonnat.com/2008/08/generating-pdf-files-using-codeigniter -->
<!--[2] TO_DO: generate pdf-->