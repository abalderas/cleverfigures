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

<?
	function maxlastvalue($array, $masterkey){
		$keys = arsort($array_keys($array));
		foreach($keys as $key)
			if($key <= $masterkey)
				return $array[$masterkey];
	}
?>

<? 
	echo "<h1> ";
	foreach($pagenames as $page){
		echo $page;
		if($page != end($pagenames)) echo " & ";
	}
	echo " </h1></br>";
	
	$defaultpage = $page;
	
?>

<!-- CHARTS SCRIPTS -->

<script type='text/javascript' src='http://www.google.com/jsapi'></script>
	<script type='text/javascript'>
		google.load('visualization', '1', {'packages':['annotatedtimeline', 'corechart', 'table']});
		google.setOnLoadCallback(drawChart<?=$data['pageid'][$page]?>);
		function drawChart() {
			var data1 = new google.visualization.DataTable();
			data1.addColumn('datetime', 'Date');
			<?
				foreach($pagenames as $pagename)
					echo "data1".$data['pageid'][$pagename].".addColumn('number', '".$pagename."');"
			?>
			
			data1.addRows([
			<?
				foreach($revisiondate as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."),";
						foreach($pagenames as $pagename){
							echo maxlastvalue($data['pageedits'][$pagename], $key);
							if($pagename != end($pagenames))
								echo ",";
						}
					echo "]";
					if($key != end(array_keys($data['pageedits'][$pagename]))) 
						echo ",";
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
			data1.addColumn('datetime', 'Date');
			<?
				foreach($pagenames as $pagename)
					echo "data2".$data['pageid'][$pagename].".addColumn('number', '".$pagename."');"
			?>
			
			data2.addRows([
			<?
				foreach($revisiondate as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."),";
						foreach($pagenames as $pagename){
							echo maxlastvalue($data['pagebytes'][$pagename], $key);
							if($pagename != end($pagenames))
								echo ",";
						}
					echo "]";
					if($key != end(array_keys($data['pagebytes'][$pagename]))) 
						echo ",";
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
			<?
				foreach($pagenames as $pagename)
					echo "data3".$data['pageid'][$pagename].".addColumn('number', '".$pagename."');"
			?>
			
			data3.addRows([
			<?
				foreach($revisiondate as $key){
					echo "[new Date(".date('Y', $key).", ".date('m', $key).", ".date('d', $key).", ".date('H', $key).", ".date('i', $key).", ".date('s', $key)."),";
						foreach($pagenames as $pagename){
							echo maxlastvalue($data['pageusercount'][$pagename], $key);
							if($pagename != end($pagenames))
								echo ",";
						}
					echo "]";
					if($key != end(array_keys($data['pageusercount'][$pagename]))) 
						echo ",";
				}
			?>
			]);

			var chartusers = new google.visualization.AnnotatedTimeLine(document.getElementById('charttotalusers'));
			chartusers.draw(data3, {
				'displayAnnotations': false,
				'fill': 20,
                                'legendPosition': 'newRow',
                                'wmode': 'transparent'}
                                );
                        
                        
                       
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
				queryDelimiter: ',',
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