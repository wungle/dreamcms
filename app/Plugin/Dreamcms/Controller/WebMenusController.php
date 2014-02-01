<?php
App::uses('DreamcmsAppController', 'Dreamcms.Controller');
/**
 * WebMenus Controller
 *
 * @property WebMenu $WebMenu
 * @property PaginatorComponent $Paginator
 */
class WebMenusController extends DreamcmsAppController {

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
	public $logableModel = 'WebMenu';

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Routeable->setParentModel($this->WebMenu);
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
		$this->DataFinder->setupModel($this->WebMenu);
		$this->DataFinder->setupConditions();

		$this->WebMenu->setLanguage(Configure::read('Config.language'));
		$this->WebMenu->recursive = 0;
		$paginate = $this->paginate;
		$paginate['conditions'] = $this->Routeable->getFindConditions();
		$this->paginate = $paginate;
		$this->set('webMenus', $this->paginate());
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
		if (!$this->WebMenu->exists($id)) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->WebMenu->setLanguage(Configure::read('Config.language'));
		$conditions = Set::merge(array('WebMenu.' . $this->WebMenu->primaryKey => $id), $this->Routeable->getFindConditions());
		$options = array('conditions' => $conditions);
		$webMenu = $this->WebMenu->find('first', $options);
		if (!$webMenu) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->set('webMenu', $webMenu);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->DreamcmsAcl->authorize();
		$this->WebMenu->setLanguage(Configure::read('Config.language'));
		if ($this->request->is('post')) {
			$this->Translator->init($this->WebMenu, $this->request->data);
			if ($this->Translator->validate()) {
				$this->Translator->save();
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' has been saved'), 'flash/success');
				$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
			}
		}
		$parentWebMenus = $this->WebMenu->generateTreeList($this->Routeable->getTreeListConditions());
		$this->set('parentWebMenus', $parentWebMenus);
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
        $this->WebMenu->id = $id;
		if (!$this->WebMenu->exists($id)) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->WebMenu->setLanguage(Configure::read('Config.language'));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Translator->init($this->WebMenu, $this->request->data);
			if ($this->Translator->validate()) {
				$this->Translator->save();
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' has been saved'), 'flash/success');
				$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
			}
		} else {
			$options = array('conditions' => Set::merge(array('WebMenu.' . $this->WebMenu->primaryKey => $id), $this->Routeable->getFindConditions()));
			$this->request->data = $this->Translator->findFirst($this->WebMenu, $options);
			if (!$this->request->data)
				throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$parentWebMenus = $this->WebMenu->generateTreeList($this->Routeable->getTreeListConditions());
		$this->set('parentWebMenus', $parentWebMenus);
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
		$this->WebMenu->id = $id;
		if (!$this->WebMenu->exists()) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$webMenu = $this->WebMenu->find('first', array('fields' => array('WebMenu.id', 'WebMenu.deleted'), 'conditions' => array('WebMenu.id' => $id)));
		if (!$webMenu)
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));

		if ((Configure::read('DreamCMS.permanent_delete') == 'Yes') && $this->WebMenu->delete()) {
			$this->Session->setFlash(__($this->Routeable->singularize . ' deleted'), 'flash/success');
			$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
		}
		elseif (Configure::read('DreamCMS.permanent_delete') == 'No') {
			$webMenu['WebMenu']['deleted'] = '1';
			$this->WebMenu->create($webMenu);
			$this->WebMenu->save($webMenu);
			$this->Session->setFlash(__($this->Routeable->singularize . ' deleted'), 'flash/success');
			$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
		}
		$this->Session->setFlash(__($this->Routeable->singularize . ' was not deleted'), 'flash/error');
		$this->redirect(array('controller' => $this->Routeable->currentController, 'action' => 'index'));
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

		$parentWebMenus = $this->WebMenu->generateTreeList($this->Routeable->getTreeListConditions());
		$this->set('parentWebMenus', $parentWebMenus);
	}
}
