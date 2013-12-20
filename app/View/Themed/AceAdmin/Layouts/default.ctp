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
			<?php echo $cakeDescription ?> ::
			<?php echo $title_for_layout; ?> 
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
		<?php echo $this->Html->css('fullcalendar.css'); ?> 
		<?php echo $this->Html->css('dropzone.css'); ?> 
		<?php echo $this->Html->css('jquery-ui-1.10.3.custom.min.css'); ?> 
		<?php echo $this->Html->css('jquery-ui-1.10.3.full.min.css'); ?> 
		<?php echo $this->Html->css('jquery.gritter.css'); ?> 
		<?php echo $this->Html->css('chosen.css'); ?> 
		<?php echo $this->Html->css('datepicker.css'); ?> 
		<?php echo $this->Html->css('bootstrap-timepicker.css'); ?> 
		<?php echo $this->Html->css('daterangepicker.css'); ?> 
		<?php echo $this->Html->css('colorpicker.css'); ?> 
		<?php echo $this->Html->css('select2.css'); ?> 
		<?php echo $this->Html->css('colorbox.css'); ?> 
		<?php echo $this->Html->css('ui.jqgrid.css'); ?> 
		<?php echo $this->Html->css('prettify.css'); ?> 


		<!-- fonts -->
		<?php echo $this->Html->css('ace-fonts.css'); ?> 


		<!-- ace styles -->
		<?php echo $this->Html->css('ace.min.css'); ?> 
		<?php echo $this->Html->css('ace-rtl.min.css'); ?> 
		<?php echo $this->Html->css('ace-skins.min.css'); ?> 
		<!--[if lte IE 8]>
			<?php echo $this->Html->css('ace-ie.min.css'); ?> 
		<![endif]-->


		<!-- ace settings handler -->
		<?php echo $this->Html->script('ace-extra.min'); ?> 

		<!-- additional css -->
		<?php echo $this->Html->css('data_finder.css'); ?> 
		<?php echo $this->Html->css('additional.css'); ?> 


		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<?php echo $this->Html->script('html5shiv'); ?> 
			<?php echo $this->Html->script('respond.min'); ?> 
		<![endif]-->
	</head>

	<body>
<?php echo $this->element('common/header'); ?> 

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>

<?php echo $this->element('common/sidebar'); ?> 

				<div class="main-content">

<?php echo $this->element('common/breadcrumbs'); ?>

					<div class="page-content">
						<!-- PAGE CONTENT BEGINS -->


<?php echo $this->Session->flash(); ?>

<?php echo $content_for_layout; ?> 


						<!-- PAGE CONTENT ENDS -->
					</div><!-- /.page-content -->
				</div><!-- /.main-content -->

<?php //echo $this->element('common/ace_settings'); ?> 

			</div><!-- /.main-container-inner -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
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
		<?php echo $this->Html->script('typeahead-bs2.min'); ?> 


		<!-- plugin scripts -->
		<!--[if lte IE 8]>
			<?php echo $this->Html->script('excanvas.min'); ?> 
		<![endif]-->
		<?php echo $this->Html->script('jquery-ui-1.10.3.custom.min'); ?> 
		<?php echo $this->Html->script('jquery-ui-1.10.3.full.min'); ?> 
		<?php echo $this->Html->script('jquery.ui.touch-punch.min'); ?> 
		<?php echo $this->Html->script('fullcalendar.min'); ?> 
		<?php echo $this->Html->script('bootbox.min'); ?> 
		<?php echo $this->Html->script('dropzone.min'); ?> 
		<?php echo $this->Html->script('jquery.easy-pie-chart.min'); ?> 
		<?php echo $this->Html->script('jquery.gritter.min'); ?> 
		<?php echo $this->Html->script('spin.min'); ?> 
		<?php echo $this->Html->script('jquery.slimscroll.min'); ?> 
		<?php echo $this->Html->script('chosen.jquery.min'); ?> 
		<?php echo $this->Html->script('fuelux/fuelux.spinner.min'); ?> 
		<?php echo $this->Html->script('fuelux/fuelux.wizard.min'); ?> 
		<?php echo $this->Html->script('date-time/bootstrap-datepicker.min'); ?> 
		<?php echo $this->Html->script('date-time/bootstrap-timepicker.min'); ?> 
		<?php echo $this->Html->script('date-time/moment.min'); ?> 
		<?php echo $this->Html->script('date-time/daterangepicker.min'); ?> 
		<?php echo $this->Html->script('bootstrap-colorpicker.min'); ?> 
		<?php echo $this->Html->script('jquery.knob.min'); ?> 
		<?php echo $this->Html->script('jquery.autosize.min'); ?> 
		<?php echo $this->Html->script('jquery.inputlimiter.1.3.1.min'); ?> 
		<?php echo $this->Html->script('jquery.maskedinput.min'); ?> 
		<?php echo $this->Html->script('bootstrap-tag.min'); ?> 
		<?php echo $this->Html->script('jquery.validate.min'); ?> 
		<?php echo $this->Html->script('additional-methods.min'); ?> 
		<?php echo $this->Html->script('select2.min'); ?> 
		<?php echo $this->Html->script('jquery.colorbox-min'); ?> 
		<?php echo $this->Html->script('jquery.hotkeys.min'); ?> 
		<?php echo $this->Html->script('bootstrap-wysiwyg.min'); ?> 
		<?php echo $this->Html->script('jquery.sparkline.min'); ?> 
		<?php echo $this->Html->script('flot/jquery.flot.min'); ?> 
		<?php echo $this->Html->script('flot/jquery.flot.pie.min'); ?> 
		<?php echo $this->Html->script('flot/jquery.flot.resize.min'); ?> 
		<?php echo $this->Html->script('jqGrid/jquery.jqGrid.min'); ?> 
		<?php echo $this->Html->script('jqGrid/i18n/grid.locale-en'); ?> 
		<?php echo $this->Html->script('jquery.nestable.min'); ?> 
		<?php echo $this->Html->script('x-editable/bootstrap-editable.min'); ?> 
		<?php echo $this->Html->script('x-editable/ace-editable.min'); ?> 
		<?php echo $this->Html->script('jquery.dataTables.min'); ?> 
		<?php echo $this->Html->script('jquery.dataTables.bootstrap'); ?> 
		<?php echo $this->Html->script('fuelux/data/fuelux.tree-sampledata'); ?> 
		<?php echo $this->Html->script('fuelux/fuelux.tree.min'); ?> 
		<?php echo $this->Html->script('/js/vendors/prettify'); ?> 
		<?php echo $this->Html->script('markdown/markdown.min'); ?> 
		<?php echo $this->Html->script('markdown/bootstrap-markdown.min'); ?> 


		<!-- ace scripts -->
		<?php echo $this->Html->script('ace-elements.min'); ?> 
		<?php echo $this->Html->script('ace.min'); ?> 

		<?php echo $this->Html->script('data_finder'); ?> 
		<?php echo $this->Html->script('dreamcms'); ?> 


		<!-- inline scripts related to this page -->
		<?php echo $this->fetch('datafinder_init'); ?>

	</body>
</html>