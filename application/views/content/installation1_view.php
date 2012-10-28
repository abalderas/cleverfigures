<!--
	OUTPUT: select_language_form(select_language, next)
-->

<?
echo "<h1>".lang('voc.i18n_installation')."</h1></br>";

$languages = array(
           	'spanish'  => lang('voc.i18n_spanish'),
                'english'    => lang('voc.i18n_english'),
                'french'   => lang('voc.i18n_french'),
                'russian' => lang('voc.i18n_russian'),
                'german' => lang('voc.i18n_german'),
             );
?>
            
<?=form_open('select_language_form');?>
<table id = "formins">
<tr>
	<th>Select language for the installation process:</th>
</tr>

<tr>
	<td><?=form_dropdown('select_language', $languages, 'english');?></td>
</tr>

</table>

<div id = "nextbutton"><?=form_submit(array('id' => 'submit', 'value' => lang('voc.i18n_next'), 'class' => 'submit'));?></div>

<?=form_close();?>