<?php	
	if (!isset($evaluaciones_pendientes) || $evaluaciones_pendientes > 0)
	{	
		
?>
<p><?php echo $msg . " " . anchor_popup(wiki_revision_url($entrada), "This is the url to assess");?>.</p>

<?php echo form_open($post_url); ?>
    <div class="textfield">           
		<?php
			$options = array();
			for ($i = 0; $i<=10; $i++)
				array_push($options, $i);
		?>
		<table class="table table-striped table-hover table-condensed table-bordered">
			<thead>
				<tr class="head">
					<th colspan='2'>Revision</th>
					<th>Grade</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
		<?php foreach ($campos as $i => $valor) { ?>
			<tr>
				<td>
					<?php echo form_checkbox('campo['.$i.']'); ?>
				</td>
				<td>
					<p>
						<strong><?php echo $valor; ?></strong>
					</p>
					<p class="description">
						<?php echo $descriptions[$i]; ?>
					</p>
				</td>
				<td>
					<?php echo form_dropdown('puntuacion['.$i.']', $options); ?>
				</td>
				
				<?php
					$info_descripcion = array(
						'name' => 'descripcion['.$i.']',
						'size' => '40',
						'maxlength' => '250');
				?>
				<td><?php echo form_input($info_descripcion); ?></td>
			</tr>
			<?php
			}
		?>
			</tbody>
		</table>
		<?php echo form_hidden('entrada', $entrada); ?>
		<?php echo form_hidden('user_id', $usuario_a_revisar); ?>
		<?php
			// Tiempo en el que se entra en el formulario.
			// Utilizado para saber el tiempo dedicado a rellenar.
			echo form_hidden('time', time());
		?>
		<?php
			// In case of reply.
			if (isset($evaluacion))
				echo form_hidden('rep_read', $evaluacion); 
		?>
    </div>

    <div class="buttons">
        <?php echo form_submit('puntuar', 'Puntuar'); ?>
    </div>

<?php echo form_close(); ?>

<script>
$(document).ready(function(){
	$("select").change(function(){
		$(this).closest("tr").find("input[type='checkbox']").attr("checked", "checked");
	})
});
</script>

<?php
		} // Fin evaluaciones pendientes
	
?>
