<!--
	INPUT: i18n_generate, i18n_check, i18n_configuration, i18n_submit
	OUTPUT: main_form(generate, check, configuration)
-->

<!--Main form. Lets you choose what to do-->

<?= form_open('main_form') ?>
<?	
	echo form_radio(array('name' => 'select', 'id' => 'generate', 'value' => 'accept', 'checked' => TRUE, 'style'=> 'margin:10px')); 
	echo form_label($i18n_generate, 'generate');
	echo '<br>';
	
	echo form_radio(array('name' => 'select', 'id' => 'check', 'value' => 'accept', 'checked' => TRUE, 'style'=> 'margin:10px'));
	echo form_label($i18n_check, 'check');
	echo '<br>';
	
	echo form_radio(array('name' => 'select', 'id' => 'configuration', 'value' => 'accept', 'checked' => TRUE, 'style'=> 'margin:10px'));
	echo form_label($i18n_configuration, 'configuration');
	echo '<br><br>';
	
	echo form_submit('submit_main', $i18n_submit);
?>
<?= form_close() ?>