<h2>Summary of <?php if(isset($reply_number)) echo "reply $reply_number"; else echo "assessment"; ?></h2>

<div class="row">
	<div class="span3">
		<ul>
			<li>Author:
			<?php echo $usuario; ?></li>
		
		<?php if ($this->acceso->es_admin($usuario_id) || $revisor == 'Admin' || $revisor == $usuario) { ?>
			<li>Revisor:
			<?php echo $revisor; ?></li>
		<?php } ?>
		
			<li>Revision ID: <?php echo $entrada; ?></li>
			<li>Revision link:
			<?php echo anchor_popup(wiki_revision_url($entrada), 'url'); ?></li>
		
		</ul>
	</div>
	
	<div class="span8 offset1">
		<table class="table table-striped table-hover table-condensed table-bordered">	
			<thead>
				<tr>
					<th>Revision</th>
					<th>Grade</th>
					<th>Description</th>
				</tr>
			</thead>
			<?php
				foreach ($entregables as $i => $valor)
				{
			?>	
			<tr>
				<td><?php echo $entregables[$i]; ?></td> 
				<td><?php echo $puntuacion[$i]; ?></td>
				<td><?php echo $comentarios[$i]; ?></td>		
			</tr>
			<?php
				}
			?>
		</table>
	</div>
</div>

<?php if ($evaluacion != 0 && (!isset($post_url) || $post_url != "evaluar/reply_submit")) { ?>
	<p>If you don't agree with your evaluation, you may reply <?php echo anchor(site_url("evaluar/reply/" . $evaluacion), "clicking here"); ?>.</p>
<?php } ?>


