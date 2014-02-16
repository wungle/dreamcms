
<?php $this->startIfEmpty('breadcrumb'); ?>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="<?php echo $this->Html->url('/dreamcms'); ?>"><?php echo __('Home'); ?></a>
							</li>
							<li class="active"><?php echo __('Temporary Dirs'); ?></li>
						</ul><!-- .breadcrumb -->
<?php $this->end(); ?>

<div class="row">
	<div class="col-sm-12">
		<h2><?php echo __('Edit Temporary Dir'); ?></h2>
		<div class="tempDirs form">
			<?php echo $this->Form->create('TempDir', array('role' => 'form')); ?> 
				<fieldset>
					<div class="form-group">
						<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->label('path'); ?> 
						<div class="input-group">
							<span class="input-group-addon">
								<i class="icon-folder-open"></i>&nbsp; <b>WWW_ROOT</b>/
							</span>
							<?php echo $this->Form->input('path', array('class' => 'form-control', 'label' => false)); ?> 
						</div>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('lifespan', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary')); ?>
				</fieldset>
			<?php echo $this->Form->end(); ?> 
		</div>


		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<?php echo $this->element('common/record_history', array('record_id' => $this->request->data['TempDir']['id'])); ?> 


	</div>
</div>