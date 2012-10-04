<!--
	INPUT: i18n_language, i18n_spanish, i18n_english, i18n_french, i18n_german, i18n_russian, i18n_save_conf
	OUTPUT: configuration_form(select_language, save_conf, [1])
-->

<!--Main form. Lets you choose what to do-->

<?	
echo form_open('configuration_form');
	echo "<h3>$i18n_language</h3><br>";

	$languages = array(
                  'spanish'  => $i18n_spanish,
                  'english'    => $i18n_english,
                  'french'   => $i18n_french,
                  'russian' => $i18n_russian,
                  'german' => $i18n_german,
                );
                
	echo form_dropdown('select_language', $languages, 'english');
	echo '<br>';
	
	echo form_submit('save_conf', $i18n_save_conf);

	//[1]
echo form_close();
?>

<!--[1] TO_DO: add more, be carefull, one more up there in the initial comment-->