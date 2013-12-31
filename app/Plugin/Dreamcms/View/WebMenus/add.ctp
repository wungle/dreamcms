
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
		<h2><?php echo __('Add ' . $this->Routeable->singularizeController()); ?></h2>
		<div class="webMenus form">
			<?php echo $this->Form->create('WebMenu', array('role' => 'form')); ?> 
				<fieldset>
					<div class="form-group">
						<div class="input select">
							<?php 
								$no_parent_option = (isset($this->params->params['root_node']) && !empty($this->params->params['root_node'])) ? false : true;
								echo $this->DreamcmsForm->treeSelect(array(
									'model' => 'WebMenu',
									'field' => 'parent_id',
									'class' => 'form-control',
									'tree' => $parentWebMenus,
									'no_parent_option' => $no_parent_option
								)); 
							?>
						</div>
					</div><!-- .form-group -->

					<?php
						echo $this->element(
							'common/translated_items',
							array(
								'localeList' => $localeList,
								'modelName' => 'WebMenu',
								'elements' => array(
									'name' => array('class' => 'form-control'),
									'url' => array('class' => 'form-control'),
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