<?php
App::uses('DreamcmsAppController', 'Dreamcms.Controller');
/**
 * Languages Controller
 *
 * @property Language $Language
 * @property PaginatorComponent $Paginator
 */
class LanguagesController extends DreamcmsAppController {

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
		$this->DataFinder->setupModel($this->Language);
		$this->DataFinder->setupConditions();

		$this->Language->recursive = 0;
		$this->set('languages', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Language->exists($id)) {
			throw new NotFoundException(__('Invalid language'));
		}
		$options = array('conditions' => array('Language.' . $this->Language->primaryKey => $id));
		$this->set('language', $this->Language->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Language->create();
			if ($this->Language->save($this->request->data)) {
				$this->Session->setFlash(__('The language has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The language could not be saved. Please, try again.'), 'flash/error');
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
        $this->Language->id = $id;
		if (!$this->Language->exists($id)) {
			throw new NotFoundException(__('Invalid language'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Language->save($this->request->data)) {
				$this->Session->setFlash(__('The language has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The language could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('Language.' . $this->Language->primaryKey => $id));
			$this->request->data = $this->Language->find('first', $options);
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
		$this->Language->id = $id;
		if (!$this->Language->exists()) {
			throw new NotFoundException(__('Invalid language'));
		}
		if ($this->Language->delete()) {
			$this->Session->setFlash(__('Language deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Language was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}}
