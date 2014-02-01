<?php
App::uses("StringUtility", 'Dreamcms.Lib');

$controller_url = StringUtility::getControllerUrl(
	Configure::read('App.params_here'), 
	Configure::read('DreamCMS.Routeable.current_controller')
);

$ajax_url = $controller_url . '/load_trace_logs/' . $record_id . '/';
?>


		<div class="row">
			<div class="widget-box ">
				<div class="widget-header">
					<h4 class="lighter smaller">
						<i class="icon-time blue"></i>
						Record History
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


<?php $this->startIfEmpty('record_history_init'); ?>
<script type="text/javascript">
	$(document).ready(function(){
		DreamCMS.loadTraceLog('<?php echo $ajax_url; ?>');
	});
</script>
<?php $this->end(); ?>

