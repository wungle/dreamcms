
<?php $this->startIfEmpty('breadcrumb'); ?>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="#"><?php echo __('Home'); ?></a>
							</li>
							<li class="active"><?php echo __('Cms Menus'); ?></li>
						</ul><!-- .breadcrumb -->
<?php $this->end(); ?>

<div class="row">
	<div class="col-sm-12">
		<h2><?php  echo __('Cms Menu'); ?></h2>

		<div class="form-group">
					<label><strong><?php echo __('Id'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($cmsMenu['CmsMenu']['id']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Parent Cms Menu'); ?></strong></label>
		<div class="preview-pane">
			<?php echo $this->Html->link($cmsMenu['ParentCmsMenu']['name'], array('controller' => 'cms_menus', 'action' => 'view', $cmsMenu['ParentCmsMenu']['id']), array('class' => '')); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Icon'); ?></strong></label>
		<div class="preview-pane">
			<i class="<?php echo h($cmsMenu['CmsMenu']['icon']); ?>"></i>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Name'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($cmsMenu['CmsMenu']['name']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Url'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($cmsMenu['CmsMenu']['url']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Published'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($cmsMenu['CmsMenu']['published']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Created'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($cmsMenu['CmsMenu']['created']); ?>
			&nbsp;
		</div>
 
		</div> 
		<div class="form-group">
					<label><strong><?php echo __('Modified'); ?></strong></label>
		<div class="preview-pane">
			<?php echo h($cmsMenu['CmsMenu']['modified']); ?>
			&nbsp;
		</div>
 
		</div> 

		<div class="form-group">
					<?php echo $this->Html->link($this->Html->tag('i', ' ' . __('Edit'), array('class' => 'icon-edit bigger-120')), array('action' => 'edit', $cmsMenu['CmsMenu']['id']), array('class' => 'btn btn-info dt-btns', 'escape' => false)); ?> &nbsp; 
		<?php echo $this->Form->postLink($this->Html->tag('i', ' ' . __('Delete'), array('class' => 'icon-trash bigger-120')), array('action' => 'delete', $cmsMenu['CmsMenu']['id']), array('class' => 'btn btn-danger dt-btns', 'escape' => false), __('Are you sure you want to delete # %s?', $cmsMenu['CmsMenu']['id'])); ?> &nbsp; 
		</div>
	</div>
</div>