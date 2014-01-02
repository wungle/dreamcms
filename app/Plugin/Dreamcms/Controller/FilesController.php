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

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->loadModel('Dreamcms.File');
		$this->loadModel('Dreamcms.FileType');

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
		$this->DataFinder->setupModel($this->File);
		$this->DataFinder->setupConditions();

		$this->File->setLanguage(Configure::read('Config.language'));
		$this->File->recursive = 0;
		
		$paginate = $this->paginate;
		$paginate['fields'] = array(
			'File.id', 'File.file_type_id', 'File.name', 'File.url', 'File.priority', 'File.published', 
			'File.deleted', 'File.created', 'File.modified', 'FileType.id', 'FileType.parent_id', 'FileType.name'
		);
		$paginate['conditions'] = Set::merge(array('File.deleted' => '0'), $this->Routeable->getAssociatedFindConditions('File.file_type_id'));
		$this->paginate = $paginate;

		$this->File->bindModel(array('belongsTo' => array('FileType')));
		$this->set('files', $this->paginate($this->File));
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
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->File->setLanguage(Configure::read('Config.language'));

		$conditions = Set::merge(array('File.' . $this->File->primaryKey => $id, 'File.deleted' => '0'), $this->Routeable->getAssociatedFindConditions('File.file_type_id'));
		$options = array('conditions' => $conditions);
		$file = $this->File->find('first', $options);
		if (!$file) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->set('file', $file);
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
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' has been saved'), 'flash/success');
				$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
			}
		}
		$fileTypes = $this->FileType->generateTreeList(Set::merge(array('FileType.deleted' => '0'), $this->Routeable->getTreeListConditions()));
		$this->set('fileTypes', $fileTypes);
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
		$fileTypes = $this->FileType->generateTreeList(Set::merge(array('FileType.deleted' => '0'), $this->Routeable->getTreeListConditions()));
		$this->set('fileTypes', $fileTypes);
        $this->File->id = $id;
		if (!$this->File->exists($id)) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->File->setLanguage(Configure::read('Config.language'));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Translator->init($this->File, $this->request->data);
			if ($this->Translator->validate()) {
				$this->Translator->save();
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' has been saved'), 'flash/success');
				$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
			}
		} else {
			$options = array('conditions' => Set::merge(array('File.' . $this->File->primaryKey => $id, 'File.deleted' => '0'), $this->Routeable->getAssociatedFindConditions('File.file_type_id')));
			$this->request->data = $this->Translator->findFirst($this->File, $options);
			if (!$this->request->data)
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
		$this->File->id = $id;
		if (!$this->File->exists()) {
			throw new NotFoundException(__('Invalid ' .  strtolower($this->Routeable->singularize)));
		}

		$file = $this->File->find('first', array('fields' => array('File.id', 'File.deleted'), 'conditions' => array('File.id' => $id, 'File.deleted' => '0')));
		if (!$file)
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));

		if ((Configure::read('DreamCMS.permanent_delete') == 'Yes') && $this->File->delete()) {
			$this->Session->setFlash(__($this->Routeable->singularize . ' deleted'), 'flash/success');
			$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
		}
		elseif (Configure::read('DreamCMS.permanent_delete') == 'No') {
			$file['File']['deleted'] = '1';
			$this->File->create($file);
			$this->File->save($file);
			$this->Session->setFlash(__($this->Routeable->singularize . ' deleted'), 'flash/success');
			$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
		}
		$this->Session->setFlash(__($this->Routeable->singularize . ' was not deleted'), 'flash/error');
		$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
	}
}