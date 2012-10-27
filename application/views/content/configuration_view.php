<!--
	INPUT: $wikis, $colors
	OUTPUT: configuration_form(select_language, save_conf, select_color, select_wiki)
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
	echo form_dropdown('select_wiki', $wikis);
	echo '<br>';
	
	echo form_label(lang('i18n_qualitative_data_origin'), 'select_color');
	echo form_dropdown('select_color', $colors);
	echo '<br>';
	
	echo form_submit('save_conf', lang('i18n_save_conf'));

echo form_close();
?>