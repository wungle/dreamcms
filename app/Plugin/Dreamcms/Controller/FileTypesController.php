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
			throw new NotFoundException(__('Invalid file type'));
		}
		$options = array('conditions' => array('FileType.' . $this->FileType->primaryKey => $id));
		$this->set('fileType', $this->FileType->find('first', $options));
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
				$this->Session->setFlash(__('The file type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The file type could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$this->set('parentFileTypes', $this->FileType->generateTreeList());
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
			throw new NotFoundException(__('Invalid file type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->FileType->save($this->request->data)) {
				$this->Session->setFlash(__('The file type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The file type could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('FileType.' . $this->FileType->primaryKey => $id));
			$this->request->data = $this->FileType->find('first', $options);
		}
		$this->set('parentFileTypes', $this->FileType->generateTreeList());
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
			throw new NotFoundException(__('Invalid file type'));
		}
		if ($this->FileType->delete()) {
			$this->Session->setFlash(__('File type deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('File type was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}}
