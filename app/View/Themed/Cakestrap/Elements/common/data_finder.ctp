

			<div class="well">
				<button type="button" class="btn btn-default" id="DataFinderToggler">Search</button>
				<form action="" method="POST">
					<div id="DataFinderContainer">
						<div class="dfrow">
							<a href="javascript:void(0);" class="btn btn-info" id="DataFinderAdd">Add more condition</a>
						</div>
					</div>
					<div id="DataFinderControl">
						<div class="dfrow">
							<a href="javascript:void(0);" class="btn btn-default" id="DataFinderCancel">Cancel</a>
							<button class="btn btn-primary">Search</button>
						</div>
					</div>
				</form>
			</div>
			<br />

<?php if (isset($dataFinderFieldNames) && !empty($dataFinderFieldNames) && isset($dataFinderDisplayNames) && !empty($dataFinderDisplayNames)) : ?>
<script type="text/javascript">
	$(document).ready(function(){
		DataFinder.init(
			[<?php echo implode(', ', $dataFinderDisplayNames); ?>],
			[<?php echo implode(', ', $dataFinderFieldNames); ?>]
		);

<?php if (isset($dataFinderConditions) && is_array($dataFinderConditions) && (count($dataFinderConditions) > 0)) : ?>
<?php foreach ($dataFinderConditions as $tmp) : ?>
		DataFinder.preCondition('<?php echo h($tmp['field']); ?>', '<?php echo h($tmp['op']); ?>', '<?php echo h($tmp['value']); ?>'); 
<?php endforeach; ?> 
<?php else : ?>
		DataFinder.preCondition('', '', ''); 
<?php endif; ?> 
	});
</script>
<?php endif; ?> 

