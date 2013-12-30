
<?php $this->startIfEmpty('breadcrumb'); ?>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="#"><?php echo __('Home'); ?></a>
							</li>
							<li class="active"><?php echo __('File Types'); ?></li>
						</ul><!-- .breadcrumb -->
<?php $this->end(); ?>

<div class="row">
	<div class="col-sm-12">
		<h2><?php echo __('Edit File Type'); ?></h2>
		<div class="fileTypes form">
			<?php echo $this->Form->create('FileType', array('role' => 'form')); ?> 
				<fieldset>
					<div class="form-group">
						<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<div class="input select">
							<?php 
								$no_parent_option = (isset($root_node) && !empty($root_node)) ? false : true;
								echo $this->DreamcmsForm->treeSelect(array(
									'model' => 'FileType',
									'field' => 'parent_id',
									'class' => 'form-control',
									'tree' => $parentFileTypes,
									'no_parent_option' => $no_parent_option,
									'hidden' => $this->request->data['FileType']['id'],
									'current' => $this->request->data['FileType']['parent_id']
								)); 
							?>
						</div>
					</div><!-- .form-group -->

					<div class="form-group">
						<?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('description', array('type' => 'textarea', 'class' => 'form-control', 'rows' => '5')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('published', array('options' => array('Yes' => 'Yes', 'No' => 'No'), 'class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary')); ?>
				</fieldset>
			<?php echo $this->Form->end(); ?> 
		</div>
	</div>
</div>