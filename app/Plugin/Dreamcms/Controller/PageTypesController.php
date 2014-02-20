<?php
App::uses('DreamcmsAppController', 'Dreamcms.Controller');
/**
 * PageTypes Controller
 *
 * @property PageType $PageType
 * @property PaginatorComponent $Paginator
 */
class PageTypesController extends DreamcmsAppController {

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
	public $logableModel = 'PageType';

	public function beforeFilter()
	{
		parent::beforeFilter();

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
		$this->DataFinder->setupModel($this->PageType);
		$this->DataFinder->setupConditions();

		$this->PageType->recursive = 0;
		$paginate = $this->paginate;
		$paginate['conditions'] = $this->Routeable->getFindConditions();
		$this->paginate = $paginate;
		$this->set('pageTypes', $this->paginate());
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
		if (!$this->PageType->exists($id)) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$conditions = Set::merge(array('PageType.' . $this->PageType->primaryKey => $id), $this->Routeable->getFindConditions());
		$options = array('conditions' => $conditions);
		$pageType = $this->PageType->find('first', $options);
		if (!$pageType) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->set('pageType', $pageType);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->DreamcmsAcl->authorize();
		if ($this->request->is('post')) {
			$this->PageType->create();
			if ($this->PageType->save($this->request->data)) {
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$parentPageTypes = $this->PageType->generateTreeList($this->Routeable->getTreeListConditions());
		$this->set(compact('parentPageTypes'));
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
        $this->PageType->id = $id;
		if (!$this->PageType->exists($id)) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PageType->save($this->request->data)) {
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => Set::merge(array('PageType.' . $this->PageType->primaryKey => $id), $this->Routeable->getFindConditions()));
			$this->request->data = $this->PageType->find('first', $options);

			if (!$this->request->data)
				throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$parentPageTypes = $this->PageType->generateTreeList($this->Routeable->getTreeListConditions());
		$this->set(compact('parentPageTypes'));
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
		$this->PageType->id = $id;
		if (!$this->PageType->exists()) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}

		$options = array('conditions' => array('PageType.' . $this->PageType->primaryKey => $id));
		$pageType = $this->PageType->find('first', $options);
		if (!$pageType)
			throw new NotFoundException(__('Invalid '. strtolower($this->Routeable->singularize)));

		if ((Configure::read('DreamCMS.permanent_delete') == 'Yes') && $this->PageType->delete()) {
			$this->Session->setFlash(__($this->Routeable->singularize . ' deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		elseif (Configure::read('DreamCMS.permanent_delete') == 'No') {
			$pageType['PageType']['deleted'] = '1';
			$this->PageType->create($pageType);
			$this->PageType->save($pageType);
			$this->Session->setFlash(__($this->Routeable->singularize . ' deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__($this->Routeable->singularize . ' was not deleted'), 'flash/error');
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

		$parentPageTypes = $this->PageType->generateTreeList($this->Routeable->getTreeListConditions());
		$this->set(compact('parentPageTypes'));
	}
}
