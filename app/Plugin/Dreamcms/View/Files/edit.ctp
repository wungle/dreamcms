
<?php $this->startIfEmpty('breadcrumb'); ?>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="<?php echo $this->Html->url('/dreamcms'); ?>"><?php echo __('Home'); ?></a>
							</li>
							<li class="active"><?php echo __($this->Routeable->humanizeController()); ?></li>
						</ul><!-- .breadcrumb -->
<?php $this->end(); ?>

<div class="row">
	<div class="col-sm-12">
		<h2><?php echo __('Edit ' . $this->Routeable->singularizeController()); ?></h2>
		<div class="files form">
			<?php echo $this->Form->create('Files', array('role' => 'form', 'enctype' => 'multipart/form-data')); ?> 
				<fieldset>
					<div class="form-group">
						<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<div class="input select">
							<?php 
								echo $this->DreamcmsForm->treeSelect(array(
									'model' => 'Files',
									'field' => 'file_type_id',
									'class' => 'form-control',
									'tree' => $fileTypes,
									'current' => $this->request->data['Files']['file_type_id']
								)); 
							?>
						</div>
					</div><!-- .form-group -->

					<?php
						echo $this->element(
							'common/translated_items',
							array(
								'localeList' => $localeList,
								'modelName' => 'Files',
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


		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<?php echo $this->element('common/record_history', array('record_id' => $this->request->data['Files']['id'])); ?> 


	</div>
</div>