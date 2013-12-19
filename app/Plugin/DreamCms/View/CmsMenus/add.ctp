
<div class="row">
	<div class="col-sm-12">
		<h2><?php echo __('Add Cms Menu'); ?></h2>
		<div class="cmsMenus form">
			<?php echo $this->Form->create('CmsMenu', array('role' => 'form')); ?> 
				<fieldset>
					<div class="form-group">
						<?php echo $this->Form->input('parent_id', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('url', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('published', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('deleted', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('lft', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('rght', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary')); ?>
				</fieldset>
			<?php echo $this->Form->end(); ?> 
		</div>
	</div>
</div>