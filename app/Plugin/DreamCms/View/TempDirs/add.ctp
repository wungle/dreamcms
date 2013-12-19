
<div class="row">
	<div class="col-sm-12">
		<h2><?php echo __('Add Temp Dir'); ?></h2>
		<div class="tempDirs form">
			<?php echo $this->Form->create('TempDir', array('role' => 'form')); ?> 
				<fieldset>
					<div class="form-group">
						<?php echo $this->Form->input('path', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('lifespan', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('deleted', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary')); ?>
				</fieldset>
			<?php echo $this->Form->end(); ?> 
		</div>
	</div>
</div>