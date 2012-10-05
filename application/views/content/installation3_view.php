<!--
	INPUT: 	i18n_assessMW_database, i18n_cleverfigures_database, i18n_database_data, i18n_database_name, i18n_installation_databases
		i18n_next, i18n_password, i18n_server, i18n_username, i18n_wiki_database, i18n_database_type
	OUTPUT: connect_databases_form(server1, username1, password1, database_name1, server2, username2, password2, database_name2, 
		server3, username3, password3, database_name3)
-->

<?
echo $i18n_installation_databases;

echo "<h3>$i18n_database_data</h3>";
echo form_open('connect_databases_form');
?>
<table cellspacing="0" cellpadding="5" border="0">
<tr>
	<td>
		<table cellspacing="0" cellpadding="5" border="0">
		<tr><h3><?=$i18n_wiki_database?></h3></tr>
		<tr>
			<td class="fieldbox"><?=$i18n_server?>:</td>
			<td><?= form_input('server1') ?></td>
		</tr>
		<tr>
			<td class="fieldbox"><?=$i18n_username?>:</td>
			<td><?= form_input('username1') ?></td>
		</tr>
		<tr>
			<td class="fieldbox"><?=$i18n_password?>:</td>
			<td><?= form_password('password1') ?></td>
		</tr>
		<tr>
			<td class="fieldbox"><?=$i18n_database_name?>:</td>
			<td><?= form_input('database_name1') ?></td>
		</tr>
		</table>	
	</td>
	<td>
		<table cellspacing="0" cellpadding="5" border="0">
		<tr><h3><?=$i18n_assessMW_database?></h3></tr>
		<tr>
			<td class="fieldbox"><?=$i18n_server?>:</td>
			<td><?= form_input('server2') ?></td>
		</tr>
		<tr>
			<td class="fieldbox"><?=$i18n_username?>:</td>
			<td><?= form_input('username2') ?></td>
		</tr>
		<tr>
			<td class="fieldbox"><?=$i18n_password?>:</td>
			<td><?= form_password('password2') ?></td>
		</tr>
		<tr>
			<td class="fieldbox"><?=$i18n_database_name?>:</td>
			<td><?= form_input('database_name2') ?></td>
		</tr>
		<tr>
			<td class="fieldbox"><?=$i18n_database_type?>:</td>
			<?
			$types = array(
                  		'assess' => 'AssessMediaWiki',
                  		// You can add more types here, but you'll have to create 
                  		// new stuff somewhere to control it.
                		);

			echo form_dropdown('types_dropdown', $types, 'assess');
			?>
		</tr>
		</table>	
	</td>
	<td>
		<table cellspacing="0" cellpadding="5" border="0">
		<tr><h3><?=$i18n_cleverfigures_database?></h3></tr>
		<tr>
			<td class="fieldbox"><?=$i18n_server?>:</td>
			<td><?= form_input('server3') ?></td>
		</tr>
		<tr>
			<td class="fieldbox"><?=$i18n_username?>:</td>
			<td><?= form_input('username3') ?></td>
		</tr>
		<tr>
			<td class="fieldbox"><?=$i18n_password?>:</td>
			<td><?= form_password('password3') ?></td>
		</tr>
		<tr>
			<td class="fieldbox"><?=$i18n_database_name?>:</td>
			<td><?= form_input('database_name3') ?></td>
		</tr>
		</table>	
	</td>
</tr>
</table>
<?= form_submit('next', $i18n_next) ?>
<?=form_close();?> 
