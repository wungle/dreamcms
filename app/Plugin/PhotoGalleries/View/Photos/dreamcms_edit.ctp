
<?php $this->startIfEmpty('breadcrumb'); ?> 
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="#"><?php echo __('Home'); ?></a>
							</li>
							<li class="active"><?php echo __($this->Routeable->humanizeController()); ?></li>
						</ul><!-- .breadcrumb -->
<?php $this->end(); ?> 

<div class="row">
	<div class="col-sm-12">
		<h2><?php echo __('Edit ' . $this->Routeable->singularizeController()); ?></h2>
		<div class="photos form">
			<?php echo $this->Form->create('Photo', array('role' => 'form', 'enctype' => 'multipart/form-data')); ?> 
				<fieldset>
					<div class="form-group">
						<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<div class="input select">
							<?php 
								echo $this->DreamcmsForm->treeSelect(array(
									'model' => 'Photo',
									'field' => 'photo_album_id',
									'class' => 'form-control',
									'tree' => $photoAlbums,
									'current' => $this->request->data['Photo']['photo_album_id']
								)); 
							?>
						</div>
					</div><!-- .form-group -->

					<?php
						echo $this->element(
							'common/translated_items',
							array(
								'localeList' => $localeList,
								'modelName' => 'Photo',
								'elements' => array(
									'name' => array('class' => 'form-control'),
									'description' => array('type' => 'textarea', 'class' => 'form-control', 'rows' => 5),
								)
							)
						);
					?>

					<div class="form-group">
						<?php echo $this->Form->input('filename', array('type' => 'file', 'class' => 'form-control ace-fileinput')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('published', array('class' => 'form-control', 'options' => array('Yes' => 'Yes', 'No' => 'No'))); ?>
					</div><!-- .form-group -->

					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary')); ?>
				</fieldset>
			<?php echo $this->Form->end(); ?> 
		</div>
	</div>
</div>