<?php if($this->session->flashdata('message')) : ?>
    <p><?=$this->session->flashdata('message')?></p>
<?php endif; ?>

<?php echo form_open('acceso/index', array('class' => 'form-horizontal')); ?>
    <fieldset>
        <legend>Please log in</legend>

        <input type="hidden" name="login" value="enviado">

        <div class="control-group">
            <?php echo form_label('Username:', 'user_name', array('class' => 'control-label')); ?>			
            
            <div class="controls">
                <?php echo form_input('user_name'); ?>
                <?php echo form_error('user_name'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo form_label('Password:', 'user_pass', array('class' => 'control-label')); ?>			

            <div class="controls">
                <?php echo form_password('user_pass'); ?>
                <?php echo form_error('user_pass'); ?>
            </div>
        </div>

        <div class="control-group">            
            <div class="controls">
                <button type="submit" class="btn">Log in</button>
            </div>            
        </div>

    </fieldset>
<?php echo form_close(); ?>