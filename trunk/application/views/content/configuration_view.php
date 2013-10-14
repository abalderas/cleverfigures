<?

// <<Copyright 2013 Alvaro Almagro Doello>>
// 
// This file is part of CleverFigures.
// 
// CleverFigures is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// CleverFigures is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with CleverFigures.  If not, see <http://www.gnu.org/licenses/>.

if(isset($wikideleteerror)) echo "<em>".lang('voc.i18n_error_deleting_wiki')."</em>";
if(isset($userdeleteerror)) echo "<em>".lang('voc.i18n_error_deleting_user')."</em>";

echo form_open('configuration_form');

if($this->session->userdata('is_admin')){
	$users = $this->user_model->get_users_list();
	$columns = (count($users) == 1) ? '2' : '3' ;
	echo
		"<table id = 'variabletable'>
		<tr>
		<th colspan = '" . $columns . "'>".lang('voc.i18n_users')."</th>
		</tr>";

	foreach($users as $user){
		echo "
			<tr>
			<td>" .
			$this->user_model->get_real_name($user) . " (" . $user . ")" . "</td>
			<td>".($this->user_model->is_admin($user) ? lang('voc.i18n_admin') : lang('voc.i18n_teacher')) .
			" </td>".
			(($this->session->userdata('username') != $user) ? 
			 "<td>" . anchor("delete_user/deleteuser/$user",lang('voc.i18n_delete'), 
				 array('onClick' => "return confirm('".lang('voc.i18n_delete_user_confirmation')."');")) . "</td>" : "" )."</tr>";
	}

	echo "</table><br>";
}
?>

<?
$languages = array(
		'spanish'  => lang('voc.i18n_spanish'),
		'english'    => lang('voc.i18n_english'),
		'french'   => lang('voc.i18n_french'),
		'russian' => lang('voc.i18n_russian'),
		'german' => lang('voc.i18n_german')
		);
?>

  <div style="float:left; width:<?=(empty($wikilist) && empty($colorlist)) ? '100%' : '50%';?>">
    <table id = "variabletable">
    <tr>
      <th colspan = "2"><?=lang('voc.i18n_options');?></th>
    </tr>
    <tr>
      <td><?=form_label(lang('voc.i18n_select_language'), 'select_language');?></td>
      <td><?=form_dropdown('select_language', $languages, $this->session->userdata('language'));?></td>
    </tr>
    <tr>
      <td><?=form_label(lang('voc.i18n_add_wiki'), 'add_wiki');?></td>
      <td><?=form_submit('add_wiki', lang('voc.i18n_add_wiki'));?></td>
    </tr>
    <tr>
      <td><?=form_label(lang('voc.i18n_add_color'), 'add_color');?></td>
      <td><?=form_submit('add_color', lang('voc.i18n_add_color'));?></td>
    </tr>
    <? if($this->session->userdata('is_admin')) { ?>
    <tr>
      <td><?=form_label(lang('voc.i18n_add_user'), 'add_user');?></td>
      <td><?=form_submit('add_user', lang('voc.i18n_add_user'));?></td>
    </tr>
    <? } ?>
    <tr>
      <td><?=form_label(lang('voc.i18n_high_contrast'), 'high_contrast');?></td>
      <td><?=form_checkbox('high_contrast', '', $this->session->userdata('high_contrast'));?></td>
    </tr>
    <tr>
      <td><?=form_label(lang('voc.i18n_change_password'), 'change_password');?></td>
      <td><?=form_submit('change_password', lang('voc.i18n_change_password'));?></td>
    </tr>
    <tr>
      <th class = 'low' colspan = "2"><?=form_submit(array('name' => 'save_conf', 'value' => lang('voc.i18n_save_conf'), 'class' => 'next'));?></th>
    </tr>
    </table>
</div>
    <? 
    if(!empty($wikilist) || !empty($colorlist)) {
      echo "<div style='float:right; width:50%'>";
    }
    if(!empty($wikilist)) {
      echo "<table id = 'variabletable'>";
      echo "<tr><th colspan = '2'>".lang('voc.i18n_your_wikis')."</th></tr>";
      foreach($wikilist as $wiki)
        echo "<tr><td>" . $wiki . "</td><td>" . anchor("groups/getgroups/$wiki", lang('voc.i18n_manage_groups')) . "  |  " .
        anchor("delete_wiki/deletewiki/$wiki", lang('voc.i18n_delete'),
	array('onClick' => "return confirm('" . lang('voc.i18n_delete_wiki_confirmation') . "');"))
	. "</td></tr>";
      echo "</table><br>";
    }
    if(!empty($colorlist)){
      echo "<table id = 'variabletable'>";
      echo "<tr><th colspan = '2'>" . lang('voc.i18n_your_qualitative_sources') . "</th></tr>";
      foreach($colorlist as $color)
	echo "<tr><td>" . $color . "</td><td>" . 
        anchor("delete_color/deletecolor/$color", lang('voc.i18n_delete'),
        array('onClick' => "return confirm('" . lang('voc.i18n_delete_color_confirmation') . "'); ")) .
        "</td></tr>";
      echo "</table>";
    }
    if(!empty($wikilist) || !empty($colorlist)) {
      echo "</div>";
    }
    ?>

<?=form_close()?>

<div id ="footer">
  <table>
  <tr>
    <th>
      <?=safe_mailto('alvaro.almagrodoello@alum.uca.es', lang('voc.i18n_contact'))?> |
      <?=anchor('license/gpl.txt',lang('voc.i18n_license'))?> |
      <?=anchor('about',lang('voc.i18n_about'))?>
    </th>
  </tr>
  </table>
</div>
