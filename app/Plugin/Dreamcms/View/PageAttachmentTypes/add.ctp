
<?php $this->startIfEmpty('breadcrumb'); ?> 
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="<?php echo $this->Html->url('/dreamcms'); ?>"><?php echo __('Home'); ?></a>
							</li>
							<li class="active"><?php echo __('Page Attachment Types'); ?></li>
						</ul><!-- .breadcrumb -->
<?php $this->end(); ?> 

<div class="row">
	<div class="col-sm-12">
		<h2><?php echo __('Add Page Attachment Type'); ?></h2>
		<div class="pageAttachmentTypes form">
			<?php echo $this->Form->create('PageAttachmentType', array('role' => 'form')); ?> 
				<fieldset>
					<div class="form-group">
						<div class="input select">
							<?php 
								$no_parent_option = (isset($this->params->params['root_node']) && !empty($this->params->params['root_node'])) ? false : true;
								echo $this->DreamcmsForm->treeSelect(array(
									'model' => 'PageAttachmentType',
									'field' => 'parent_id',
									'class' => 'form-control',
									'tree' => $parentPageAttachmentTypes,
									'no_parent_option' => $no_parent_option
								)); 
							?>
						</div>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('description', array('type' => 'textarea', 'class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary')); ?>
				</fieldset>
			<?php echo $this->Form->end(); ?> 
		</div>
	</div>
</div>