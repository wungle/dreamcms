
<?php $this->startIfEmpty('breadcrumb'); ?>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="<?php echo $this->Html->url('/dreamcms'); ?>"><?php echo __('Home'); ?></a>
							</li>
							<li class="active"><?php echo __('Settings'); ?></li>
						</ul><!-- .breadcrumb -->
<?php $this->end(); ?>

<div class="row">
	<div class="col-sm-12">
		<h2><?php echo __('Setting\'s Record History') . ': #' . $data['CmsLog']['id']; ?></h2>

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
							<div class="settings form">
								<?php echo $this->Form->create('SettingBefore', array('role' => 'form', 'url' => '#')); ?> 
									<fieldset>
										<div class="form-group">
											<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
										</div><!-- .form-group -->
										<div class="form-group">
											<?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
										</div><!-- .form-group -->
										<div class="form-group">
											<?php echo $this->Form->input('value', array('type' => 'textarea', 'class' => 'form-control', 'rows' => 8)); ?>
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
							<div class="settings form">
								<?php echo $this->Form->create('SettingAfter', array('role' => 'form', 'url' => '#')); ?> 
									<fieldset>
										<div class="form-group">
											<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
										</div><!-- .form-group -->
										<div class="form-group">
											<?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
										</div><!-- .form-group -->
										<div class="form-group">
											<?php echo $this->Form->input('value', array('type' => 'textarea', 'class' => 'form-control', 'rows' => 8)); ?>
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