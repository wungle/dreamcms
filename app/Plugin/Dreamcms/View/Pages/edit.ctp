

<?php $this->startIfEmpty('tinymce_init'); ?>
<?php $templates = FileUtility::getTinymceTemplateList(); ?>
		<script type="text/javascript" src="<?php echo $this->Html->url('/js/vendors/tinymce/tinymce.min.js'); ?>"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				tinymce.init({
					selector: ".tinymce-editor",
					theme: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview hr anchor pagebreak",
						"searchreplace wordcount visualblocks visualchars code fullscreen",
						"insertdatetime media nonbreaking save table contextmenu directionality",
						"emoticons template paste textcolor"
					],
					toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
					toolbar2: "print preview media | forecolor backcolor emoticons",
					image_advtab: true,
					content_css: '<?php echo $this->Html->url(Configure::read('DreamCMS.web_css')); ?>',
					templates: [
<?php for ($i=0,$c=count($templates); $i<$c; $i++) : ?>
						{title: '<?php echo $templates[$i]['name']; ?>', description: '<?php echo $templates[$i]['description']; ?>', url: '<?php echo $this->Html->url($templates[$i]['url']); ?>'}<?php if ($i < $c-1) echo ','; ?>
<?php endfor; ?>
					],
					autosave_ask_before_unload: false,
					file_browser_callback: function(field_name, url, type, win) {
						// from http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript
						var w = window,
						d = document,
						e = d.documentElement,
						g = d.getElementsByTagName('body')[0],
						x = w.innerWidth || e.clientWidth || g.clientWidth,
						y = w.innerHeight|| e.clientHeight|| g.clientHeight;

						var cmsURL = '<?php echo $this->Html->url('/js/vendors/simogeo_filemanager/index.html'); ?>?&field_name='+field_name+'&lang='+tinymce.settings.language;

						if(type == 'image') {
							cmsURL = cmsURL + "&type=images";
						}

						tinyMCE.activeEditor.windowManager.open({
							file : cmsURL,
							title : 'Filemanager',
							width : x * 0.8,
							height : y * 0.8,
							resizable : "yes",
							close_previous : "no"
						});
					}
				});
			});
		</script>
<?php $this->end(); ?>

<?php $this->startIfEmpty('page_inline_scripts'); ?>
			<script type="text/javascript">
				var pageAttachmentTypes = {
					count: <?php echo count($pageAttachmentTypes); ?>,
					data: [
<?php for ($i=0,$c=count($pageAttachmentTypes); $i<$c; $i++) : ?>
						{
							id: '<?php echo $pageAttachmentTypes[$i]['PageAttachmentType']['id']; ?>',
							name: '<?php echo $pageAttachmentTypes[$i]['PageAttachmentType']['name']; ?>'
<?php if ($i < $c-1) : ?>
						},
<?php else : ?>
						}
<?php endif; ?>
<?php endfor; ?>
					]
				};

				$(document).ready(function(){
					$(document).find('.form-field-tags').each(function(){
						var form_input = this;
						var form_id = $(form_input).attr('id');
						//we could just set the data-provide="tag" of the element inside HTML, but IE8 fails!
						if(! ( /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase())) )
						{
							var new_element = $(form_input).tag(
							  {
								placeholder:$(form_input).attr('placeholder'),
								//enable typeahead by specifying the source array
								source: ace.variable_US_STATES,//defined in ace.js >> ace.enable_search_ahead
							  }
							);
							$(form_input).next('input').addClass('form-control');
						}
						else {
							//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
							$(form_input).after('<textarea id="'+$(form_input).attr('id')+'" name="'+$(form_input).attr('name')+'" rows="3">'+$(form_input).val()+'</textarea>').remove();
							//$(form_input).autosize({append: "\n"});
						}
					});
				});
			</script>
<?php $this->end(); ?>

<?php $this->startIfEmpty('breadcrumb'); ?>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="<?php echo $this->Html->url('/dreamcms'); ?>"><?php echo __('Home'); ?></a>
							</li>
							<li class="active"><?php echo __($this->Routeable->humanizeController()); ?></li>
						</ul><!-- .breadcrumb -->
<?php $this->end(); ?>

<div class="row">
	<div class="col-sm-12">
		<h2><?php echo __('Edit ' . $this->Routeable->singularizeController()); ?></h2>
		<div class="pages form">
			<?php echo $this->Form->create('Page', array('role' => 'form')); ?>
				<fieldset>
					<div class="form-group">
						<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<div class="input select">
							<?php
								$no_parent_option = (isset($this->params->params['root_node']) && !empty($this->params->params['root_node'])) ? false : true;
								echo $this->DreamcmsForm->treeSelect(array(
									'model' => 'Page',
									'field' => 'page_type_id',
									'class' => 'form-control',
									'tree' => $pageTypes,
									'no_parent_option' => $no_parent_option,
									'current' => $this->request->data['Page']['page_type_id']
								));
							?>
						</div>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('path', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<?php
						echo $this->element(
							'common/translated_items',
							array(
								'localeList' => $localeList,
								'modelName' => 'Page',
								'elements' => array(
									'name' => array('class' => 'form-control'),
									'description' => array('type' => 'textarea', 'class' => 'form-control', 'rows' => 5),
									'content' => array('type' => 'textarea', 'class' => 'form-control tinymce-editor', 'rows' => '25', 'required' => false),
								)
							)
						);
					?>

					<div class="form-group">
						<div>
							<?php echo $this->Form->label('tags'); ?>
						</div>
						<div>
							<?php echo $this->Form->input('tags', array('class' => 'form-field-tags', 'placeholder' => 'Enter keywords / tags here..', 'label' => false, 'required' => false)); ?>
						</div>
					</div><!-- .form-group -->

					<div class="form-group">
						<?php echo $this->Form->input('published', array('class' => 'form-control', 'options' => array('Yes' => 'Yes', 'No' => 'No'))); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<div>
							<?php echo $this->Form->label('published_at'); ?>
						</div>
						<div>
							<?php echo $this->Form->input('published_at', array('type' => 'datetime', 'dateFormat' => 'DMY', 'timeFormat' => '24', 'label' => false)); ?>
						</div>
					</div><!-- .form-group -->

				</fieldset>

				<div id="PageAttachments">
					<hr />
					<h3>Attachments</h3>

					<div id="PageAttachmentsContainer">
<?php foreach ($this->request->data['PageAttachment'] as $attachment) : ?>
						<fieldset id="currentPageAttachment-<?php echo $attachment['id']; ?>" class="well dreamcms-well">
							<div class="form-group">
								<?php echo $this->Form->label('attachment_type'); ?>
								<div class-"form-control">
									<?php echo $attachment['PageAttachmentType']['name']; ?>
								</div>
							</div>
							<div class="form-group">
								<?php echo $this->Form->label('attachment_name'); ?>
								<div class-"form-control">
									<?php echo $attachment['name']; ?>
								</div>
							</div>
							<div class="form-group">
								<?php echo $this->Form->label('filename'); ?>
								<div class-"form-control">
									<a href="<?php echo $this->Html->url($attachment['filename']); ?>" target="_blank"><?php echo $attachment['filename']; ?></a>
								</div>
							</div>
<?php if ($attachment['category'] == 'Image') : ?>
							<div class="form-group">
								<?php echo $this->Form->label('thumbnail'); ?>
								<div class-"form-control">
									<a href="<?php echo $this->Html->url($attachment['filename']); ?>" target="_blank"><img src="<?php echo $this->Html->url($attachment['filename']); ?>" class="dreamcms-page-attachment-thumbnail" alt="" /></a>
								</div>
							</div>
<?php endif; ?>
							<div class="form-group">
								<div class-"form-control">
									<a href="javascript:void(0);" onclick="javascript:DreamCMS.deletePageAttachment('<?php echo $attachment['page_id']; ?>', '<?php echo $attachment['id']; ?>');" class="btn btn-sm btn-danger">Delete attachment</a>
								</div>
							</div>
						</fieldset>
<?php endforeach; ?>
					</div>
				</div>

				<fieldset>
					<div class="form-group">
						<a href="javascript:DreamCMS.addPageAttachment();" class="btn btn-success">Add more attachment</a>
					</div>
				</fieldset>

				<fieldset>
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary')); ?>
				</fieldset>
			<?php echo $this->Form->end(); ?>
		</div>

		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<?php echo $this->element('common/record_history', array('record_id' => $this->request->data['Page']['id'])); ?>
	</div>
</div>
