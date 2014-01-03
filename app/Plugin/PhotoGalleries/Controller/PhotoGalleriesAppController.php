<?php

App::uses('AppController', 'Controller');

class PhotoGalleriesAppController extends AppController {
	public $theme = 'AceAdmin';

	public $components = array(
		'Session',
		'Dreamcms.DreamcmsAcl',
		'Dreamcms.Translator',
		'Dreamcms.Routeable',
		'Dreamcms.DreamcmsAuth' => array(
			'userModel' => 'Dreamcms.Admin',
			'authenticate' => array(
				'Dreamcms.Dreamcms' => array(
					'userModel' => 'Dreamcms.Admin',
					'sessionKey' => 'DreamCMS.Admin',
					'passwordHasher' => 'Blowfish'
				)
			)
		),
		'DataFinder',
	);

	public $helpers = array(
		'Html',
		'Form',
		'Number',
		'Paginator',
		'Session',
		'Text',
		'Time',
		'Dreamcms.CoreDreamCms',
		'Dreamcms.DreamcmsForm',
		'Dreamcms.Routeable',
	);

	public function beforeFilter()
	{
		parent::beforeFilter();

		if ((strpos($this->params->url, 'dreamcms') === 0)  && !$this->DreamcmsAuth->user())
			throw new NotFoundException();
	}

	public function beforeRender()
	{
		parent::beforeRender();
	}
}
