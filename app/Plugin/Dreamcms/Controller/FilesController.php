<?php
App::uses('DreamcmsAppController', 'Dreamcms.Controller');
/**
 * Files Controller
 *
 * @property File $File
 * @property PaginatorComponent $Paginator
 */
class FilesController extends DreamcmsAppController {

/**
 * Uses
 *
 * @var array
 */
	public $uses = array(
		'Dreamcms.File',
		'Dreamcms.FileType',
	);

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
		$this->DataFinder->setupModel($this->File);
		$this->DataFinder->setupConditions();

		$this->File->setLanguage(Configure::read('Config.language'));
		$this->File->recursive = 0;
		$this->set('files', $this->paginate());
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
		if (!$this->File->exists($id)) {
			throw new NotFoundException(__('Invalid file'));
		}
		$this->File->setLanguage(Configure::read('Config.language'));
		$options = array('conditions' => array('File.' . $this->File->primaryKey => $id));
		$this->set('file', $this->File->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->DreamcmsAcl->authorize();
		$this->File->setLanguage(Configure::read('Config.language'));
		if ($this->request->is('post')) {
			$this->Translator->init($this->File, $this->request->data);
			if ($this->Translator->validate()) {
				$this->Translator->save();
				$this->Session->setFlash(__('The file has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			}
		}
		$this->set('fileTypes', $this->FileType->generateTreeList());
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
		$this->set('fileTypes', $this->FileType->generateTreeList());
        $this->File->id = $id;
		if (!$this->File->exists($id)) {
			throw new NotFoundException(__('Invalid file'));
		}
		$this->File->setLanguage(Configure::read('Config.language'));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Translator->init($this->File, $this->request->data);
			if ($this->Translator->validate()) {
				$this->Translator->save();
				$this->Session->setFlash(__('The file has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			}
		} else {
			$options = array('conditions' => array('File.' . $this->File->primaryKey => $id));
			$this->request->data = $this->Translator->findFirst($this->File, $options);
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
		$this->File->id = $id;
		if (!$this->File->exists()) {
			throw new NotFoundException(__('Invalid file'));
		}
		if ($this->File->delete()) {
			$this->Session->setFlash(__('File deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('File was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
}