<?php
App::uses('DreamcmsAppController', 'Dreamcms.Controller');
App::uses("SimpleCaptcha", 'Dreamcms.Lib');
/**
 * SimpleCaptcha Controller
 *
 */
class SimpleCaptchaController extends DreamcmsAppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		//
	}

/**
 * secret_captcha method
 *
 * @return void
 */
	public function secret_captcha($counter = 0) {
		$captcha = new SimpleCaptcha();

		$captcha->setCakeSession($this->Session);
		$captcha->session_var = 'DreamCMS.simple_captcha_value';
		$captcha->width = 289;
		$captcha->height = 60;
		$captcha->imageFormat = 'png';
		//$captcha->lineWidth = 3;
		$captcha->scale = 3;
		$captcha->blur = true;

		// Image generation
		$captcha->CreateImage();
	}
}