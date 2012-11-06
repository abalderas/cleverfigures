<?
// <<Copyright 2013 Alvaro Almagro Doello>>
// 
// This file is part of CleverFigures.
// 
// CleverFigures is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// CleverFigures is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with CleverFigures.  If not, see <http://www.gnu.org/licenses/>.

echo "<h1>".lang('voc.i18n_analise')."</h1></br>";
?>

<?=form_open()?>
<table id = "bodytable">
	<tr>
		<th colspan = "2"><?=lang('voc.i18n_data_source')?></th>
	</tr>
	<tr>
		<td><?=lang('voc.i18n_wiki')?></td>
		<td><?=form_dropdown('select_wiki', $wikis);?></td>
	</tr>
	<tr>
		<td><?=lang('voc.i18n_color')?></td>
		<td><?=form_dropdown('select_color', $colors);?></td>
	</tr>
	<tr>
		<th colspan = "2"><?=lang('voc.i18n_dates')?></th>
	</tr>
	<tr>
		<td><?=lang('voc.i18n_date_range_a')?></td>
		<td><?=form_input('select_date_range_a');?></td>
	</tr>
	<tr>
		<td><?=lang('voc.i18n_date_range_b')?></td>
		<td><?=form_input('select_date_range_b');?></td>
	</tr>
	<tr>
		<th colspan = "2"><?=lang('voc.i18n_filters')?></th>
	</tr>
	<tr>
		<td><?=lang('voc.i18n_filter_by')?></td>
		<td><?=form_dropdown('select_filter', $filters);?></td>
	</tr>
	<tr>
		<th colspan = "2"><?=form_submit('analise_submit', lang('voc.i18n_analise'));?></th>
	</tr>
</table>

<?= form_close() ?>