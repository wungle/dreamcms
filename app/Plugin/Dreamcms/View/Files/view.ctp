
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
		<h2><?php  echo __('File'); ?></h2>

		<div class="form-group">
					<label><strong><?php echo __('Id'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['File']['id']); ?>
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
			<?php echo h($file['File']['name']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Description'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['File']['description']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Url'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['File']['url']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Priority'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['File']['priority']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Filename'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['File']['filename']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Extension'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['File']['extension']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Size'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['File']['size']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Mime Type'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['File']['mime_type']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Category'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['File']['category']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Width'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['File']['width']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Height'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['File']['height']); ?>
			&nbsp;
		</div>
 
		</div> 

		<div class="form-group">
					<label><strong><?php echo __('Published'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['File']['published']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Created'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['File']['created']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Modified'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($file['File']['modified']); ?>
			&nbsp;
		</div>
 
		</div> 

		<div class="form-group">
					<?php if (isset($current_acl['update']) && $current_acl['update']) echo $this->Html->link($this->Html->tag('i', ' ' . __('Edit'), array('class' => 'icon-edit bigger-120')), array('action' => 'edit', $file['File']['id']), array('class' => 'btn btn-info dt-btns', 'escape' => false)); ?> &nbsp; 
		<?php if (isset($current_acl['delete']) && $current_acl['delete']) echo $this->Form->postLink($this->Html->tag('i', ' ' . __('Delete'), array('class' => 'icon-trash bigger-120')), array('action' => 'delete', $file['File']['id']), array('class' => 'btn btn-danger dt-btns', 'escape' => false), __('Are you sure you want to delete # %s?', $file['File']['id'])); ?> &nbsp; 
		</div>
	</div>
</div>