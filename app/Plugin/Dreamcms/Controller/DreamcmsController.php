<?php
App::uses('DreamcmsAppController', 'Dreamcms.Controller');
/**
 * Dreamcms Controller
 *
 * @property CmsLog $CmsLog
 */
class DreamcmsController extends DreamcmsAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * Uses
 *
 * @var array
 */
	public $uses = array('Dreamcms.CmsLog');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		//
	}

/**
 * admin_activities method
 *
 * @throws NotFoundException
 * @param integer $start
 * @param integer $limit
 * @return void
 */
	public function admin_activities($start = 0, $limit = 10)
	{
		$this->layout = 'blank';

		$this->loadModel('Dreamcms.CmsLog');

		$data = $this->CmsLog->find(
			'all',
			array(
				'fields' => array(
					'CmsLog.id', 'CmsLog.admin', 'CmsLog.controller', 'CmsLog.model', 'CmsLog.foreign_key',
					'CmsLog.fields', 'CmsLog.operation', 'CmsLog.description', 'CmsLog.url', 'CmsLog.created',
					'CmsLog.modified'
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
