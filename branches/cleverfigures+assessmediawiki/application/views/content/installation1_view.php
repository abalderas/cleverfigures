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
echo img('images/logo/logotrans.png');
echo br();

$languages = array(
           	//'spanish'  => lang('voc.i18n_spanish'),
                'english'    => lang('voc.i18n_english')
                //'french'   => lang('voc.i18n_french'),
                //'russian' => lang('voc.i18n_russian'),
                //'german' => lang('voc.i18n_german'),
             );
?>
            
<?=form_open('select_language_form');?>
<table id = "formins">
<tr>
	<th colspan = "2">Select language</th>
</tr>
<tr>
	<td><?=form_dropdown('select_language', $languages, 'english');?></td>
</tr>
<tr>
	<th class = "next"><?=form_submit(array('id' => 'submit', 'value' => lang('voc.i18n_next'), 'class' => 'next'));?></th>
</tr>
</table>

<?=form_close();?>