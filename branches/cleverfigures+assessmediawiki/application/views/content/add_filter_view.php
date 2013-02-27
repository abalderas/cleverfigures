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
		<td><?=lang('voc.i18n_filter_id')?>:</td>
		<td><?= form_input('filterid') ?></td>
	</tr>
	<?php if(form_error('filterid')) echo "<tr><td colspan = \"2\"><em>".form_error('filterid')."</em></td></tr>"; ?>
	<tr>
		<td><?=form_checkbox('filterusercheck', 'filterusercheck', FALSE); ?><?=lang('voc.i18n_filter_by_user')?>:</td>
		<td><?= form_input('filteruser') ?></td>
	</tr>
	<?php if(form_error('filteruser')) echo "<tr><td colspan = \"2\"><em>".form_error('filteruser')."</em></td></tr>"; ?>
	<tr>
		<td><?=form_checkbox('filterpagecheck', 'filterpagecheck', FALSE); ?><?=lang('voc.i18n_filter_by_page')?>:</td>
		<td><?= form_input('filterpage') ?></td>
	</tr>
	<?php if(form_error('filterpage')) echo "<tr><td colspan = \"2\"><em>".form_error('filterpage')."</em></td></tr>"; ?>
	<tr>
		<td><?=form_checkbox('filtercategorycheck', 'filtercategorycheck', FALSE); ?><?=lang('voc.i18n_filter_by_category')?>:</td>
		<td><?= form_input('filtercategory') ?></td>
	</tr>
	<?php if(form_error('filtercategory')) echo "<tr><td colspan = \"2\"><em>".form_error('filtercategory')."</em></td></tr>"; ?>
	<tr>
		<td><?=form_checkbox('filtercriteriacheck', 'filtercriteriacheck', FALSE); ?><?=lang('voc.i18n_filter_by_criteria')?>:</td>
		<td><?= form_input('filtercriteria') ?></td>
	</tr>
	<?php if(form_error('filtercriteria')) echo "<tr><td colspan = \"2\"><em>".form_error('filtercriteria')."</em></td></tr>"; ?>
	<tr>
		<td><?=lang('voc.i18n_dates')?>:</td>
		<td><? echo lang('voc.i18n_from')." "; echo form_input(array('id' => 'date_range_a', 'name' => 'date_range_a', 'value' => lang('voc.i18n_date_range_a'))); ?>
		    <? echo " ".lang('voc.i18n_to')." "; echo form_input(array('id' => 'date_range_b', 'name' => 'date_range_b', 'value' => lang('voc.i18n_date_range_b'))); ?></td>
	</tr>
	
	<?php if(isset($date_error)) echo "<tr><td colspan = \"2\"><em>$date_error</em></td></tr>"; ?>
	<?php if(isset($type_error)) echo "<tr><td colspan = \"2\"><em>$type_error</em></td></tr>"; ?>
	<tr>
		<th colspan = "2"><?=form_submit(array('id' => 'submit', 'value' => lang('voc.i18n_save')));?></th>
	</tr>
</table>

<?
echo form_close();
?>