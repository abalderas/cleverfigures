<?php echo form_open('parametros/' . $modo, array('class' => 'form-horizontal')); ?>
    <fieldset>
        <legend><?php echo $titulo; ?></legend>

        <?php 
        if ($modo == "update"){ 
            echo form_hidden('ent_id', $ent_id);
        }
        ?>

        <div class="control-group">
            <?php echo form_label('Title:', 'ent_entregable', array('class' => 'control-label')); ?>			
            
            <div class="controls">
                <?php echo form_input($ent_entregable); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo form_label('Description:', 'ent_description', array('class' => 'control-label')); ?>			

            <div class="controls">
                <?php echo form_input($ent_description); ?>
            </div>
        </div>

        <div class="control-group">            
            <div class="controls">
                <button type="submit" class="btn">Send</button>
            </div>            
        </div>

    </fieldset>
<?php echo form_close(); ?>