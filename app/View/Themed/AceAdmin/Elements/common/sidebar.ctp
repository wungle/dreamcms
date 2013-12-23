

				<div class="sidebar" id="sidebar">
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>

					<!--div class="sidebar-shortcuts" id="sidebar-shortcuts">
						<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
							<button class="btn btn-success">
								<i class="icon-signal"></i>
							</button>

							<button class="btn btn-info">
								<i class="icon-pencil"></i>
							</button>

							<button class="btn btn-warning">
								<i class="icon-group"></i>
							</button>

							<button class="btn btn-danger">
								<i class="icon-cogs"></i>
							</button>
						</div>

						<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
							<span class="btn btn-success"></span>

							<span class="btn btn-info"></span>

							<span class="btn btn-warning"></span>

							<span class="btn btn-danger"></span>
						</div>
					</div><!-- #sidebar-shortcuts -->

					<ul class="nav nav-list">
						<li>
							<a href="<?php echo $this->Html->url('/dreamcms'); ?>">
								<i class="icon-dashboard"></i>
								<span class="menu-text"> Dashboard </span>
							</a>
						</li>

<?php foreach ($cms_menus as $menu) : ?>
<?php if ($this->CoreDreamCms->hasActiveChildMenu($menu['ChildCmsMenu'], $params_here)) : ?>
						<li class="active open">
<?php else : ?>
						<li>
<?php endif; ?>
							<a href="#" class="dropdown-toggle">
								<i class="<?php echo h($menu['CmsMenu']['icon']); ?>"></i>
								<span class="menu-text"> <?php echo h($menu['CmsMenu']['name']); ?> </span>

								<b class="arrow icon-angle-down"></b>
							</a>

<?php if (count($menu['ChildCmsMenu']) > 0) : ?>
							<ul class="submenu">
<?php foreach ($menu['ChildCmsMenu'] as $child) : ?>
<?php if (strpos($params_here, $child['url']) === 0) : ?>
								<li class="active">
<?php else : ?>
								<li>
<?php endif; ?>
									<a href="<?php echo $this->Html->url($child['url']); ?>">
										<i class="icon-double-angle-right"></i>
										<i class="<?php echo h($child['icon']); ?>"></i>&nbsp;
										<?php echo h($child['name']); ?>
									</a>
								</li>
<?php endforeach; ?>
							</ul>
<?php endif; ?>
						</li>
<?php endforeach; ?>

						<li>
							<a href="<?php echo $this->Html->url('/dreamcms/admins/logout'); ?>">
								<i class="icon-signout"></i>
								<span class="menu-text"> Logout </span>
							</a>
						</li>
					</ul><!-- /.nav-list -->

					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>

					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>

