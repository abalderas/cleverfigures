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
		google.load('visualization', '1', {'packages':['annotatedtimeline']});
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
			data2.addColumn('date', 'Date');
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
					echo "[new Date(".date('Y', $key).", ".date('m', $key)." ,".date('d', $key)."), ".$wiki['totalpages'][$key]."]";
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
		}
	</script>

<!-- CHARTS -->

	<table id = "resultstable">
	<tr>
		<th><?=lang('voc.i18n_edits_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotaledits' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_content_evolution')?></th>
	</tr>
	<tr>
		<td><div id='charttotalbytes' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_pages')?></th>
	</tr>
	<tr>
		<td><div id='charttotalpages' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></div></td>
	</tr>
	<tr>
		<th><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id='charttotalusers' style='width: 800px; height: 400px; border: 0px; padding: 0px;'></div></td>
	</tr>
	</table>
	<?/*
<table id = "bodytable">
<tr>
	<th><?="<h3>".lang('voc.i18n_general_stats')."</h3>"?></th>
</tr>
<tr>
	<td></td>
</tr>
<tr>
	<th><?="<h3>".lang('voc.i18n_edits_evolution')."</h3>"?></th>
</tr>
<tr>
	<th><?="<h3>".lang('voc.i18n_content_evolution')."</h3>"?></th>
</tr>

<tr><th><?="<h3>".lang('voc.i18n_quality')."</h3>"?></th></tr>
<tr><th><?="<h3>".lang('voc.i18n_qualityxbytes')."</h3>"?></th></tr>
<tr><th><?="<h3>".lang('voc.i18n_activity')."</h3>"?></th></tr>
</table>

<table id = "bodytable">
<tr>
<th><?="<h3>".lang('voc.i18n_users')."</h3>"?></th>
</tr>
<tr>
<td></td>
</tr>
<tr>
<th><?="<h3>".lang('voc.i18n_pages')."</h3>"?></th>
</tr>
<tr>
<td></td>
</tr>
<tr>
<th><?="<h3>".lang('voc.i18n_categories')."</h3>"?></th>
</tr>
<tr>
<td></td>
</tr>
<tr>
<th><?="<h3>".lang('voc.i18n_tag_cloud')."</h3>"?></th>
</tr>
<tr>
<td></td>
</tr>
</table>
*/?>

<!-- [2] www.christophermonnat.com/2008/08/generating-pdf-files-using-codeigniter -->
<!--[1] TO_DO: add more charts-->
<!--[2] TO_DO: generate pdf-->