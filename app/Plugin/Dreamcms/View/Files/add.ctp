
<?php $this->startIfEmpty('breadcrumb'); ?>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="#"><?php echo __('Home'); ?></a>
							</li>
							<li class="active"><?php echo __('Files'); ?></li>
						</ul><!-- .breadcrumb -->
<?php $this->end(); ?>

<div class="row">
	<div class="col-sm-12">
		<h2><?php echo __('Add File'); ?></h2>
		<div class="files form">
			<?php echo $this->Form->create('File', array('role' => 'form', 'enctype' => 'multipart/form-data')); ?> 
				<fieldset>
					<div class="form-group">
						<div class="input select">
							<?php 
								echo $this->DreamcmsForm->treeSelect(array(
									'model' => 'File',
									'field' => 'file_type_id',
									'class' => 'form-control',
									'tree' => $fileTypes
								)); 
							?>
						</div>
					</div><!-- .form-group -->

					<?php
						echo $this->element(
							'common/translated_items',
							array(
								'localeList' => $localeList,
								'modelName' => 'File',
								'elements' => array(
									'name' => array('class' => 'form-control'),
									'description' => array('type' => 'textarea', 'class' => 'form-control', 'rows' => 5),
									'url' => array('class' => 'form-control'),
									'filename' => array('type' => 'file', 'class' => 'form-control ace-fileinput'),
								)
							)
						);
					?>

					<div class="form-group">
						<?php echo $this->Form->input('priority', array('class' => 'form-control')); ?>
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