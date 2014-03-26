<?php
App::uses('DreamcmsAppController', 'Dreamcms.Controller');

/**
 * Pages Controller
 *
 * @property Page $Page
 * @property PaginatorComponent $Paginator
 */
class PagesController extends DreamcmsAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * logableModel
 *
 * @var string
 */
	public $logableModel = 'Page';

/**
 * Uses
 *
 * @var array
 */
	public $uses = array(
		'Dreamcms.PageAttachmentType',
		'Dreamcms.PageAttachment',
		'Dreamcms.PageType', 
		'Dreamcms.Page'
	);

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->loadModel('Dreamcms.PageAttachment');
		$this->loadModel('Dreamcms.PageAttachmentType');
		$this->loadModel('Dreamcms.PageType');
		$this->loadModel('Dreamcms.Page');

		$this->Routeable->setParentModel($this->PageType);
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->DreamcmsAcl->authorize();
		/******************************************
		 * Data Finder Setup
		 ******************************************/
		$this->DataFinder->setupModel($this->Page);
		$this->DataFinder->setupConditions();

		$this->Page->setLanguage(Configure::read('Config.language'));
		$this->Page->recursive = 0;
		
		$paginate = $this->paginate;
		$paginate['fields'] = array(
			'Page.id', 'Page.page_type_id', 'Page.path', 'Page.name', 'Page.description', 'Page.tags', 
			'Page.read_count', 'Page.published', 'Page.published_at', 'Page.deleted', 'Page.created', 
			'Page.modified', 'PageType.id', 'PageType.parent_id', 'PageType.name'
		);
		$paginate['conditions'] = $this->Routeable->getAssociatedFindConditions('Page.page_type_id');
		$this->paginate = $paginate;

		$this->Page->bindModel(array('belongsTo' => array('PageType')));
		$this->set('pages', $this->paginate($this->Page));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->DreamcmsAcl->authorize();
		if (!$this->Page->exists($id)) {
			throw new NotFoundException(__('Invalid page'));
		}
		$this->Page->setLanguage(Configure::read('Config.language'));

		$conditions = Set::merge(array('Page.' . $this->Page->primaryKey => $id), $this->Routeable->getAssociatedFindConditions('Page.page_type_id'));
		$options = array('conditions' => $conditions);
		$page = $this->Page->find('first', $options);
		if (!$page) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->set('page', $page);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->DreamcmsAcl->authorize();
		$this->Page->setLanguage(Configure::read('Config.language'));
		if ($this->request->is('post')) {
			$this->Translator->init($this->Page, $this->request->data);
			if ($this->Translator->validate()) {
				$this->Translator->save();
				$this->savePageAttachments();
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' has been saved'), 'flash/success');
				$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
			}
		}
		$pageTypes = $this->PageType->generateTreeList($this->Routeable->getTreeListConditions());
		$this->set('pageTypes', $pageTypes);

		$pageAttachmentTypes = $this->PageAttachmentType->find('all');
		$this->set('pageAttachmentTypes', $pageAttachmentTypes);
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->DreamcmsAcl->authorize();
		$pageTypes = $this->PageType->generateTreeList($this->Routeable->getTreeListConditions());
		$this->set('pageTypes', $pageTypes);
		$pageAttachmentTypes = $this->PageAttachmentType->find('all');
		$this->set('pageAttachmentTypes', $pageAttachmentTypes);

        $this->Page->id = $id;
		if (!$this->Page->exists($id)) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->Page->setLanguage(Configure::read('Config.language'));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Translator->init($this->Page, $this->request->data);
			if ($this->Translator->validate()) {
				$this->Translator->save();
				$this->savePageAttachments();
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' has been saved'), 'flash/success');
				$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
			}
		} else {
			$this->PageType->unbindModel(array('hasMany' => array('Page')));
			$this->PageAttachmentType->unbindModel(array('hasMany' => array('PageAttachment')));
			$this->PageAttachment->unbindModel(array('belongsTo' => array('Page')));
			$this->Page->PageAttachment->bindThumbnails();
			$this->Page->PageType->unbindModel(array('hasMany' => array('Page')));

			$options = array(
				'fields' => array(
					'Page.id', 'Page.page_type_id', 'Page.path', 'Page.name', 'Page.description', 'Page.tags', 'Page.content', 
					'Page.read_count', 'Page.published', 'Page.published_at', 'Page.deleted', 'Page.created', 'Page.modified'
				),
				'conditions' => array('Page.' . $this->Page->primaryKey => $id), 
				'recursive' => 2
			);

			$this->request->data = $this->Translator->findFirst($this->Page, $options);
			if (!$this->request->data)
				throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));

			$rootPageTypes = $this->Routeable->getAssociatedFindConditions('Page.page_type_id');
			$rootPageTypes = $rootPageTypes['Page.page_type_id'];
			if ((count($rootPageTypes) > 0) && !in_array($this->request->data['Page']['page_type_id'], $rootPageTypes))
				throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->DreamcmsAcl->authorize();
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException(__('Invalid page'));
		}

		$page = $this->Page->find('first', array('fields' => array('Page.id', 'Page.deleted'), 'conditions' => array('Page.id' => $id)));
		if (!$page)
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));

		if ((Configure::read('DreamCMS.permanent_delete') == 'Yes') && $this->Page->delete()) {
			$this->Session->setFlash(__($this->Routeable->singularize . ' deleted'), 'flash/success');
			$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
		}
		elseif (Configure::read('DreamCMS.permanent_delete') == 'No') {
			$page['Page']['deleted'] = '1';
			$this->Page->create($page);
			$this->Page->save($page);
			$this->Session->setFlash(__($this->Routeable->singularize . ' deleted'), 'flash/success');
			$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
		}
		$this->Session->setFlash(__($this->Routeable->singularize . ' was not deleted'), 'flash/error');
		$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
	}

/**
 * get_attachment_description method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $page_attachment_type_id
 * @return void
 */
	public function get_attachment_description($page_attachment_type_id) {
		$this->layout = 'blank';

		//if (!$this->request->is('ajax')) {
		//	throw new MethodNotAllowedException();
		//}

		$this->PageAttachmentType->id = $page_attachment_type_id;
		if (!$this->PageAttachmentType->exists()) {
			throw new NotFoundException(__('Invalid attachment type'));
		}

		$pageAttachmentType = $this->PageAttachmentType->find('first', array('conditions' => array('PageAttachmentType.id' => $page_attachment_type_id)));
		if (!$pageAttachmentType) {
			throw new NotFoundException(__('Invalid attachment type'));
		}

		echo $pageAttachmentType['PageAttachmentType']['description'];
		die();
	}

	protected function savePageAttachments() {
		if (!isset($this->request->data['PageAttachment']) || empty($this->request->data['PageAttachment']) || !is_array($this->request->data['PageAttachment']))
			return false;

		$page_id = $this->Page->id;

		foreach ($this->request->data['PageAttachment'] as $pageAttachment)
		{
			$data = array('PageAttachment' => array(
				'page_id' => $page_id,
				'page_attachment_type_id' => $pageAttachment['page_attachment_type_id'],
				'name' => $pageAttachment['name'],
				'filename' => $pageAttachment['filename'],
			));

			$this->PageAttachment->create($data);
			$this->PageAttachment->save($data);
		}
	}

	public function delete_attachment($page_id, $attachment_id)
	{
		$pageAttachment = $this->PageAttachment->find('first', array(
			'conditions' => array(
				'PageAttachment.page_id' => $page_id,
				'PageAttachment.id' => $attachment_id
			),
			'limit' => 1,
			'recursive' => 0
		));

		if ($pageAttachment)
		{
			if (Configure::read('DreamCMS.permanent_delete') == 'Yes') {
				$this->PageAttachment->id = $pageAttachment['PageAttachment']['id'];
				$this->PageAttachment->delete();
			}
			elseif (Configure::read('DreamCMS.permanent_delete') == 'No') {
				$pageAttachment['PageAttachment']['deleted'] = '1';
				$this->PageAttachment->create($pageAttachment);
				$this->PageAttachment->save($pageAttachment);
			}
		}

		echo 'OK';
		die();
	}

}
