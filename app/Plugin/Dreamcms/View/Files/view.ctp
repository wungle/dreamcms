
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
		<h2><?php  echo __($this->Routeable->singularizeController()); ?></h2>

		<div class="form-group">
					<label><strong><?php echo __('Id'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['Files']['id']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('File Type'); ?></strong></label>
		<div class="preview-pane">
			<?php echo $this->Html->link($file['FileType']['name'], array('controller' => 'file_types', 'action' => 'view', $file['FileType']['id']), array('class' => '')); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Name'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['Files']['name']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Description'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['Files']['description']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Url'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['Files']['url']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Priority'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['Files']['priority']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Filename'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['Files']['filename']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Extension'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['Files']['extension']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Size'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['Files']['size']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Mime Type'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['Files']['mime_type']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Category'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['Files']['category']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Width'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['Files']['width']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Height'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['Files']['height']); ?>
			&nbsp;
		</div>
 
		</div> 

		<div class="form-group">
					<label><strong><?php echo __('Published'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['Files']['published']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Created'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['Files']['created']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Modified'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['Files']['modified']); ?>
			&nbsp;
		</div>
 
		</div> 

		<div class="form-group">
					<?php if (isset($current_acl['update']) && $current_acl['update']) echo $this->Html->link($this->Html->tag('i', ' ' . __('Edit'), array('class' => 'icon-edit bigger-120')), array('action' => 'edit', $file['Files']['id']), array('class' => 'btn btn-info dt-btns', 'escape' => false)); ?> &nbsp; 
		<?php if (isset($current_acl['delete']) && $current_acl['delete']) echo $this->Form->postLink($this->Html->tag('i', ' ' . __('Delete'), array('class' => 'icon-trash bigger-120')), array('action' => 'delete', $file['Files']['id']), array('class' => 'btn btn-danger dt-btns', 'escape' => false), __('Are you sure you want to delete # %s?', $file['Files']['id'])); ?> &nbsp; 
		</div>
	</div>
</div>