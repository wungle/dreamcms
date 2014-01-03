
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
			<?php echo h($photo['Photo']['id']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Photo Album'); ?></strong></label>
		<div class="preview-pane">
			<?php echo $this->Html->link($photo['PhotoAlbum']['name'], array('controller' => 'photo_albums', 'action' => 'view', $photo['PhotoAlbum']['id']), array('class' => '')); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Name'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($photo['Photo']['name']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Description'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($photo['Photo']['description']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Filename'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($photo['Photo']['filename']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Extension'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($photo['Photo']['extension']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Size'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($photo['Photo']['size']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Width'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($photo['Photo']['width']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Height'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($photo['Photo']['height']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Mime Type'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($photo['Photo']['mime_type']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Published'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($photo['Photo']['published']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Created'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($photo['Photo']['created']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Modified'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($photo['Photo']['modified']); ?>
			&nbsp;
		</div>
 
		</div> 

		<div class="form-group">
					<?php if (isset($current_acl['update']) && $current_acl['update']) echo $this->Html->link($this->Html->tag('i', ' ' . __('Edit'), array('class' => 'icon-edit bigger-120')), array('action' => 'edit', $photo['Photo']['id']), array('class' => 'btn btn-info dt-btns', 'escape' => false)); ?> &nbsp; 
		<?php if (isset($current_acl['delete']) && $current_acl['delete']) echo $this->Form->postLink($this->Html->tag('i', ' ' . __('Delete'), array('class' => 'icon-trash bigger-120')), array('action' => 'delete', $photo['Photo']['id']), array('class' => 'btn btn-danger dt-btns', 'escape' => false), __('Are you sure you want to delete # %s?', $photo['Photo']['id'])); ?> &nbsp; 
		</div>
	</div>
</div>