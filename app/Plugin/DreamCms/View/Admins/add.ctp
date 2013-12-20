
<?php $this->startIfEmpty('breadcrumb'); ?>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="#"><?php echo __('Home'); ?></a>
							</li>
							<li class="active"><?php echo __('Admins'); ?></li>
						</ul><!-- .breadcrumb -->
<?php $this->end(); ?>

<div class="row">
	<div class="col-sm-12">
		<h2><?php echo __('Add Admin'); ?></h2>
		<div class="admins form">
			<?php echo $this->Form->create('Admin', array('role' => 'form')); ?> 
				<fieldset>
					<div class="form-group">
						<?php echo $this->Form->input('group_id', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('username', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('password', array('type' => 'password', 'class' => 'form-control', 'required' => true)); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('password_confirm', array('type' => 'password', 'class' => 'form-control', 'required' => true)); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('real_name', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('email', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('active', array('options' => array('Yes' => 'Yes', 'No' => 'No'), 'class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary')); ?>
				</fieldset>
			<?php echo $this->Form->end(); ?> 
		</div>
	</div>
</div>