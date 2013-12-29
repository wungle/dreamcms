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
 * index method
 *
 * @return void
 */
	public function index() {
		/******************************************
		 * Data Finder Setup
		 ******************************************/
		$this->DataFinder->setupModel($this->WebMenu);
		$this->DataFinder->setupConditions();

		$this->WebMenu->setLanguage(Configure::read('Config.language'));
		$this->WebMenu->recursive = 0;
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
		if (!$this->WebMenu->exists($id)) {
			throw new NotFoundException(__('Invalid web menu'));
		}
		$this->WebMenu->setLanguage(Configure::read('Config.language'));
		$options = array('conditions' => array('WebMenu.' . $this->WebMenu->primaryKey => $id));
		$this->set('webMenu', $this->WebMenu->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->WebMenu->setLanguage(Configure::read('Config.language'));
		if ($this->request->is('post')) {
			$this->Translator->init($this->WebMenu, $this->request->data);
			if ($this->Translator->validate()) {
				$this->Translator->save();
				$this->Session->setFlash(__('The web menu has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			}
		}
		$this->set('parentWebMenus', $this->WebMenu->generateTreeList());
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->WebMenu->id = $id;
		if (!$this->WebMenu->exists($id)) {
			throw new NotFoundException(__('Invalid web menu'));
		}
		$this->WebMenu->setLanguage(Configure::read('Config.language'));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Translator->init($this->WebMenu, $this->request->data);
			if ($this->Translator->validate()) {
				$this->Translator->save();
				$this->Session->setFlash(__('The web menu has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			}
		} else {
			$options = array('conditions' => array('WebMenu.' . $this->WebMenu->primaryKey => $id));
			//$this->request->data = $this->WebMenu->find('first', $options);
			$this->request->data = $this->Translator->findFirst($this->WebMenu, $options);
		}
		$this->set('parentWebMenus', $this->WebMenu->generateTreeList());
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
		$this->WebMenu->id = $id;
		if (!$this->WebMenu->exists()) {
			throw new NotFoundException(__('Invalid web menu'));
		}
		if ($this->WebMenu->delete()) {
			$this->Session->setFlash(__('Web menu deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Web menu was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}}
