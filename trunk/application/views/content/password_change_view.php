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
?>

<script>
	function checkform(){
		if (document.getElementsByName('password')[0].value == '' || document.getElementsByName('password_confirmation')[0].value == ''){
			alert('<?=lang('voc.i18n_empty_fields')?>');
			return false;
		}
		else if (document.getElementsByName('password')[0].value != document.getElementsByName('password_confirmation')[0].value){
			alert('<?=lang('voc.i18n_mismatching_passwords')?>');
			return false;
		}
		
		return true;
	}
</script>

<?
echo form_open('password_change');
?>

<table id = "variabletable">
	<tr>
		<th colspan = "2" class = 'only'><?=lang('voc.i18n_change_password');?></th>
	</tr>
	<tr>
		<td><?=lang('voc.i18n_password')?>:</td>
		<td><?=form_password('password') ?></td>
	</tr>
	<tr>
		<td><?=lang('voc.i18n_retype_password')?>:</td>
		<td><?=form_password('password_confirmation') ?></td>
	</tr>
	<tr>
		<th colspan = "2" class = 'low'><?=form_submit(array('id' => 'password_change_submit', 'name' => 'password_change_submit', 'value' => lang('voc.i18n_change_password'), 'onClick' => "return checkform()"))?></th>
	</tr>
</table>
	
<?= form_close();?>
