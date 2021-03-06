

				<hr />
				<h3>Access Control List</h3>
<?php foreach ($granted_cms_menus as $menu) : ?>
<?php if (!isset($menu['ChildCmsMenu']) || empty($menu['ChildCmsMenu'])) : ?>
				<div class="row">
					<div class="col-xs-12">
						<div class="table-responsive">
							<table id="sample-table-1" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th><?php echo h(__('Module name')); ?></th>
										<th><?php echo h(__('Create')); ?></th>
										<th><?php echo h(__('Read')); ?></th>
										<th><?php echo h(__('Update')); ?></th>
										<th><?php echo h(__('Delete')); ?></th>
									</tr>
								</thead>

								<tbody>
									<tr>
										<td><?php echo h(__($menu['CmsMenu']['name'])); ?></td>
										<td><?php echo $this->Form->input('Acl.'. $menu['CmsMenu']['id'] .'.create', array('type' => 'checkbox', 'label' => false)); ?></td>
										<td><?php echo $this->Form->input('Acl.'. $menu['CmsMenu']['id'] .'.read', array('type' => 'checkbox', 'label' => false)); ?></td>
										<td><?php echo $this->Form->input('Acl.'. $menu['CmsMenu']['id'] .'.update', array('type' => 'checkbox', 'label' => false)); ?></td>
										<td><?php echo $this->Form->input('Acl.'. $menu['CmsMenu']['id'] .'.delete', array('type' => 'checkbox', 'label' => false)); ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
<?php else : ?>
				<div class="row">
					<div class="col-xs-12">
						<label>
							<?php echo $this->Form->input('Acl.'. $menu['CmsMenu']['id'] .'.read', array('type' => 'checkbox', 'label' => false, 'div' => false)); ?> 
							<span class="control-label bolder blue"><?php echo h(__($menu['CmsMenu']['name'])); ?></span>
						</label>
					</div>
				</div>
<?php endif; ?> 
<?php if (isset($menu['ChildCmsMenu']) && (count($menu['ChildCmsMenu']) > 0)) : ?>
				<div class="row">
					<div class="col-xs-12">
						<div class="table-responsive">
							<table id="sample-table-1" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th><?php echo h(__('Module name')); ?></th>
										<th><?php echo h(__('Create')); ?></th>
										<th><?php echo h(__('Read')); ?></th>
										<th><?php echo h(__('Update')); ?></th>
										<th><?php echo h(__('Delete')); ?></th>
									</tr>
								</thead>

								<tbody>
<?php foreach ($menu['ChildCmsMenu'] as $submenu) : ?>
									<tr>
										<td><?php echo h(__($submenu['name'])); ?></td>
										<td><?php echo $this->Form->input('Acl.'. $submenu['id'] .'.create', array('type' => 'checkbox', 'label' => false)); ?></td>
										<td><?php echo $this->Form->input('Acl.'. $submenu['id'] .'.read', array('type' => 'checkbox', 'label' => false)); ?></td>
										<td><?php echo $this->Form->input('Acl.'. $submenu['id'] .'.update', array('type' => 'checkbox', 'label' => false)); ?></td>
										<td><?php echo $this->Form->input('Acl.'. $submenu['id'] .'.delete', array('type' => 'checkbox', 'label' => false)); ?></td>
									</tr>
<?php endforeach; ?> 
								</tbody>
							</table>
						</div>
					</div>
				</div>
<?php endif; ?> 
				<hr /> 
<?php endforeach; ?> 

