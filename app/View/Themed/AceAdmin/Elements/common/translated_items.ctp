
<?php
$unique_id = intval(Configure::read('DreamCMS.translated_items.index'));
Configure::write('DreamCMS.translated_items.index', $unique_id+1);
?>
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
													<a data-toggle="tab" href="#<?php echo h('lang-' . $name . '-' . $unique_id); ?>">
														<?php echo h($name); ?> 
													</a>
												</li> 
<?php endforeach; ?> 
											</ul>

											<div class="tab-content">
<?php $first = true; ?> 
<?php foreach ($localeList as $name => $locale) : ?>
<?php if ($first) : ?>
												<div id="<?php echo h('lang-' . $name . '-' . $unique_id); ?>" class="tab-pane in active">
<?php $first = false; ?>
<?php else : ?>
												<div id="<?php echo h('lang-' . $name . '-' . $unique_id); ?>" class="tab-pane">
<?php endif; ?> 

<?php foreach ($elements as $field => $options) : ?>
<?php $options['label'] = false; ?>
													<div class="form-group">
														<?php
															if (strpos($field, '_uploadable_thumbnail') !== false)
															{
																if (isset($this->request->data[$modelName][$field][$locale]))
																{
																	echo $this->Form->label('thumbnail');
																	echo '<div><img alt="" src="data:image/jpeg;base64,'. $this->request->data[$modelName][$field][$locale] .'" /></div>';
																}
															}
															elseif (strpos($field, '_uploadable_filesize') !== false)
															{
																echo $this->Form->label('file_size');
																echo $this->Form->input($modelName . '.' . $field . '.' . $locale, $options);
															}
															else
															{
																echo $this->Form->label($field);
																echo $this->Form->input($modelName . '.' . $field . '.' . $locale, $options);
															}
														?> 
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
									<?php
										if (strpos($field, '_uploadable_thumbnail') !== false)
										{
											if (isset($this->request->data[$modelName][$field][$locale]))
											{
												echo $this->Form->label('thumbnail');
												echo '<div><img alt="" src="data:image/jpeg;base64,'. $this->request->data[$modelName][$field][$locale] .'" /></div>';
											}
										}
										elseif (strpos($field, '_uploadable_filesize') !== false)
										{
											echo $this->Form->label('file_size');
											echo $this->Form->input($modelName . '.' . $field . '.' . $locale, $options);
										}
										else
										{
											echo $this->Form->label($field);
											echo $this->Form->input($modelName . '.' . $field . '.' . $locale, $options);
										}
									?> 
								</div>
								
<?php endforeach; ?> 
<?php endforeach; ?> 
<?php endif; ?> 

