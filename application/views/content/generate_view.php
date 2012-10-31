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

<?= "<h1>".lang('i18n_analise')."</h1></br>"?>

<table>
	<tr>
		<th><?=lang('i18n_wiki')?>:</th>
		<th><?=lang('i18n_color')?></th>
		<th><?=lang('i18n_date_hour')?></th>
	</tr>
	<tr>
		<td><?= $wikiname?>:</td>
		<td><?= $colorname?>:</td>
		<td><?= $timestamp?>:</td>
	</tr>
</table>
<?= form_close() ?>