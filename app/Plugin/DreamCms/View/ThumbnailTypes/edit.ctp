
<div class="row">
	<div class="col-sm-12">
		<h2><?php echo __('Edit Thumbnail Type'); ?></h2>
		<div class="thumbnailTypes form">
			<?php echo $this->Form->create('ThumbnailType', array('role' => 'form')); ?> 
				<fieldset>
					<div class="form-group">
						<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('width', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('height', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('method', array('class' => 'form-control')); ?>
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