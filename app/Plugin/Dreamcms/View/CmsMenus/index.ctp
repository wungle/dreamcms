
<?php $this->startIfEmpty('breadcrumb'); ?>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="#"><?php echo __('Home'); ?></a>
							</li>
							<li class="active"><?php echo __('Cms Menus'); ?></li>
						</ul><!-- .breadcrumb -->
<?php $this->end(); ?>
						<div class="page-header">
							<h1>
								<?php echo __('Cms Menus'); ?>							</h1>
						</div><!-- /.page-header -->

						<div>
							<div class="col-sm-6">
								<?php echo $this->element('common/data_finder'); ?> 
							</div>
							<div class="col-sm-6" align="right">
								<?php echo $this->Html->link($this->Html->tag('i', ' ' . __('New Cms Menu'), array('class' => 'icon-plus bigger-120')), array('action' => 'add'), array('class' => 'btn btn-info dt-btns', 'escape' => false)); ?> &nbsp; 
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12">

								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr> 
														<th><?php echo $this->Paginator->sort('parent_id'); ?></th> 
														<th class="hidden-480"><?php echo $this->Paginator->sort('name'); ?></th> 
														<th class="hidden-480"><?php echo $this->Paginator->sort('url'); ?></th> 
														<th class="hidden-480"><?php echo $this->Paginator->sort('published'); ?></th> 
														<th class="hidden-480"><?php echo $this->Paginator->sort('created'); ?></th> 
														<th class="hidden-480"><?php echo $this->Paginator->sort('modified'); ?></th> 
 
														<th class="center">
															<?php echo __('Actions'); ?> 
														</th>
													</tr>
												</thead>

												<tbody>
<?php foreach ($cmsMenus as $cmsMenu): ?>
													<tr>
														<td>
															<?php echo $this->Html->link('<i class="'. $cmsMenu['ParentCmsMenu']['icon'] .'"></i>&nbsp; ' . $cmsMenu['ParentCmsMenu']['name'], array('controller' => 'cms_menus', 'action' => 'view', $cmsMenu['ParentCmsMenu']['id']), array('escape' => false)); ?>
														</td>
														<td class="hidden-480"><i class="<?php echo h($cmsMenu['CmsMenu']['icon']); ?>"></i>&nbsp; <?php echo h($cmsMenu['CmsMenu']['name']); ?>&nbsp;</td>
														<td class="hidden-480"><?php echo h($cmsMenu['CmsMenu']['url']); ?>&nbsp;</td>
														<td class="hidden-480"><?php echo h($cmsMenu['CmsMenu']['published']); ?>&nbsp;</td>
														<td class="hidden-480"><?php echo h($cmsMenu['CmsMenu']['created']); ?>&nbsp;</td>
														<td class="hidden-480"><?php echo h($cmsMenu['CmsMenu']['modified']); ?>&nbsp;</td>
														<td class="center">
															<?php echo $this->Html->link($this->Html->tag('i', ' ' . __('View'), array('class' => 'icon-eye-open bigger-120')), array('action' => 'view', $cmsMenu['CmsMenu']['id']), array('class' => 'btn btn-xs btn-warning dt-btns', 'escape' => false)); ?> &nbsp; 
															<?php echo $this->Html->link($this->Html->tag('i', ' ' . __('Edit'), array('class' => 'icon-edit bigger-120')), array('action' => 'edit', $cmsMenu['CmsMenu']['id']), array('class' => 'btn btn-xs btn-info dt-btns', 'escape' => false)); ?> &nbsp; 
															<?php echo $this->Form->postLink($this->Html->tag('i', ' ' . __('Delete'), array('class' => 'icon-trash bigger-120')), array('action' => 'delete', $cmsMenu['CmsMenu']['id']), array('class' => 'btn btn-xs btn-danger dt-btns', 'escape' => false), __('Are you sure you want to delete # %s?', $cmsMenu['CmsMenu']['id'])); ?> &nbsp; 
														</td>
													</tr>
<?php endforeach; ?>
 

												</tbody>
											</table>
										</div><!-- /.table-responsive -->
									</div><!-- /span -->
								</div><!-- /row -->
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<p><small>
									<?php
										echo $this->Paginator->counter(array(
										'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
										));
									?>
								</small></p>
							</div>
							<div class="col-sm-6">
								<div class="dataTables_paginate paging_bootstrap">
									<ul class="pagination">
										<?php
						echo $this->Paginator->prev('<i class="icon-double-angle-left"></i>', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a', 'escape' => false));
						echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'tag' => 'li', 'currentClass' => 'disabled'));
						echo $this->Paginator->next('<i class="icon-double-angle-right"></i>', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a', 'escape' => false));
					?>
									</ul>
								</div><!-- /.pagination -->
							</div>
						</div>
