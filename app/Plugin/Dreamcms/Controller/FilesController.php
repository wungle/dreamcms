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
		'Dreamcms.Files',
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

		$this->loadModel('Dreamcms.Files');
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
		$this->DataFinder->setupModel($this->Files);
		$this->DataFinder->setupConditions();

		$this->Files->setLanguage(Configure::read('Config.language'));
		$this->Files->recursive = 0;
		
		$paginate = $this->paginate;
		$paginate['fields'] = array(
			'Files.id', 'Files.file_type_id', 'Files.name', 'Files.url', 'Files.priority', 'Files.published', 
			'Files.deleted', 'Files.created', 'Files.modified', 'FileType.id', 'FileType.parent_id', 'FileType.name'
		);
		$paginate['conditions'] = $this->Routeable->getAssociatedFindConditions('Files.file_type_id');
		$this->paginate = $paginate;

		$this->Files->bindModel(array('belongsTo' => array('FileType')));
		$this->set('files', $this->paginate($this->Files));
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
		if (!$this->Files->exists($id)) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->Files->setLanguage(Configure::read('Config.language'));

		$conditions = Set::merge(array('Files.' . $this->Files->primaryKey => $id), $this->Routeable->getAssociatedFindConditions('Files.file_type_id'));
		$options = array('conditions' => $conditions);
		$file = $this->Files->find('first', $options);
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
		$this->Files->setLanguage(Configure::read('Config.language'));
		if ($this->request->is('post')) {
			$this->Translator->init($this->Files, $this->request->data);
			if ($this->Translator->validate()) {
				$this->Translator->save();
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' has been saved'), 'flash/success');
				$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
			}
		}
		$fileTypes = $this->FileType->generateTreeList($this->Routeable->getTreeListConditions());
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
		$fileTypes = $this->FileType->generateTreeList($this->Routeable->getTreeListConditions());
		$this->set('fileTypes', $fileTypes);
        $this->Files->id = $id;
		if (!$this->Files->exists($id)) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->Files->setLanguage(Configure::read('Config.language'));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Translator->init($this->Files, $this->request->data);
			if ($this->Translator->validate()) {
				$this->Translator->save();
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' has been saved'), 'flash/success');
				$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
			}
		} else {
			$options = array('conditions' => Set::merge(array('Files.' . $this->Files->primaryKey => $id), $this->Routeable->getAssociatedFindConditions('Files.file_type_id')));
			$this->request->data = $this->Translator->findFirst($this->Files, $options);
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
		$this->Files->id = $id;
		if (!$this->Files->exists()) {
			throw new NotFoundException(__('Invalid ' .  strtolower($this->Routeable->singularize)));
		}

		$file = $this->Files->find('first', array('fields' => array('Files.id', 'Files.deleted'), 'conditions' => array('Files.id' => $id)));
		if (!$file)
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));

		if ((Configure::read('DreamCMS.permanent_delete') == 'Yes') && $this->Files->delete()) {
			$this->Session->setFlash(__($this->Routeable->singularize . ' deleted'), 'flash/success');
			$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
		}
		elseif (Configure::read('DreamCMS.permanent_delete') == 'No') {
			$file['Files']['deleted'] = '1';
			$this->Files->create($file);
			$this->Files->save($file);
			$this->Session->setFlash(__($this->Routeable->singularize . ' deleted'), 'flash/success');
			$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
		}
		$this->Session->setFlash(__($this->Routeable->singularize . ' was not deleted'), 'flash/error');
		$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
	}
}