

				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="icon-leaf green"></i>
									<span class="red">Dream</span>
									<span class="white">CMS</span>
								</h1>
								<h4 class="blue">Content Management System</h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="icon-lock green"></i>
												Enter Your Login Information
											</h4>

											<div class="space-6"></div>

											<?php
												echo $this->Form->create(
													'Admin',
													array(
														"url" => $params_here,
														"name" => "login-form",
														"id" => "login-form",
														"method" => "post"
													)
												);
											?> 
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<?php
																echo $this->Form->input(
																	'username',
																	array(
																		'type' => 'text',
																		'id' => 'username',
																		'class' => 'form-control',
																		'placeholder' => 'Username',
																		'div' => false,
																		'label' => false,
																		'error' => false,
																		'required' => 'required'
																	)
																);
															?> 
															<!--input type="text" class="form-control" placeholder="Username" /-->
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<?php
																echo $this->Form->input(
																	'password',
																	array(
																		'type' => 'password',
																		'id' => 'password',
																		'class' => 'form-control',
																		'placeholder' => 'Password',
																		'div' => false,
																		'label' => false,
																		'error' => false,
																		'required' => 'required'
																	)
																);
															?> 
															<!--input type="password" class="form-control" placeholder="Password" /-->
															<i class="icon-lock"></i>
														</span>
													</label>

													<label class="block clearfix secret-captcha-container">
														<img src="<?php echo $this->Html->url('/secret/captcha'); ?>" class="secret-captcha" />
														<i class="icon-refresh secret-captcha-reload"></i>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<?php
																echo $this->Form->input(
																	'captcha',
																	array(
																		'type' => 'text',
																		'id' => 'captcha',
																		'class' => 'form-control',
																		'placeholder' => 'Captcha validation',
																		'div' => false,
																		'label' => false,
																		'error' => false,
																		'required' => 'required'
																	)
																);
															?> 
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="icon-key"></i>
															Login
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											<?php echo $this->Form->end(); ?> 

										</div><!-- /widget-main -->

										<div class="toolbar clearfix">
											<div>
												<a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
													<i class="icon-arrow-left"></i>
													I forgot my password
												</a>
											</div>

											<div>
												<!-- none -->
											</div>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /login-box -->

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="icon-key"></i>
												Retrieve Password
											</h4>

											<div class="space-6"></div>
											<p>
												Enter your email and to receive instructions
											</p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="Email" />
															<i class="icon-envelope"></i>
														</span>
													</label>

													<div class="clearfix">
														<button type="button" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="icon-lightbulb"></i>
															Send Me!
														</button>
													</div>
												</fieldset>
											</form>
										</div><!-- /widget-main -->

										<div class="toolbar center">
											<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
												Back to login
												<i class="icon-arrow-right"></i>
											</a>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /forgot-box -->

								<div id="signup-box" class="signup-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="icon-group blue"></i>
												New User Registration
											</h4>

											<div class="space-6"></div>
											<p> Enter your details to begin: </p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="Email" />
															<i class="icon-envelope"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="Username" />
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Password" />
															<i class="icon-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Repeat password" />
															<i class="icon-retweet"></i>
														</span>
													</label>

													<label class="block">
														<input type="checkbox" class="ace" />
														<span class="lbl">
															I accept the
															<a href="#">User Agreement</a>
														</span>
													</label>

													<div class="space-24"></div>

													<div class="clearfix">
														<button type="reset" class="width-30 pull-left btn btn-sm">
															<i class="icon-refresh"></i>
															Reset
														</button>

														<button type="button" class="width-65 pull-right btn btn-sm btn-success">
															Register
															<i class="icon-arrow-right icon-on-right"></i>
														</button>
													</div>
												</fieldset>
											</form>
										</div>

										<div class="toolbar center">
											<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
												<i class="icon-arrow-left"></i>
												Back to login
											</a>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /signup-box -->
							</div><!-- /position-relative -->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->

