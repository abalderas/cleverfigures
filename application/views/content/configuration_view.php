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

<!--Main form. Lets you choose what to do-->

<?	
echo "<h1>".lang('i18n_configuration')."</h1></br>";

echo form_open('configuration_form');
	echo "<h3>".lang('i18n_language')."</h3><br>";

	$languages = array(
           	'spanish'  => lang('i18n_spanish'),
                'english'    => lang('i18n_english'),
                'french'   => lang('i18n_french'),
                'russian' => lang('i18n_russian'),
                'german' => lang('i18n_german'),
             );
   
	echo form_dropdown('select_language', $languages, 'english');
	echo '<br>';
	
	echo "<h3>".lang('i18n_data_origin')."</h3><br>";
	echo form_label('Wiki', 'select_wiki');
	//echo form_dropdown('select_wiki', $wikis);
	echo '<br>';
	
	echo form_label(lang('i18n_qualitative_data_origin'), 'select_color');
	//echo form_dropdown('select_color', $colors);
	echo '<br>';
	
	echo form_submit('save_conf', lang('i18n_save_conf'));

echo form_close();
?>