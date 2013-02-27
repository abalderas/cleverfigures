<h2>List of revisions</h2>

<table class="table table-striped table-hover table-condensed table-bordered">
	<thead>
		<tr>
			<th>Revision</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
<?php foreach($articulos as $id => $value) { ?>	
		<tr>
			<td><?php echo $value;	?></td>
			<td><?php echo anchor(site_url("evaluar/mostrar_evaluacion/" . $id), "See full report (" . $this->replies->replies_amount($id) ." replies)"); ?> </td>
		</tr>
<?php }	?>
	</tbody>
</table>

<h5>* In brackets the number of replies</h5>
