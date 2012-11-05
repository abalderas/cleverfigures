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


echo "<h1>".lang('voc.i18n_add_filter')."</h1>";

echo form_open('add_filter');
?>

</br>

<table id = "bodytable">
	<tr>
		<th colspan = "2" ><?=lang('voc.i18n_add_filter')?></th>
	</tr>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_filter_id')?>:</td>
		<td><?= form_input('filterid') ?></td>
	</tr>
	<?php if(form_error('filterid')) echo "<tr><td colspan = \"2\"><em>".form_error('filterid')."</em></td></tr>"; ?>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_filter_type')?>:</td>
		<td><?= form_input('filter_type') ?></td>
	</tr>
	<?php if(form_error('filter_type')) echo "<tr><td colspan = \"2\"><em>".form_error('filter_type')."</em></td></tr>"; ?>
	<tr>
		<td class="fieldbox"><?=lang('voc.i18n_filter_name')?>:</td>
		<td><?= form_input('filter_name') ?></td>
	</tr>
	<?php if(form_error('filter_name')) echo "<tr><td colspan = \"2\"><em>".form_error('filter_name')."</em></td></tr>"; ?>
	
	<?php if(isset($connection_error)) echo "<tr><td colspan = \"2\"><em>$connection_error</em></td></tr>"; ?>
	<tr>
		<th colspan = "2"><?=form_submit(array('id' => 'submit', 'value' => lang('voc.i18n_save')));?></th>
	</tr>
</table>

<?
echo form_close();
?>