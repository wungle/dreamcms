
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
		<h2><?php echo __($this->Routeable->singularizeController() . '\'s Record History') . ': #' . $data['CmsLog']['id']; ?></h2>

		<div class="cms_logs form">
			<?php echo $this->Form->create('CmsLog', array('role' => 'form', 'url' => '#')); ?> 
				<fieldset>
					<div class="form-group">
						<?php echo $this->Form->input('Admin.real_name', array('class' => 'form-control', 'label' => 'Responsible Person')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('Admin.username', array('class' => 'form-control', 'label' => 'Responsible Username')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('operation', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('fields', array('class' => 'form-control', 'label' => 'Affected Fields')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('created', array('class' => 'form-control', 'type' => 'text', 'label' => 'Record Time')); ?>
					</div><!-- .form-group -->
				</fieldset>
			<?php echo $this->Form->end(); ?> 
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="tabbable">
					<ul class="nav nav-tabs" id="myTab">
						<li class="active">
							<a data-toggle="tab" href="#data-before">
								Data Before 
							</a>
						</li>
						<li>
							<a data-toggle="tab" href="#data-after">
								Data After 
							</a>
						</li>
					</ul>

					<div class="tab-content">
						<!-- Data Before Begin -->
						<div id="data-before" class="tab-pane in active">
							<div class="fileTypes form">
								<?php echo $this->Form->create('FileTypeBefore', array('role' => 'form', 'url' => '#')); ?> 
									<fieldset>
										<div class="form-group">
											<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
										</div><!-- .form-group -->
										<div class="form-group">
											<div class="input select">
												<?php 
													$parent = '';
													if (isset($this->request->data['FileTypeBefore']['parent_id']))
													{
														$parent .= $this->request->data['FileTypeBefore']['parent_id'] . ' - ';
														$parent .= (isset($this->request->data['CmsLog']['data_before']['ParentFileType']['name']) && !empty($this->request->data['CmsLog']['data_before']['ParentFileType']['name'])) ? $this->request->data['CmsLog']['data_before']['ParentFileType']['name'] : 'No Parent';
													}
													echo $this->Form->input('parent_id', array('type' => 'text', 'class' => 'form-control', 'value' => $parent));
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
											<?php echo $this->Form->input('published', array('class' => 'form-control')); ?>
										</div><!-- .form-group -->
										<div class="form-group">
											<?php echo $this->Form->input('created', array('class' => 'form-control')); ?>
										</div><!-- .form-group -->
										<div class="form-group">
											<?php echo $this->Form->input('modified', array('class' => 'form-control')); ?>
										</div><!-- .form-group -->
									</fieldset>
								<?php echo $this->Form->end(); ?> 
							</div>
						</div>

						<!-- Data After Begin -->
						<div id="data-after" class="tab-pane">
							<div class="fileTypes form">
								<?php echo $this->Form->create('FileTypeAfter', array('role' => 'form', 'url' => '#')); ?> 
									<fieldset>
										<div class="form-group">
											<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
										</div><!-- .form-group -->
										<div class="form-group">
											<div class="input select">
												<?php 
													$parent = '';
													if (isset($this->request->data['FileTypeAfter']['parent_id']))
													{
														$parent .= $this->request->data['FileTypeAfter']['parent_id'] . ' - ';
														$parent .= (isset($this->request->data['CmsLog']['data_after']['ParentFileType']['name']) && !empty($this->request->data['CmsLog']['data_after']['ParentFileType']['name'])) ? $this->request->data['CmsLog']['data_after']['ParentFileType']['name'] : 'No Parent';
													}
													echo $this->Form->input('parent_id', array('type' => 'text', 'class' => 'form-control', 'value' => $parent));
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
											<?php echo $this->Form->input('published', array('class' => 'form-control')); ?>
										</div><!-- .form-group -->
										<div class="form-group">
											<?php echo $this->Form->input('created', array('class' => 'form-control')); ?>
										</div><!-- .form-group -->
										<div class="form-group">
											<?php echo $this->Form->input('modified', array('class' => 'form-control')); ?>
										</div><!-- .form-group -->
									</fieldset>
								<?php echo $this->Form->end(); ?> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>