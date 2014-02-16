<?php
App::uses('DreamcmsAppController', 'Dreamcms.Controller');
/**
 * PageAttachmentTypes Controller
 *
 * @property PageAttachmentType $PageAttachmentType
 * @property PaginatorComponent $Paginator
 */
class PageAttachmentTypesController extends DreamcmsAppController {

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
	public $logableModel = 'PageAttachmentType';

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
		$this->DataFinder->setupModel($this->PageAttachmentType);
		$this->DataFinder->setupConditions();

		$this->PageAttachmentType->recursive = 0;
		$this->set('pageAttachmentTypes', $this->paginate());
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
		if (!$this->PageAttachmentType->exists($id)) {
			throw new NotFoundException(__('Invalid page attachment type'));
		}
		$options = array('conditions' => array('PageAttachmentType.' . $this->PageAttachmentType->primaryKey => $id));
		$pageAttachmentType = $this->PageAttachmentType->find('first', $options);
		if (!$pageAttachmentType)
			throw new NotFoundException(__('Invalid page attachment type'));
		$this->set('pageAttachmentType', $pageAttachmentType);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->DreamcmsAcl->authorize();
		if ($this->request->is('post')) {
			$this->PageAttachmentType->create();
			if ($this->PageAttachmentType->save($this->request->data)) {
				$this->Session->setFlash(__('The page attachment type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The page attachment type could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$parentPageAttachmentTypes = $this->PageAttachmentType->generateTreeList();
		$this->set(compact('parentPageAttachmentTypes'));
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
        $this->PageAttachmentType->id = $id;
		if (!$this->PageAttachmentType->exists($id)) {
			throw new NotFoundException(__('Invalid page attachment type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PageAttachmentType->save($this->request->data)) {
				$this->Session->setFlash(__('The page attachment type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The page attachment type could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('PageAttachmentType.' . $this->PageAttachmentType->primaryKey => $id));
			$this->request->data = $this->PageAttachmentType->find('first', $options);

			if (!$this->request->data)
				throw new NotFoundException(__('Invalid page attachment type'));
		}
		$parentPageAttachmentTypes = $this->PageAttachmentType->generateTreeList();
		$this->set(compact('parentPageAttachmentTypes'));
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
		$this->PageAttachmentType->id = $id;
		if (!$this->PageAttachmentType->exists()) {
			throw new NotFoundException(__('Invalid page attachment type'));
		}

		$options = array('conditions' => array('PageAttachmentType.' . $this->PageAttachmentType->primaryKey => $id));
		$pageAttachmentType = $this->PageAttachmentType->find('first', $options);
		if (!$pageAttachmentType)
			throw new NotFoundException(__('Invalid page attachment type'));

		if ((Configure::read('DreamCMS.permanent_delete') == 'Yes') && $this->PageAttachmentType->delete()) {
			$this->Session->setFlash(__('Page attachment type deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		elseif (Configure::read('DreamCMS.permanent_delete') == 'No') {
			$pageAttachmentType['PageAttachmentType']['deleted'] = '1';
			$this->PageAttachmentType->create($pageAttachmentType);
			$this->PageAttachmentType->save($pageAttachmentType);
			$this->Session->setFlash(__('Page attachment type deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Page attachment type was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
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
		parent::trace($record_id, $log_id);

		$parentPageAttachmentTypes = $this->PageAttachmentType->generateTreeList();
		$this->set(compact('parentPageAttachmentTypes'));
	}

}
