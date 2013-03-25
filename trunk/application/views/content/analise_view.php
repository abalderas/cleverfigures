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
	function checkwiki(){
		if (document.getElementsByName('select_wiki')[0].value == '<?=lang('voc.i18n_no_wiki')?>'){
			alert('<?=lang('voc.i18n_must_choose_wiki')?>');
			return false;
		}
		return true;
	}
</script>

<?=form_open('analisis_form')?>
<table id = "bodytable">
	<tr>
		<th class = 'only' colspan = "2"><?=lang('voc.i18n_data_source')?></th>
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
		<th class = 'low' colspan = "2"><?=form_submit(array('id' => 'analise_submit','name' => 'analise_submit','value' => lang('voc.i18n_analise'),'onClick' => "return checkwiki()"));?></th>
	</tr>
</table>

<?= form_close() ?>