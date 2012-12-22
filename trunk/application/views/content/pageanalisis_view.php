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
<?="<h1>".$pagename."</h1></br>"?>

<!-- CHARTS SCRIPTS -->

<script type='text/javascript' src='http://www.google.com/jsapi'></script>
	<script type='text/javascript'>
		google.load('visualization', '1', {'packages':['annotatedtimeline', 'corechart', 'table']});
		google.setOnLoadCallback(drawChart);
		function drawChart() {
			var data1 = new google.visualization.DataTable();
			data1.addColumn('datetime', 'Date');
			data1.addColumn('number', 'Editions');
			data1.addRows([
			<?
				foreach(array_keys($data['pageedits'][$pagename]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['pageedits'][$pagename][$key].
						"]";
					if($key != end(array_keys($data['pageedits'][$pagename]))) echo ",";
				}
			?>
			]);

			var chartedits = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaledits'));
			chartedits.draw(data1, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow'}
                                );
			
			
			var data2 = new google.visualization.DataTable();
			data2.addColumn('datetime', 'Date');
			data2.addColumn('number', 'Bytes');
			data2.addRows([
			<?
				foreach(array_keys($data['pagebytes'][$pagename]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['pagebytes'][$pagename][$key].
					"]";
					if($key != end(array_keys($data['pagebytes'][$pagename]))) echo ",";
				}
			?>
			]);

			var chartbytes = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytes'));
			chartbytes.draw(data2, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow'}
                                );
                                
                        var data4 = new google.visualization.DataTable();
			data4.addColumn('datetime', 'Date');
			data4.addColumn('number', 'Users');
			data4.addRows([
			<?
				foreach(array_keys($data['pageusercount'][$pagename]) as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
					$data['pageusercount'][$pagename][$key].
					"]";
					if($key != end(array_keys($data['pageusercount'][$pagename]))) echo ",";
				}
			?>
			]);

			var chartusers = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalusers'));
			chartusers.draw(data4, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow'
                                }
                        );
                        
                        
                        var data5 = new google.visualization.arrayToDataTable([
				['Hour', 'Editions'],
			<?
				foreach(array_keys($data['pageactivityhour'][$pagename]) as $key){
					echo "[".$key.", ".
					$data['pageactivityhour'][$pagename][$key].
					"]";
					if($key != end(array_keys($data['pageactivityhour'][$pagename]))) echo ",";
				}
			?>
			]);
			
			var options5 = {
				hAxis: {title: 'Hour', titleTextStyle: {data: 'green'}},
				isStacked:true
			};

			var charttotalactivityhour = new google.visualization.ColumnChart(document.getElementById('charttotalactivityhour'));
			charttotalactivityhour.draw(data5, options5);
			
			
			var data6 = new google.visualization.arrayToDataTable([
				['Week Day', 'Editions'],
			<?
				foreach(array_keys($data['pageactivitywday'][$pagename]) as $key){
					echo "['".$key."', ".
					$data['pageactivitywday'][$pagename][$key].
					"]";
					if($key != end(array_keys($data['pageactivitywday'][$pagename]))) echo ",";
				}
			?>
			]);
			
			var options6 = {
				hAxis: {title: 'Week Day', titleTextStyle: {data: 'green'}},
				isStacked:true
			};

			var charttotalactivitywday = new google.visualization.ColumnChart(document.getElementById('charttotalactivitywday'));
			charttotalactivitywday.draw(data6, options6);
			
			
			var data7 = new google.visualization.arrayToDataTable([
				['Week', 'Editions'],
			<?
				foreach(array_keys($data['pageactivityweek'][$pagename]) as $key){
					echo "['".$key."', ".
					$data['pageactivityweek'][$pagename][$key].
					"]";
					if($key != end(array_keys($data['pageactivityweek'][$pagename]))) echo ",";
				}
			?>
			]);
			
			var options7 = {
				hAxis: {title: 'Week', titleTextStyle: {data: 'green'}},
				isStacked:true
			};

			var charttotalactivityweek = new google.visualization.ColumnChart(document.getElementById('charttotalactivityweek'));
			charttotalactivityweek.draw(data7, options7);
			
			var data8 = new google.visualization.arrayToDataTable([
				['Month', 'Editions'],
			<?
				foreach(array_keys($data['pageactivitymonth'][$pagename]) as $key){
					echo "['".$key."', ".
					$data['pageactivitymonth'][$pagename][$key].
					"]";
					if($key != end(array_keys($data['pageactivitymonth'][$pagename]))) echo ",";
				}
			?>
			]);
			
			var options8 = {
				hAxis: {title: 'Month', titleTextStyle: {data: 'green'}},
				isStacked:true
			};

			var charttotalactivitymonth = new google.visualization.ColumnChart(document.getElementById('charttotalactivitymonth'));
			charttotalactivitymonth.draw(data8, options8);
			
			var data9 = new google.visualization.arrayToDataTable([
				['Year', 'Editions'],
			<?
				foreach(array_keys($data['pageactivityyear'][$pagename]) as $key){
					echo "['".$key."', ".
					$data['pageactivityyear'][$pagename][$key].
					"]";
					if($key != end(array_keys($data['pageactivityyear'][$pagename]))) echo ",";
				}
			?>
			]);
			
			var options9 = {
				hAxis: {title: 'Year', titleTextStyle: {data: 'green'}},
				isStacked:true
			};

			var charttotalactivityyear = new google.visualization.ColumnChart(document.getElementById('charttotalactivityyear'));
			charttotalactivityyear.draw(data9, options9);
			<?
			if(isset($data['pageuploads'][$pagename])){
					echo "var data10 = new google.visualization.DataTable();
				data10.addColumn('datetime', 'Date');
				data10.addColumn('number', 'Uploads');
				data10.addRows([";
				
					foreach(array_keys($data['pageuploads'][$pagename]) as $key){
						echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['pageuploads'][$pagename][$key]."]";
						if($key != end(array_keys($data['pageuploads'][$pagename]))) echo ",";
					}
				
				echo "]);

				var charttotaluploads = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotaluploads'));
				charttotaluploads.draw(data10, {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow'}
					);
				
				var data11 = new google.visualization.DataTable();
				data11.addColumn('datetime', 'Date');
				data11.addColumn('number', 'Upload Bytes');
				data11.addRows([";
				
					foreach(array_keys($data['pageupsize'][$pagename]) as $key){
						echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."), ".
						$data['pageupsize'][$pagename][$key]."]";
						if($key != end(array_keys($data['pageupsize'][$pagename]))) echo ",";
					}
				
				echo "]);

				var charttotalupsize = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalupsize'));
				charttotalupsize.draw(data11, {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow'}
					);";
			}
			?>
			
			<?
			if(isset($data['pageaveragevalue'][$pagename])){
			
				echo "var data12 = new google.visualization.DataTable();
				data12.addColumn('datetime', 'Date');
				data12.addColumn('number', 'Average Grade');
				data12.addRows([";
			
					foreach(array_keys($data['pageaveragevalue'][$pagename]) as $key){
						$date = $data['revisiondate'][$key];
						echo "[new Date(".
						date('Y', $date).", ".
						date('m', $date)." ,".
						date('d', $date)." ,".
						date('H', $date)." ,".
						date('i', $date)."), ".
						$data['pageaveragevalue'][$pagename][$key]."]";
						if($key != end(array_keys($data['pageaveragevalue'][$pagename]))) echo ",";
					}
				echo "]);

				var charttotalquality = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalquality'));
				charttotalquality.draw(data12, {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow'}
					);
				
				var data13 = new google.visualization.DataTable();
				data13.addColumn('datetime', 'Date');
				data13.addColumn('number', 'Bytes X Quality');
				data13.addColumn('number', 'Bytes');
				data13.addRows([";
					$result = 0;
					foreach(array_keys($data['pagebytes'][$pagename]) as $date){
						$rev = $data['daterevision'][$date];
						$grade = isset($data['pageaveragevalue'][$pagename][$rev])? $data['pageaveragevalue'][$pagename][$rev] : 5;
						
						$result += $data['totalbytesdiff'][$date] + ($grade - 5) * ($data['totalbytesdiff'][$date]/5);
						echo "[new Date(".
						date('Y', $date).", ".
						date('m', $date)." ,".
						date('d', $date)." ,".
						date('H', $date)." ,".
						date('i', $date)."), ".
						$result.", ".
						$data['pagebytes'][$pagename][$date].
						"]";
						if($date != end(array_keys($data['pagebytes'][$pagename]))) echo ",";
					}
				echo "]);
				
				var charttotalbytesxquality = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalbytesxquality'));
				charttotalbytesxquality.draw(data13, {
					'displayAnnotations': false,
					'fill': 20,
					'legendPosition': 'newRow'}
					);
				
				var data14 = new google.visualization.DataTable();
				data14.addColumn('number', 'Hour');
				data14.addColumn('number', 'Quality');
				data14.addRows([";
					foreach(array_keys($data['pagegrades'][$pagename]) as $revision){
						$date = $data['revisiondate'][$revision];
						$accum[date('H', $date)] = 0;
						$nrevs[date('H', $date)] = 0;
					}
					
					foreach(array_keys($data['pagegrades'][$pagename]) as $revision){
						$date = $data['revisiondate'][$revision];
						$grade = $data['pagegrades'][$pagename][$revision];
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
			
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Nick');
			data.addColumn('string', 'Name');
			data.addColumn('number', 'Edits');
			data.addColumn('number', 'Edits %');
			data.addColumn('number', 'Bytes');
			data.addColumn('number', 'Bytes %');
			data.addColumn('number', 'Average Grade');
			data.addColumn('number', 'Standard Deviation');
			data.addRows([
			<? 
				foreach(array_keys($data['pageuser'][$pagename]) as $key){
					echo "['".$key."','".
						$data['userrealname'][$key]."',".
						round(end($data['pageuseredits'][$pagename][$key]), 2).",".
						round(end($data['pageusereditscount'][$pagename][$key])/end($data['pageedits'][$pagename]), 2).",";
					if(end($data['pagebytes'][$pagename]) != 0){
						echo round(end($data['pageuserbytes'][$pagename][$key]), 2).",".
						round(end($data['pageuserbytescount'][$pagename][$key])/end($data['pagebytes'][$pagename]), 2);
					}else
						echo "0, 0";
					
					if(isset($data['pageuseraveragevalue'][$pagename][$key])) 
						echo ", ".round(end($data['pageuseraveragevalue'][$pagename][$key]), 2).",".
							round(end($data['pageusersd'][$pagename][$key]), 2);
					else
						echo ", -1, -1";
						
					echo "]\n";
					
					if($key != end(array_keys($data['pageuser'][$pagename]))) echo ",";
				}
			?>
			]);


			var table = new google.visualization.Table(document.getElementById('user_table'));
			table.draw(data, {showRowNumber: true});
			
			<?
			if(isset($data['pagecat'][$pagename])){
				echo "var catdata = new google.visualization.DataTable();
				catdata.addColumn('string', 'Name');
				catdata.addRows([";
					foreach(array_keys($data['pagecat'][$pagename]) as $key){
						echo "['".$key."']\n";
						
						if($key != end(array_keys($data['pagecat'][$pagename]))) echo ",";
					}
				echo "]);


				var cattable = new google.visualization.Table(document.getElementById('categories_table'));
				cattable.draw(catdata, {showRowNumber: true});";
			}
			?>
		}
	</script>
	
		<!-- FILTERS FORM -->
	
	<script src="http://yui.yahooapis.com/3.8.0/build/yui/yui-min.js"></script>
	<script>
		YUI().use('autocomplete', 'autocomplete-highlighters', 'autocomplete-filters', function (Y) {
			Y.one('body').addClass('yui3-skin-sam');
			Y.one('#filterstring').plug(Y.Plugin.AutoComplete, {
				resultHighlighter: 'phraseMatch',
				resultFilters: ['subWordMatch'],
				source: function(query){
			var myindex  = document.getElementById("select_filter").selectedIndex;
			var SelValue = document.getElementById("select_filter").options[myindex].value;
		
			if(SelValue == "<?=lang('voc.i18n_user')?>"){
				return [
				<?
					foreach(array_keys($data['useredits']) as $key){
						echo "'".$key."'";
						if($key != end(array_keys($data['useredits']))) echo ",";
					}
				?>
				];
			} else if(SelValue == "<?=lang('voc.i18n_page')?>"){
				return [
				<?
					foreach(array_keys($data['pageedits']) as $key){
						echo "'".$key."'";
						if($key != end(array_keys($data['pageedits']))) echo ",";
					}
				?>
				];
			} else if(SelValue == "<?=lang('voc.i18n_category')?>"){
				return [
				<?
					foreach(array_keys($data['catedits']) as $key){
						echo "'".$key."'";
						if($key != end(array_keys($data['catedits']))) echo ",";
					}
				?>
				];
			}
		}
			});
		});
	</script>

	<? echo form_open('filters_form', array('class' => "yui3-skin-sam")); ?>
	<table id = "bodytable">
	<tr>
		<th colspan = "3"><?=lang('voc.i18n_filter_by')?></th>
	</tr>
	<tr>
		<td style = "width:800px">
		<?
			$options = array(lang('voc.i18n_user') => lang('voc.i18n_user'),
								lang('voc.i18n_page') => lang('voc.i18n_page'),
								lang('voc.i18n_category') => lang('voc.i18n_category')
								//lang('voc.i18n_criteria') => lang('voc.i18n_criteria'))
								);
			echo form_dropdown('select_filter', $options, lang('voc.i18n_user'), "id = 'select_filter'");
			
			echo "   ";
			echo form_input(array('id' => 'filterstring', 'name' => 'filterstring', 'class' => 'cssform'));
		?>
		</td>
	</tr>
	</table>
	
	<? echo form_close(); ?>

	<br><br>
	
<!-- CHARTS -->
	
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
		<th><?=lang('voc.i18n_users')?></th>
	</tr>
	<tr>
		<td><div id='charttotalusers' style='width: 800px; height: 700px; border: 0px; padding: 0px;'></div></td>
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
	<? if (!isset($data['pageuploads'][$pagename])) echo "<!--";?>
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
	<? if (!isset($data['pageuploads'][$pagename])) echo "-->";?>
	<? if (!isset($data['pageaveragevalue'][$pagename])) echo "<!--";?>
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
	<? if (!isset($data['pageaveragevalue'][$pagename])) echo "-->";?>
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
	
	<? if(!isset($data['pagecat'][$pagename])) echo "<!--";?>
	<table id = "pagetable">
	<tr>
		<th><?=lang('voc.i18n_categories')?></th>
	</tr>
	<tr>
		<td><div id = "categories_table"></div></td>
	</tr>
	</table>
	<? if(!isset($data['pagecat'][$pagename])) echo "-->";?>
			
<!-- [2] www.christophermonnat.com/2008/08/generating-pdf-files-using-codeigniter -->
<!--[2] TO_DO: generate pdf-->