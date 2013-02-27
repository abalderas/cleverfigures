<h2>List of students</h2>

<table class="table table-striped table-hover table-condensed table-bordered">
	<thead>
		<tr>
			<th>Students</th>
			<th>Report</th>
			<th>CSV</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($alumnos as $key => $value) { ?>
	<tr>
		<td><?php echo $alumnos[$key]; ?></td>
		<td><?php echo anchor(site_url("feedback/informe/" . $key), "Report"); ?></td>
		<td><?php echo anchor(site_url("feedback/csv/" . $key), "CSV"); ?></td>
	</tr>
<?php } ?>
	</tbody>
</table>
