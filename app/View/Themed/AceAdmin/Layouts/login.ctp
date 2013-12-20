<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

function fixInlineScriptLoading($str, $use_single_quote = true)
{
	$quote = ($use_single_quote) ? "'" : '"';
	$replacement = $quote . "+" . $quote . "<" . $quote . "+" . $quote . "/script>";

	return str_replace("</script>", $replacement, $str);
}

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>
			DreamCMS ::
			<?php echo Configure::read('DreamCMS.web_name'); ?> 
		</title>

		<meta name="description" content="<?php echo $cakeDescription ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->
		<?php echo $this->Html->css('bootstrap.min.css'); ?> 
		<?php echo $this->Html->css('font-awesome.min.css'); ?> 
		<!--[if IE 7]>
			<?php echo $this->Html->css('font-awesome-ie7.min.css'); ?> 
		<![endif]-->


		<!-- plugin styles -->
		<?php echo $this->Html->css('prettify.css'); ?> 


		<!-- fonts -->
		<?php echo $this->Html->css('ace-fonts.css'); ?> 


		<!-- ace styles -->
		<?php echo $this->Html->css('ace.min.css'); ?> 
		<?php echo $this->Html->css('ace-rtl.min.css'); ?> 
		<!--[if lte IE 8]>
			<?php echo $this->Html->css('ace-ie.min.css'); ?> 
		<![endif]-->


		<!-- additional css -->
		<?php echo $this->Html->css('additional.css'); ?> 


		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<?php echo $this->Html->script('html5shiv'); ?> 
			<?php echo $this->Html->script('respond.min'); ?> 
		<![endif]-->
	</head>

	<body class="login-layout">


		<div class="main-container">
			<div class="main-content">

<?php echo $this->Session->flash(); ?>

<?php echo $content_for_layout; ?>

			</div>
		</div><!-- /.main-container -->


		<!-- basic scripts -->
		<!--[if !IE]> -->
			<script type="text/javascript">
				document.write('<?php echo fixInlineScriptLoading($this->Html->script('jquery-2.0.3.min')); ?>');
			</script>
		<!-- <![endif]-->
		<!--[if IE]>
			<script type="text/javascript">
				document.write('<?php echo fixInlineScriptLoading($this->Html->script('jquery-1.10.2.min')); ?>');
			</script>
		<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write('<?php echo fixInlineScriptLoading($this->Html->script('jquery.mobile.custom.min')); ?>');
		</script>
		<?php echo $this->Html->script('bootstrap.min'); ?>  


		<!-- plugin scripts -->


		<!-- ace scripts -->


		<!-- inline scripts related to this page -->

	</body>
</html>