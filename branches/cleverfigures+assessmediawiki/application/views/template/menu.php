<div class="row">
    <div class="span12">
        <div class="navbar">
            <div class="navbar-inner">
                <ul class="nav">
                	<li><?php echo anchor(site_url("evaluar"), "Assess"); ?></li>
					<li><?php echo anchor(site_url("feedback"), "My assessments"); ?></li>
					<li class="divider-vertical"></li>
<?php if ($this->session->userdata('is_admin')) { ?>
					<li><?php echo anchor(site_url("alumnos"), "Students"); ?></li>
					<li><?php echo anchor(site_url("parametros"), "Parameters"); ?></li>
					<li class="divider-vertical"></li>
<?php } ?>					
					<li class="pull-right"><?php echo anchor(site_url("acceso/salir"), "Logout"); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div> <!-- .row -->