<?php
App::uses('DreamCmsAppController', 'DreamCms.Controller');
App::uses("SimpleCaptcha", 'DreamCms.Lib');
/**
 * SimpleCaptcha Controller
 *
 */
class SimpleCaptchaController extends DreamCmsAppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$captcha = new SimpleCaptcha();

		$captcha->session_var = 'DreamCMS.simple_captcha_value';
		$captcha->width = 300;
		$captcha->height = 60;
		$captcha->imageFormat = 'png';
		//$captcha->lineWidth = 3;
		$captcha->scale = 3;
		$captcha->blur = true;

		// Image generation
		$captcha->CreateImage();
	}
}