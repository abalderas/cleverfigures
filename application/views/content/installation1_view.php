<!--
	OUTPUT: select_language_form(select_language, next)
-->

<?
echo img('images/logo/logotrans.png');
echo br();

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