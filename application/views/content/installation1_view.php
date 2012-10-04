<!--
	INPUT: i18n_select_language_intro, i18n_spanish, i18n_english, i18n_french, i18n_german, i18n_russian, i18n_save_conf
	OUTPUT: configuration_form(select_language, save_conf, [1])
-->

<?
echo $i18n_select_language_intro

$languages = array(
           	'spanish'  => $i18n_spanish,
                'english'    => $i18n_english,
                'french'   => $i18n_french,
                'russian' => $i18n_russian,
                'german' => $i18n_german,
             );
                
echo form_dropdown('select_language', $languages, 'english');
echo '<br>';
	
echo form_submit('next', $i18n_next);
	
?>