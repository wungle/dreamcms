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
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link http://cakephp.org CakePHP(tm) Project
 * @package Cake.Console.Templates.default.views
 * @since CakePHP(tm) v 1.2.0.5234
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<div class="row">
	<div class="col-sm-12">
		<h2><?php echo "<?php  echo __('{$singularHumanName}'); ?>"; ?></h2>

<?php foreach ($fields as $field) : ?>
		<div class="form-group">
			<?php
				$isKey = false;
				if (!empty($associations['belongsTo'])) {
					foreach ($associations['belongsTo'] as $alias => $details) {
						if ($field === $details['foreignKey']) {
							$isKey = true;
							echo "\t\t<label><strong><?php echo __('" . Inflector::humanize(Inflector::underscore($alias)) . "'); ?></strong></label>\n";
							echo "\t\t<div class=\"preview-pane\">\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}']), array('class' => '')); ?>\n\t\t\t&nbsp;\n\t\t</div>\n";
							break;
						}
					}
				}
				if ($isKey !== true) {
					echo "\t\t<label><strong><?php echo __('" . Inflector::humanize($field) . "'); ?></strong></label>\n";
					echo "\t\t<div class=\"preview-pane\">\n\t\t\t<?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>\n\t\t\t&nbsp;\n\t\t</div>\n";
				}
			?> 
		</div> 
<?php endforeach; ?>

		<div class="form-group">
			<?php
				echo "\t\t<?php echo \$this->Html->link(\$this->Html->tag('i', ' ' . __('Edit'), array('class' => 'icon-edit bigger-120')), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-info dt-btns', 'escape' => false)); ?> &nbsp; \n";
				echo "\t\t<?php echo \$this->Form->postLink(\$this->Html->tag('i', ' ' . __('Delete'), array('class' => 'icon-trash bigger-120')), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-danger dt-btns', 'escape' => false), __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?> &nbsp; \n";
			?>
		</div>
	</div>
</div>