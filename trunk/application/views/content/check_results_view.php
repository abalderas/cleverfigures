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
		google.load('visualization', '1', {'packages':['annotatedtimeline', 'corechart']});
		google.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = new google.visualization.DataTable();
			data.addColumn('date', 'Date');
			data.addColumn('number', 'Editions');
			data.addRows([
			<?
				foreach(array_keys($wiki['totaledits']) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key)." ,".date('d', $key)."), ".$wiki['totaledits'][$key]."]";
					if($key != end(array_keys($wiki['totaledits']))) echo ",";
				}
			?>
			]);

			var chartedits = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaledits'));
			chartedits.draw(data, {displayAnnotations: true});
			
			
			var data2 = new google.visualization.DataTable();
			data2.addColumn('datetime', 'Date');
			data2.addColumn('number', 'Bytes');
			data2.addRows([
			<?
				foreach(array_keys($wiki['totalbytes']) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key)." ,".date('d', $key)."), ".$wiki['totalbytes'][$key]."]";
					if($key != end(array_keys($wiki['totalbytes']))) echo ",";
				}
			?>
			]);

			var chartbytes = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytes'));
			chartbytes.draw(data2, {displayAnnotations: true});
			
			var data3 = new google.visualization.DataTable();
			data3.addColumn('date', 'Date');
			data3.addColumn('number', '#Pages');
			data3.addRows([
			<?
				foreach(array_keys($wiki['totalpages']) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key)." ,".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".$wiki['totalpages'][$key]."]";
					if($key != end(array_keys($wiki['totalpages']))) echo ",";
				}
			?>
			]);

			var chartpages = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalpages'));
			chartpages.draw(data3, {displayAnnotations: true});
			
			var data4 = new google.visualization.DataTable();
			data4.addColumn('date', 'Date');
			data4.addColumn('number', '#Users');
			data4.addRows([
			<?
				foreach(array_keys($wiki['totalusers']) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key)." ,".date('d', $key)."), ".$wiki['totalusers'][$key]."]";
					if($key != end(array_keys($wiki['totalusers']))) echo ",";
				}
			?>
			]);

			var chartusers = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalusers'));
			chartusers.draw(data4, {displayAnnotations: true});
			
			var data5 = new google.visualization.arrayToDataTable([
				['Hour', 'Editions'],
			<?
				foreach(array_keys($wiki['totalactivityhour']) as $key){
					echo "[".$key.", ".$wiki['totalactivityhour'][$key]."]";
					if($key != end(array_keys($wiki['totalactivityhour']))) echo ",";
				}
			?>
			]);
			
			var options = {
				title: 'Activity per hour',
				hAxis: {title: 'Hour', titleTextStyle: {color: 'green'}}
			};

			var charttotalactivityhour = new google.visualization.ColumnChart(document.getElementById('charttotalactivityhour'));
			charttotalactivityhour.draw(data5, options);
			
			var data6 = new google.visualization.arrayToDataTable([
				['Day', 'Editions'],
			<?
				foreach(array_keys($wiki['totalactivitywday']) as $key){
					echo "['".$key."', ".$wiki['totalactivitywday'][$key]."]";
					if($key != end(array_keys($wiki['totalactivitywday']))) echo ",";
				}
			?>
			]);
			
			var options = {
				title: 'Activity per day of the week',
				hAxis: {title: 'Day', titleTextStyle: {color: 'green'}}
			};

			var charttotalactivitywday = new google.visualization.ColumnChart(document.getElementById('charttotalactivitywday'));
			charttotalactivitywday.draw(data6, options);
			
			var data7 = new google.visualization.arrayToDataTable([
				['Week', 'Editions'],
			<?
				foreach(array_keys($wiki['totalactivityweek']) as $key){
					echo "['".$key."', ".$wiki['totalactivityweek'][$key]."]";
					if($key != end(array_keys($wiki['totalactivityweek']))) echo ",";
				}
			?>
			]);
			
			var options = {
				title: 'Activity per week',
				hAxis: {title: 'Week', titleTextStyle: {color: 'green'}}
			};

			var charttotalactivityweek = new google.visualization.ColumnChart(document.getElementById('charttotalactivityweek'));
			charttotalactivityweek.draw(data7, options);
			
			var data8 = new google.visualization.arrayToDataTable([
				['Month', 'Editions'],
			<?
				foreach(array_keys($wiki['totalactivitymonth']) as $key){
					echo "['".$key."', ".$wiki['totalactivitymonth'][$key]."]";
					if($key != end(array_keys($wiki['totalactivitymonth']))) echo ",";
				}
			?>
			]);
			
			var options = {
				title: 'Activity per month',
				hAxis: {title: 'Month', titleTextStyle: {color: 'green'}}
			};

			var charttotalactivitymonth = new google.visualization.ColumnChart(document.getElementById('charttotalactivitymonth'));
			charttotalactivitymonth.draw(data8, options);
			
			var data9 = new google.visualization.arrayToDataTable([
				['Year', 'Editions'],
			<?
				foreach(array_keys($wiki['totalactivityyear']) as $key){
					echo "['".$key."', ".$wiki['totalactivityyear'][$key]."]";
					if($key != end(array_keys($wiki['totalactivityyear']))) echo ",";
				}
			?>
			]);
			
			var options = {
				title: 'Activity per year',
				hAxis: {title: 'Year', titleTextStyle: {color: 'green'}}
			};

			var charttotalactivityyear = new google.visualization.ColumnChart(document.getElementById('charttotalactivityyear'));
			charttotalactivityyear.draw(data9, options);
			
			var data10 = new google.visualization.DataTable();
			data10.addColumn('date', 'Date');
			data10.addColumn('number', '#Uploads');
			data10.addRows([
			<?
				foreach(array_keys($wiki['totaluploads']) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key)." ,".date('d', $key)."), ".$wiki['totaluploads'][$key]."]";
					if($key != end(array_keys($wiki['totaluploads']))) echo ",";
				}
			?>
			]);

			var charttotaluploads = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaluploads'));
			charttotaluploads.draw(data10, {displayAnnotations: true});
			
			var data11 = new google.visualization.DataTable();
			data11.addColumn('date', 'Date');
			data11.addColumn('number', 'Upload Bytes');
			data11.addRows([
			<?
				foreach(array_keys($wiki['totalupsize']) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key)." ,".date('d', $key)."), ".$wiki['totalupsize'][$key]."]";
					if($key != end(array_keys($wiki['totalupsize']))) echo ",";
				}
			?>
			]);

			var charttotalupsize = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalupsize'));
			charttotalupsize.draw(data11, {displayAnnotations: true});
			
			var data12 = new google.visualization.DataTable();
			data12.addColumn('datetime', 'Date');
			data12.addColumn('number', 'Average Mark');
			data12.addRows([
			<?
				foreach(array_keys($color['totalaverage']) as $key){
					$date = $wiki['revisiondate'][$key];
					echo "[new Date(".
					date('Y', $date).", ".
					date('m', $date)." ,".
					date('d', $date)." ,".
					date('H', $date)." ,".
					date('i', $date)."), ".
					$color['totalaverage'][$key]."]";
					if($key != end(array_keys($color['totalaverage']))) echo ",";
				}
			?>
			]);

			var charttotalquality = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalquality'));
			charttotalquality.draw(data12, {displayAnnotations: true});
			
			var data13 = new google.visualization.DataTable();
			data13.addColumn('datetime', 'Date');
			data13.addColumn('number', 'Bytes X Quality');
			data13.addRows([
			<?
				foreach(array_keys($color['totalmark']) as $key){
					$date = $wiki['revisiondate'][$key];
					$bytes = $wiki['totalbytes'][$date];
					$mark = $color['totalaverage'][$key];
					$result = $bytes + ($mark - 5) * ($bytes/5);
					echo "[new Date(".
					date('Y', $date).", ".
					date('m', $date)." ,".
					date('d', $date)." ,".
					date('H', $date)." ,".
					date('i', $date)."), ".
					$result."]";
					if($key != end(array_keys($color['totalmark']))) echo ",";
				}
			?>
			]);
			
			var charttotalbytesxquality = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytesxquality'));
			charttotalbytesxquality.draw(data13, {displayAnnotations: true});
			
		}
	</script>

<!-- CHARTS -->
	<table id = "bodytable">
	<tr>
		<th><?=lang('voc.i18n_edits_evolution')?></th>
	</tr>
	<tr>
		<td id='charttotaledits' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_content_evolution')?></th>
	</tr>
	<tr>
		<td id='charttotalbytes' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_pages')?></th>
	</tr>
	<tr>
		<td id='charttotalpages' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td id='charttotalusers' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_hour')?></th>
	</tr>
	<tr>
		<td id='charttotalactivityhour' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_wday')?></th>
	</tr>
	<tr>
		<td id='charttotalactivitywday' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_week')?></th>
	</tr>
	<tr>
		<td id='charttotalactivityweek' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_month')?></th>
	</tr>
	<tr>
		<td id='charttotalactivitymonth' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_activity_year')?></th>
	</tr>
	<tr>
		<td id='charttotalactivityyear' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_uploads')?></th>
	</tr>
	<tr>
		<td id='charttotaluploads' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_upsize')?></th>
	</tr>
	<tr>
		<td id='charttotalupsize' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_average_quality')?></th>
	</tr>
	<tr>
		<td id='charttotalquality' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_bytesxquality')?></th>
	</tr>
	<tr>
		<td id='charttotalbytesxquality' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></td>
	</tr>
	</table>
	
	<?=$infotables?>
			
<!-- [2] www.christophermonnat.com/2008/08/generating-pdf-files-using-codeigniter -->
<!--[2] TO_DO: generate pdf-->