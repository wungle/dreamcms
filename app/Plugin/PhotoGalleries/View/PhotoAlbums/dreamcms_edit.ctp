
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
		<div class="photoAlbums form">
			<?php echo $this->Form->create('PhotoAlbum', array('role' => 'form')); ?> 
				<fieldset>
					<div class="form-group">
						<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<div class="input select">
							<?php 
								$no_parent_option = (isset($this->params->params['root_node']) && !empty($this->params->params['root_node'])) ? false : true;
								echo $this->DreamcmsForm->treeSelect(array(
									'model' => 'PhotoAlbum',
									'field' => 'parent_id',
									'class' => 'form-control',
									'tree' => $parentPhotoAlbums,
									'no_parent_option' => $no_parent_option,
									'hidden' => $this->request->data['PhotoAlbum']['id'],
									'current' => $this->request->data['PhotoAlbum']['parent_id']
								)); 
							?>
						</div>
					</div><!-- .form-group -->
					
					<?php
						echo $this->element(
							'common/translated_items',
							array(
								'localeList' => $localeList,
								'modelName' => 'PhotoAlbum',
								'elements' => array(
									'name' => array('class' => 'form-control'),
									'description' => array('type' => 'textarea', 'class' => 'form-control', 'rows' => 5),
								)
							)
						);
					?>

					<div class="form-group">
						<?php echo $this->Form->input('published', array('class' => 'form-control', 'options' => array('Yes' => 'Yes', 'No' => 'No'))); ?>
					</div><!-- .form-group -->

					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary')); ?>
				</fieldset>
			<?php echo $this->Form->end(); ?> 
		</div>


		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<?php echo $this->element('common/record_history', array('record_id' => $this->request->data['PhotoAlbum']['id'])); ?> 


	</div>
</div>