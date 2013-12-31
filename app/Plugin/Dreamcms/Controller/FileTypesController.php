<?php
App::uses('DreamcmsAppController', 'Dreamcms.Controller');
/**
 * FileTypes Controller
 *
 * @property FileType $FileType
 * @property PaginatorComponent $Paginator
 */
class FileTypesController extends DreamcmsAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Routeable->setParentModel($this->FileType);
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
		$this->DataFinder->setupModel($this->FileType);
		$this->DataFinder->setupConditions();

		$this->FileType->recursive = 0;
		$paginate = $this->paginate;
		$paginate['conditions'] = Set::merge(array('FileType.deleted' => 0), $this->Routeable->getFindConditions());
		$this->paginate = $paginate;
		$this->set('fileTypes', $this->paginate());
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
		if (!$this->FileType->exists($id)) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$conditions = Set::merge(array('FileType.' . $this->FileType->primaryKey => $id, 'FileType.deleted' => 0), $this->Routeable->getFindConditions());
		$options = array('conditions' => $conditions);
		$fileType = $this->FileType->find('first', $options);
		if (!$fileType) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->set('fileType', $fileType);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->DreamcmsAcl->authorize();
		if ($this->request->is('post')) {
			$this->FileType->create();
			if ($this->FileType->save($this->request->data)) {
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' has been saved'), 'flash/success');
				$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
			} else {
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$parentFileTypes = $this->FileType->generateTreeList(Set::merge(array('FileType.deleted' => 0), $this->Routeable->getTreeListConditions()));
		$this->set('parentFileTypes', $parentFileTypes);
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
        $this->FileType->id = $id;
		if (!$this->FileType->exists($id)) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->FileType->save($this->request->data)) {
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' has been saved'), 'flash/success');
				$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
			} else {
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => Set::merge(array('FileType.' . $this->FileType->primaryKey => $id, 'FileType.deleted' => 0), $this->Routeable->getFindConditions()));
			$this->request->data = $this->FileType->find('first', $options);
			if (!$this->request->data)
				throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$parentFileTypes = $this->FileType->generateTreeList(Set::merge(array('FileType.deleted' => 0), $this->Routeable->getTreeListConditions()));
		$this->set('parentFileTypes', $parentFileTypes);
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
		$this->FileType->id = $id;
		if (!$this->FileType->exists()) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}

		$conditions = Set::merge(array('FileType.deleted' => 0), $this->Routeable->getFindConditions());
		$fileType = $this->FileType->find('first', array('conditions' => $conditions));
		if (!$fileType)
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));

		if ($this->FileType->delete()) {
			$this->Session->setFlash(__($this->Routeable->singularize . ' deleted'), 'flash/success');
			$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
		}
		$this->Session->setFlash(__($this->Routeable->singularize . ' was not deleted'), 'flash/error');
		$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
	}}
