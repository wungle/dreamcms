<?php
App::uses('DreamCmsAppController', 'DreamCms.Controller');
/**
 * ThumbnailTypes Controller
 *
 * @property ThumbnailType $ThumbnailType
 * @property PaginatorComponent $Paginator
 */
class ThumbnailTypesController extends DreamCmsAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		/******************************************
		 * Data Finder Setup
		 ******************************************/
		$this->DataFinder->setupModel($this->ThumbnailType);
		$this->DataFinder->setupConditions();

		$this->ThumbnailType->recursive = 0;
		$this->set('thumbnailTypes', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ThumbnailType->exists($id)) {
			throw new NotFoundException(__('Invalid thumbnail type'));
		}
		$options = array('conditions' => array('ThumbnailType.' . $this->ThumbnailType->primaryKey => $id));
		$this->set('thumbnailType', $this->ThumbnailType->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ThumbnailType->create();
			if ($this->ThumbnailType->save($this->request->data)) {
				$this->Session->setFlash(__('The thumbnail type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The thumbnail type could not be saved. Please, try again.'), 'flash/error');
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->ThumbnailType->id = $id;
		if (!$this->ThumbnailType->exists($id)) {
			throw new NotFoundException(__('Invalid thumbnail type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ThumbnailType->save($this->request->data)) {
				$this->Session->setFlash(__('The thumbnail type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The thumbnail type could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('ThumbnailType.' . $this->ThumbnailType->primaryKey => $id));
			$this->request->data = $this->ThumbnailType->find('first', $options);
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
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->ThumbnailType->id = $id;
		if (!$this->ThumbnailType->exists()) {
			throw new NotFoundException(__('Invalid thumbnail type'));
		}
		if ($this->ThumbnailType->delete()) {
			$this->Session->setFlash(__('Thumbnail type deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Thumbnail type was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}}
