<?php

App::uses('AppController', 'Controller');

class DreamcmsAppController extends AppController {
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

	public $logableModel;

	public function beforeFilter()
	{
		parent::beforeFilter();

		if ((strpos($this->params->url, 'dreamcms') === 0)  && !$this->DreamcmsAuth->user())
			throw new NotFoundException();

		$this->DreamcmsAuth->allow('login');
		$this->DreamcmsAuth->allow('logout');
		$this->DreamcmsAuth->allow('secret_captcha');
	}

	public function beforeRender()
	{
		parent::beforeRender();
	}

/**
 * trace method
 *
 * @throws NotFoundException
 * @param string $record_id
 * @param string $log_id
 * @return void
 */
	public function trace($record_id, $log_id)
	{
		$this->loadModel('Dreamcms.CmsLog');

		$controller = Inflector::camelize(Configure::read('DreamCMS.Routeable.current_controller'));
		
		if (!$this->logableModel)
			$this->logableModel = Inflector::singularize($controller);

		$data = $this->CmsLog->find(
			'first',
			array(
				'conditions' => array(
					'CmsLog.id' => intval($log_id),
					'CmsLog.controller' => $controller,
					'CmsLog.model' => $this->logableModel,
					'CmsLog.foreign_key' => intval($record_id),
				),
				'order' => 'CmsLog.id ASC',
				'limit' => 1
			)
		);

		if (!$data)
			throw new NotFoundException(__('Invalid trace log.'));

		$data['CmsLog']['admin'] = unserialize($data['CmsLog']['admin']);
		$data['CmsLog']['data_before'] = unserialize($data['CmsLog']['data_before']);
		$data['CmsLog']['data_after'] = unserialize($data['CmsLog']['data_after']);

		if ($data['CmsLog']['data_before'])
			$data[$this->logableModel . 'Before'] = $data['CmsLog']['data_before'][$this->logableModel];

		if ($data['CmsLog']['data_after'])
			$data[$this->logableModel . 'After'] = $data['CmsLog']['data_after'][$this->logableModel];

		$data['Admin'] = $data['CmsLog']['admin'];

		$this->request->data = $data;

		$this->set('data', $data);
	}

/**
 * load_trace_logs method
 *
 * @throws NotFoundException
 * @param string $record_id
 * @param integer $start
 * @param integer $limit
 * @return void
 */
	public function load_trace_logs($record_id, $start = 0, $limit = 20)
	{
		$this->layout = 'blank';

		$this->loadModel('Dreamcms.CmsLog');

		$controller = Inflector::camelize(Configure::read('DreamCMS.Routeable.current_controller'));
		
		if (!$this->logableModel)
			$this->logableModel = Inflector::singularize($controller);

		$data = $this->CmsLog->find(
			'all',
			array(
				'fields' => array(
					'CmsLog.id', 'CmsLog.admin', 'CmsLog.controller', 'CmsLog.model', 'CmsLog.foreign_key',
					'CmsLog.fields', 'CmsLog.operation', 'CmsLog.description', 'CmsLog.url', 'CmsLog.created',
					'CmsLog.modified'
				),
				'conditions' => array(
					'CmsLog.controller' => $controller,
					'CmsLog.model' => $this->logableModel,
					'CmsLog.foreign_key' => intval($record_id),
				),
				'order' => 'CmsLog.id DESC',
				'offset' => $start,
				'limit' => $limit
			)
		);

		//if (empty($data))
		//	throw new NotFoundException(__('There was no more trace logs available.'));

		for ($i=0,$c=count($data); $i<$c; $i++)
			$data[$i]['CmsLog']['admin'] = unserialize($data[$i]['CmsLog']['admin']);

		$result = array(
			'count' => count($data),
			'data' => $data
		);

		echo json_encode($result); die();
	}
}

?>