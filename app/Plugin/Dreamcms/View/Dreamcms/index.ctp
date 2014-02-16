
<?php $this->startIfEmpty('breadcrumb'); ?>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="<?php echo $this->Html->url('/dreamcms'); ?>"><?php echo __('Home'); ?></a>
							</li>
						</ul><!-- .breadcrumb -->
<?php $this->end(); ?>

						<div class="page-header">
							<h1>
								<?php echo __('Dashboard'); ?> 
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">


								<div class="row">
									<div class="widget-box ">
										<div class="widget-header">
											<h4 class="lighter smaller">
												<i class="icon-time blue"></i>
												Recent Admin Activities
											</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main no-padding">
												<div class="dialogs" id="recordHistoryContent">
													<!--div class="itemdiv dialogdiv">
														<div class="user">
															<img alt="Bob's Avatar" src="<?php echo $this->Html->url('/avatars/user.jpg'); ?>" />
														</div>

														<div class="body">
															<div class="time">
																<i class="icon-time"></i>
																<span class="orange">2 min</span>
															</div>

															<div class="name">
																<a href="#">Administrator</a>
																&nbsp;
																<span class="label label-info arrowed arrowed-in-right">admin</span>
															</div>
															<div class="text"><p><b>Create</b></p></div>
															<div class="text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis.</p></div>

															<div class="text"><p><b>Affected fields:</b> <br />name, created, modified</p></div>

															<div class="tools">
																<a href="#" class="btn btn-minier btn-info">
																	<i class="icon-only icon-eye-open"></i>
																</a>
															</div>
														</div>
													</div-->
												</div>

												<form>
													<div class="form-actions">
														<div class="input-group">
															<a id="recordHistoryLoadMore" href="javascript:void(0);" onclick="javascript:DreamCMS.loadTraceLog();">More</a>
														</div>
													</div>
												</form>
											</div><!-- /widget-main -->
										</div><!-- /widget-body -->
									</div><!-- /widget-box -->
								</div>


							</div>
						</div>

<?php $this->startIfEmpty('record_history_init'); ?>
<script type="text/javascript">
	$(document).ready(function(){
		DreamCMS.loadTraceLog('<?php echo $this->Html->url('/dreamcms/admin_activities/'); ?>');
	});
</script>
<?php $this->end(); ?>