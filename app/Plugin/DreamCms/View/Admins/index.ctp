
<?php $this->startIfEmpty('breadcrumb'); ?>						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="#"><?php echo __('Home'); ?></a>
							</li>
							<li class="active"><?php echo __('Admins'); ?></li>
						</ul><!-- .breadcrumb -->
<?php $this->end(); ?>
						<div class="page-header">
							<h1>
								<?php echo __('Admins'); ?>							</h1>
						</div><!-- /.page-header -->

						<div>
							<div class="col-sm-6">
								<?php echo $this->element('common/data_finder'); ?> 
							</div>
							<div class="col-sm-6" align="right">
								<?php echo $this->Html->link($this->Html->tag('i', ' ' . __('New Admin'), array('class' => 'icon-plus bigger-120')), array('action' => 'add'), array('class' => 'btn btn-info dt-btns', 'escape' => false)); ?> &nbsp; 
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
														<th><?php echo $this->Paginator->sort('id'); ?></th> 
														<th><?php echo $this->Paginator->sort('group_id'); ?></th> 
														<th class="hidden-480"><?php echo $this->Paginator->sort('username'); ?></th> 
														<th class="hidden-480"><?php echo $this->Paginator->sort('password'); ?></th> 
														<th class="hidden-480"><?php echo $this->Paginator->sort('real_name'); ?></th> 
														<th class="hidden-480"><?php echo $this->Paginator->sort('email'); ?></th> 
														<th class="hidden-480"><?php echo $this->Paginator->sort('last_login'); ?></th> 
														<th class="hidden-480"><?php echo $this->Paginator->sort('last_login_ip'); ?></th> 
														<th class="hidden-480"><?php echo $this->Paginator->sort('active'); ?></th> 
														<th class="hidden-480"><?php echo $this->Paginator->sort('deleted'); ?></th> 
														<th class="hidden-480"><?php echo $this->Paginator->sort('created'); ?></th> 
														<th class="hidden-480"><?php echo $this->Paginator->sort('modified'); ?></th> 
 
														<th class="center">
															<?php echo __('Actions'); ?> 
														</th>
													</tr>
												</thead>

												<tbody>
<?php foreach ($admins as $admin): ?>
													<tr>
														<td><?php echo h($admin['Admin']['id']); ?>&nbsp;</td>
														<td>
															<?php echo $this->Html->link($admin['Group']['name'], array('controller' => 'groups', 'action' => 'view', $admin['Group']['id'])); ?>
														</td>
														<td class="hidden-480"><?php echo h($admin['Admin']['username']); ?>&nbsp;</td>
														<td class="hidden-480"><?php echo h($admin['Admin']['password']); ?>&nbsp;</td>
														<td class="hidden-480"><?php echo h($admin['Admin']['real_name']); ?>&nbsp;</td>
														<td class="hidden-480"><?php echo h($admin['Admin']['email']); ?>&nbsp;</td>
														<td class="hidden-480"><?php echo h($admin['Admin']['last_login']); ?>&nbsp;</td>
														<td class="hidden-480"><?php echo h($admin['Admin']['last_login_ip']); ?>&nbsp;</td>
														<td class="hidden-480"><?php echo h($admin['Admin']['active']); ?>&nbsp;</td>
														<td class="hidden-480"><?php echo h($admin['Admin']['deleted']); ?>&nbsp;</td>
														<td class="hidden-480"><?php echo h($admin['Admin']['created']); ?>&nbsp;</td>
														<td class="hidden-480"><?php echo h($admin['Admin']['modified']); ?>&nbsp;</td>
														<td class="center">
															<?php echo $this->Html->link($this->Html->tag('i', ' ' . __('View'), array('class' => 'icon-eye-open bigger-120')), array('action' => 'view', $admin['Admin']['id']), array('class' => 'btn btn-xs btn-warning dt-btns', 'escape' => false)); ?> &nbsp; 
															<?php echo $this->Html->link($this->Html->tag('i', ' ' . __('Edit'), array('class' => 'icon-edit bigger-120')), array('action' => 'edit', $admin['Admin']['id']), array('class' => 'btn btn-xs btn-info dt-btns', 'escape' => false)); ?> &nbsp; 
															<?php echo $this->Form->postLink($this->Html->tag('i', ' ' . __('Delete'), array('class' => 'icon-trash bigger-120')), array('action' => 'delete', $admin['Admin']['id']), array('class' => 'btn btn-xs btn-danger dt-btns', 'escape' => false), __('Are you sure you want to delete # %s?', $admin['Admin']['id'])); ?> &nbsp; 
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
