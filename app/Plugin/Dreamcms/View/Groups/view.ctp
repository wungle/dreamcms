
<?php $this->startIfEmpty('breadcrumb'); ?>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="#"><?php echo __('Home'); ?></a>
							</li>
							<li class="active"><?php echo __('Groups'); ?></li>
						</ul><!-- .breadcrumb -->
<?php $this->end(); ?>

<div class="row">
	<div class="col-sm-12">
		<h2><?php  echo __('Group'); ?></h2>

		<div class="form-group">
					<label><strong><?php echo __('Id'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($group['Group']['id']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Name'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($group['Group']['name']); ?>
			&nbsp;
		</div>
 
		</div> 		 
		<div class="form-group">
					<label><strong><?php echo __('Created'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($group['Group']['created']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Modified'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($group['Group']['modified']); ?>
			&nbsp;
		</div>
 
		</div> 

		<div class="form-group">
					<?php echo $this->Html->link($this->Html->tag('i', ' ' . __('Edit'), array('class' => 'icon-edit bigger-120')), array('action' => 'edit', $group['Group']['id']), array('class' => 'btn btn-info dt-btns', 'escape' => false)); ?> &nbsp; 
		<?php echo $this->Form->postLink($this->Html->tag('i', ' ' . __('Delete'), array('class' => 'icon-trash bigger-120')), array('action' => 'delete', $group['Group']['id']), array('class' => 'btn btn-danger dt-btns', 'escape' => false), __('Are you sure you want to delete # %s?', $group['Group']['id'])); ?> &nbsp; 
		</div>
	</div>
</div>