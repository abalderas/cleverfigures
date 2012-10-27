<!--
	OUTPUT: select_language_form(select_language, next)
-->

<?
echo "<h1>".lang('i18n_installation')."</h1></br>";

echo "Select language for the installation process: ";

$languages = array(
           	'spanish'  => lang('i18n_spanish'),
                'english'    => lang('i18n_english'),
                'french'   => lang('i18n_french'),
                'russian' => lang('i18n_russian'),
                'german' => lang('i18n_german'),
             );
            
echo form_open('select_language_form');
echo form_dropdown('select_language', $languages, 'english');
echo '<br>';
echo form_submit('next', 'Next');
echo form_close();
?>