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

echo form_open('configuration_form');
?>

<?
			$languages = array(
		           	//'spanish'  => lang('voc.i18n_spanish'),
		                'english'    => lang('voc.i18n_english')
		                //'french'   => lang('voc.i18n_french'),
		                //'russian' => lang('voc.i18n_russian'),
		                //'german' => lang('voc.i18n_german'),
		             );
		?>
	
		<table id = "bodytable">
		<tr>
			<th colspan = "2"><?=lang('voc.i18n_your_data');?></th>
		</tr>
		<tr>
			<td><?=form_label(lang('voc.i18n_name'), lang('voc.i18n_name'));?></td><td><?=$this->session->userdata('realname')?></td>
		</tr>
		<tr>
			<td><?=lang('voc.i18n_role')?></td>
			<td>
				<?
					if($this->session->userdata('is_admin')) 
						echo lang('voc.i18n_admin');
					else if ($this->session->userdata('is_student'))
						echo lang('voc.i18n_student');
					else
						echo lang('voc.i18n_teacher');
				?>
			</td>
		</tr>
		<tr>
			<th colspan = "2"><?=lang('voc.i18n_language');?></th>
		</tr>
		<tr>
			<td><?=form_label(lang('voc.i18n_select_language'), 'select_language');?></td>
			<td><?=form_dropdown('select_language', $languages, 'english');?></td>
		</tr>
		<tr>
			<th colspan = "2"><?=lang('voc.i18n_data_source');?></th>
		</tr>
		<tr>
			<td><?=form_label(lang('voc.i18n_add_wiki'), 'add_wiki');?></td>
			<td><?=form_submit('add_wiki', lang('voc.i18n_add_wiki'));?></td>
		</tr>
		<tr>
			<td><?=form_label(lang('voc.i18n_add_color'), 'add_color');?></td>
			<td><?=form_submit('add_color', lang('voc.i18n_add_color'));?></td>
		</tr>
		
		<? if(!isset($admin) || !$admin) echo "<!--" ?>
		<tr>
			<th colspan = "2"><?=lang('voc.i18n_users');?></th>
		</tr>
		<tr>
			<td><?=form_label(lang('voc.i18n_add_user'), 'add_user');?></td>
			<td><?=form_submit('add_user', lang('voc.i18n_add_user'));?></td>
		</tr>
		<tr>
			<th colspan = "2"><?=lang('voc.i18n_accessibility');?></th>
		</tr>
		<tr>
			<td><?=form_label(lang('voc.i18n_high_contrast'), 'high_contrast');?></td>
			<td><?=form_checkbox('high_contrast', '', $this->session->userdata('high_contrast'));?></td>
		</tr>
		<tr>
			<td><br></td>
		</tr>
		<tr>
			<th colspan = "2"><?=form_submit(array('name' => 'save_conf', 'value' => lang('voc.i18n_save_conf'), 'class' => 'next'));?></th>
		</tr>
		</table>
		
		<? if(!isset($admin) || !$admin) echo "-->" ?>
		
		<? 
			if(!isset($wikilist)) 
				echo "<!--";
			else{
				echo "<br><table id = 'bodytable'>";
				echo "<tr><th colspan = '2'>".lang('voc.i18n_your_wikis')."</th></tr>";
				foreach($wikilist as $wiki)
					echo "<tr><td>".$wiki."</td><td></td></tr>";
				echo "</table>";
			}
		
			if(!isset($wikilist)) echo "-->";
		?>
		
		<?
			if(empty($colorlist)) 
				echo "<!--";
			else{
				echo "<br><table id = 'bodytable'>";
				echo "<tr><th colspan = '2'>".lang('voc.i18n_your_qualitative_sources')."</th></tr>";
				foreach($colorlist as $color)
					echo "<tr><td>".$color."</td><td></td></tr>";
				echo "</table>";
			}
		
			if(empty($colorlist)) echo "-->";
		?>
		
<?=form_close();?>


<div id ="footer">
	<table>
	<tr>
		<th><?=safe_mailto('alvaro.almagrodoello@alum.uca.es', lang('voc.i18n_contact'))?></th>
		<th><?=anchor('license/gpl.txt',lang('voc.i18n_license'))?></th>
		<th><?=anchor('about',lang('voc.i18n_about'))?></th>
		</tr>
	</table>
</div>
