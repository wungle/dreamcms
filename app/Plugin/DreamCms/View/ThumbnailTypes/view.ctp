
<div class="row">
	<div class="col-sm-12">
		<h2><?php  echo __('Thumbnail Type'); ?></h2>

		<div class="form-group">
					<label><strong><?php echo __('Id'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($thumbnailType['ThumbnailType']['id']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Name'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($thumbnailType['ThumbnailType']['name']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Width'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($thumbnailType['ThumbnailType']['width']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Height'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($thumbnailType['ThumbnailType']['height']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Method'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($thumbnailType['ThumbnailType']['method']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Deleted'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($thumbnailType['ThumbnailType']['deleted']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Created'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($thumbnailType['ThumbnailType']['created']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Modified'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($thumbnailType['ThumbnailType']['modified']); ?>
			&nbsp;
		</div>
 
		</div> 

		<div class="form-group">
					<?php echo $this->Html->link($this->Html->tag('i', ' ' . __('Edit'), array('class' => 'icon-edit bigger-120')), array('action' => 'edit', $thumbnailType['ThumbnailType']['id']), array('class' => 'btn btn-info dt-btns', 'escape' => false)); ?> &nbsp; 
		<?php echo $this->Form->postLink($this->Html->tag('i', ' ' . __('Delete'), array('class' => 'icon-trash bigger-120')), array('action' => 'delete', $thumbnailType['ThumbnailType']['id']), array('class' => 'btn btn-danger dt-btns', 'escape' => false), __('Are you sure you want to delete # %s?', $thumbnailType['ThumbnailType']['id'])); ?> &nbsp; 
		</div>
	</div>
</div>