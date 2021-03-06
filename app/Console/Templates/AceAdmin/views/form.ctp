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

<?php echo "<?php \$this->startIfEmpty('breadcrumb'); ?>"; ?> 
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="#"><?php echo "<?php echo __('Home'); ?>"; ?></a>
							</li>
							<li class="active"><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></li>
						</ul><!-- .breadcrumb -->
<?php echo "<?php \$this->end(); ?>"; ?> 

<div class="row">
	<div class="col-sm-12">
		<h2><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></h2>
		<div class="<?php echo $pluralVar; ?> form">
			<?php echo "<?php echo \$this->Form->create('{$modelClass}', array('role' => 'form')); ?> \n"; ?>
				<fieldset>
<?php
	foreach ($fields as $field) {
		if (strpos($action, 'add') !== false && $field == $primaryKey) {
			continue;
		} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
			echo "\t\t\t\t\t<div class=\"form-group\">\n";
			echo "\t\t\t\t\t\t<?php echo \$this->Form->input('{$field}', array('class' => 'form-control')); ?>\n";
			echo "\t\t\t\t\t</div><!-- .form-group -->\n";
		}
	}
	if (!empty($associations['hasAndBelongsToMany'])) {
		foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
			echo "\t\t\t\t\t<div class=\"form-group\">\n";
			echo "\t\t\t\t\t\t\t<?php echo \$this->Form->input('{$assocName}');?>\n";
			echo "\t\t\t\t\t</div><!-- .form-group -->\n";
		}
	}
	echo "\n";
	echo "\t\t\t\t\t<?php echo \$this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary')); ?>\n";
?>
				</fieldset>
			<?php echo "<?php echo \$this->Form->end(); ?> \n";?>
		</div>
	</div>
</div>