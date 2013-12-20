<?php
App::uses('DreamcmsAppController', 'Dreamcms.Controller');
/**
 * TempDirs Controller
 *
 * @property TempDir $TempDir
 * @property PaginatorComponent $Paginator
 */
class TempDirsController extends DreamcmsAppController {

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
		$this->DataFinder->setupModel($this->TempDir);
		$this->DataFinder->setupConditions();

		$this->TempDir->recursive = 0;
		$this->set('tempDirs', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TempDir->exists($id)) {
			throw new NotFoundException(__('Invalid temp dir'));
		}
		$options = array('conditions' => array('TempDir.' . $this->TempDir->primaryKey => $id));
		$this->set('tempDir', $this->TempDir->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TempDir->create();
			if ($this->TempDir->save($this->request->data)) {
				$this->Session->setFlash(__('The temp dir has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The temp dir could not be saved. Please, try again.'), 'flash/error');
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
        $this->TempDir->id = $id;
		if (!$this->TempDir->exists($id)) {
			throw new NotFoundException(__('Invalid temp dir'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TempDir->save($this->request->data)) {
				$this->Session->setFlash(__('The temp dir has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The temp dir could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('TempDir.' . $this->TempDir->primaryKey => $id));
			$this->request->data = $this->TempDir->find('first', $options);
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
		$this->TempDir->id = $id;
		if (!$this->TempDir->exists()) {
			throw new NotFoundException(__('Invalid temp dir'));
		}
		if ($this->TempDir->delete()) {
			$this->Session->setFlash(__('Temp dir deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Temp dir was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}}
