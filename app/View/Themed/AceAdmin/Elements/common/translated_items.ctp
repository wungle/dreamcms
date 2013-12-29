

<?php if (count($localeList) > 1) : ?>
								<hr />
								<h3>Translated items</h3>
								<div class="row">
									<div class="col-sm-12">
										<div class="tabbable">
											<ul class="nav nav-tabs" id="myTab">
<?php $first = true; ?>
<?php foreach ($localeList as $name => $locale) : ?>
<?php if ($first) : ?>
												<li class="active">
<?php $first = false; ?>
<?php else : ?>
												<li>
<?php endif; ?> 
													<a data-toggle="tab" href="#<?php echo h('lang-' . $name); ?>">
														<?php echo h($name); ?> 
													</a>
												</li> 
<?php endforeach; ?> 
											</ul>

											<div class="tab-content">
<?php $first = true; ?> 
<?php foreach ($localeList as $name => $locale) : ?>
<?php if ($first) : ?>
												<div id="<?php echo h('lang-' . $name); ?>" class="tab-pane in active">
<?php $first = false; ?>
<?php else : ?>
												<div id="<?php echo h('lang-' . $name); ?>" class="tab-pane">
<?php endif; ?> 

<?php foreach ($elements as $field => $options) : ?>
<?php $options['label'] = false; ?>
													<div class="form-group">
														<?php echo $this->Form->label($field); ?> 
														<?php echo $this->Form->input($modelName . '.' . $field . '.' . $locale, $options); ?> 
													</div>
<?php endforeach; ?> 
												</div>


<?php endforeach; ?> 

											</div>
										</div>
									</div><!-- /span -->

									<div class="vspace-xs-12"></div>
								</div><!-- /row -->

								<hr />
<?php else : ?>
<?php foreach ($localeList as $name => $locale) : ?>
<?php foreach ($elements as $field => $options) : ?>
<?php $options['label'] = false; ?>
								<div class="form-group">
									<?php echo $this->Form->label($field); ?> 
									<?php echo $this->Form->input($modelName . '.' . $field . '.' . $locale, $options); ?> 
								</div>
								
<?php endforeach; ?> 
<?php endforeach; ?> 
<?php endif; ?> 

