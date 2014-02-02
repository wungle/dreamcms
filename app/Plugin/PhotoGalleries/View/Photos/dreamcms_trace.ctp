
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
							<div class="photos form">
								<?php echo $this->Form->create('PhotoBefore', array('role' => 'form', 'enctype' => 'multipart/form-data', 'url' => '#')); ?> 
									<fieldset>
										<div class="form-group">
											<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
										</div><!-- .form-group -->
										<div class="form-group">
											<div class="input select">
												<?php 
													$photo_album = '';
													if (isset($this->request->data['PhotoBefore']['photo_album_id']))
													{
														$photo_album .= $this->request->data['PhotoBefore']['photo_album_id'] . ' - ';
														$photo_album .= (isset($this->request->data['CmsLog']['data_before']['PhotoAlbum']['name']) && !empty($this->request->data['CmsLog']['data_before']['PhotoAlbum']['name'])) ? $this->request->data['CmsLog']['data_before']['PhotoAlbum']['name'] : 'No Album';
													}
													echo $this->Form->input('photo_album_id', array('type' => 'text', 'class' => 'form-control', 'value' => $photo_album));
												?>
											</div>
										</div><!-- .form-group -->

										<?php
											echo $this->element(
												'common/translated_items',
												array(
													'localeList' => $localeList,
													'modelName' => 'PhotoBefore',
													'elements' => array(
														'name' => array('class' => 'form-control'),
														'description' => array('type' => 'textarea', 'class' => 'form-control', 'rows' => 5),
													)
												)
											);
										?>

										<div class="form-group">
											<?php echo $this->Form->input('filename', array('class' => 'form-control')); ?>
										</div><!-- .form-group -->
<?php if (isset($this->request->data['PhotoBefore']['filename_uploadable_filesize'])) : ?>
										<div class="form-group">
											<?php echo $this->Form->input('filename_uploadable_filesize', array('class' => 'form-control', 'label' => 'File Size')); ?>
										</div><!-- .form-group -->
<?php endif; ?> 
<?php if (isset($this->request->data['PhotoBefore']['filename_uploadable_thumbnail'])) : ?>
										<div class="form-group">
											<?php echo $this->Form->label('Thumbnail'); ?> 
											<div><img src="data:image/jpeg;base64,<?php echo $this->request->data['PhotoBefore']['filename_uploadable_thumbnail']; ?>" alt="" /></div>
										</div><!-- .form-group -->
<?php endif; ?> 
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
							<div class="photos form">
								<?php echo $this->Form->create('PhotoAfter', array('role' => 'form', 'enctype' => 'multipart/form-data', 'url' => '#')); ?> 
									<fieldset>
										<div class="form-group">
											<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
										</div><!-- .form-group -->
										<div class="form-group">
											<div class="input select">
												<?php 
													$photo_album = '';
													if (isset($this->request->data['PhotoAfter']['photo_album_id']))
													{
														$photo_album .= $this->request->data['PhotoAfter']['photo_album_id'] . ' - ';
														$photo_album .= (isset($this->request->data['CmsLog']['data_after']['PhotoAlbum']['name']) && !empty($this->request->data['CmsLog']['data_after']['PhotoAlbum']['name'])) ? $this->request->data['CmsLog']['data_after']['PhotoAlbum']['name'] : 'No Album';
													}
													echo $this->Form->input('photo_album_id', array('type' => 'text', 'class' => 'form-control', 'value' => $photo_album));
												?>
											</div>
										</div><!-- .form-group -->

										<?php
											echo $this->element(
												'common/translated_items',
												array(
													'localeList' => $localeList,
													'modelName' => 'PhotoAfter',
													'elements' => array(
														'name' => array('class' => 'form-control'),
														'description' => array('type' => 'textarea', 'class' => 'form-control', 'rows' => 5),
													)
												)
											);
										?>

										<div class="form-group">
											<?php echo $this->Form->input('filename', array('class' => 'form-control')); ?>
										</div><!-- .form-group -->
<?php if (isset($this->request->data['PhotoAfter']['filename_uploadable_filesize'])) : ?>
										<div class="form-group">
											<?php echo $this->Form->input('filename_uploadable_filesize', array('class' => 'form-control', 'label' => 'File Size')); ?>
										</div><!-- .form-group -->
<?php endif; ?> 
<?php if (isset($this->request->data['PhotoAfter']['filename_uploadable_thumbnail'])) : ?>
										<div class="form-group">
											<?php echo $this->Form->label('Thumbnail'); ?> 
											<div><img src="data:image/jpeg;base64,<?php echo $this->request->data['PhotoAfter']['filename_uploadable_thumbnail']; ?>" alt="" /></div>
										</div><!-- .form-group -->
<?php endif; ?> 
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