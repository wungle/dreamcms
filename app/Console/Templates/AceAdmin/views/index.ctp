<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<?php echo "<?php \$this->startIfEmpty('breadcrumb'); ?>"; ?>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="#"><?php echo "<?php echo __('Home'); ?>"; ?></a>
							</li>
							<li class="active"><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></li>
						</ul><!-- .breadcrumb -->
<?php echo "<?php \$this->end(); ?>"; ?>

						<div class="page-header">
							<h1>
								<?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?>
							</h1>
						</div><!-- /.page-header -->

						<div>
							<div class="col-sm-6">
								<?php echo '<?php echo $this->element(\'common/data_finder\'); ?>'; ?> 
							</div>
							<div class="col-sm-6" align="right">
								<?php echo "<?php echo \$this->Html->link(\$this->Html->tag('i', ' ' . __('New ".$singularHumanName."'), array('class' => 'icon-plus bigger-120')), array('action' => 'add'), array('class' => 'btn btn-info dt-btns', 'escape' => false)); ?> &nbsp; \n"; ?>
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
<?php $x = 0; ?>
<?php foreach ($fields as $field): ?>
<?php if ($x < 2) : ?>
														<th><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>"; ?></th> 
<?php else : ?>
														<th class="hidden-480"><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>"; ?></th> 
<?php endif; ?>
<?php $x++; ?>
<?php endforeach; ?> 
														<th class="center">
															<?php echo "<?php echo __('Actions'); ?>"; ?> 
														</th>
													</tr>
												</thead>

												<tbody>
<?php
	$line_begin = "\t\t\t\t\t\t\t\t\t\t\t\t\t";
	echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
		echo $line_begin . "<tr>\n";
			$x = 0;
			foreach ($fields as $field)
			{
				$td_class = ($x >= 2) ? ' class="hidden-480"' : '';
				$isKey = false;
				if (!empty($associations['belongsTo'])) {
					foreach ($associations['belongsTo'] as $alias => $details) {
						if ($field === $details['foreignKey']) {
							$isKey = true;
							echo $line_begin . "\t<td{$td_class}>\n{$line_begin}\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n{$line_begin}\t</td>\n";
							break;
						}
					}
				}
				if ($isKey !== true) {
					echo $line_begin . "\t<td{$td_class}><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
				}

				$x++;
			}

			echo $line_begin . "\t<td class=\"center\">\n";
			echo $line_begin . "\t\t<?php echo \$this->Html->link(\$this->Html->tag('i', ' ' . __('View'), array('class' => 'icon-eye-open bigger-120')), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-xs btn-warning dt-btns', 'escape' => false)); ?> &nbsp; \n";
			echo $line_begin . "\t\t<?php echo \$this->Html->link(\$this->Html->tag('i', ' ' . __('Edit'), array('class' => 'icon-edit bigger-120')), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-xs btn-info dt-btns', 'escape' => false)); ?> &nbsp; \n";
			echo $line_begin . "\t\t<?php echo \$this->Form->postLink(\$this->Html->tag('i', ' ' . __('Delete'), array('class' => 'icon-trash bigger-120')), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-xs btn-danger dt-btns', 'escape' => false), __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?> &nbsp; \n";
			echo $line_begin . "\t</td>\n";

		echo $line_begin . "</tr>\n";
	echo "<?php endforeach; ?>\n";
?> 

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
									<?php echo "<?php
										echo \$this->Paginator->counter(array(
										'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
										));
									?>\n"; ?>
								</small></p>
							</div>
							<div class="col-sm-6">
								<div class="dataTables_paginate paging_bootstrap">
									<ul class="pagination">
										<?php
											echo "<?php\n";
											echo "\t\t\t\t\t\techo \$this->Paginator->prev('<i class=\"icon-double-angle-left\"></i>', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a', 'escape' => false));\n";
											echo "\t\t\t\t\t\techo \$this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'tag' => 'li', 'currentClass' => 'disabled'));\n";
											echo "\t\t\t\t\t\techo \$this->Paginator->next('<i class=\"icon-double-angle-right\"></i>', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a', 'escape' => false));\n";
											echo "\t\t\t\t\t?>\n";
										?>
									</ul>
								</div><!-- /.pagination -->
							</div>
						</div>
