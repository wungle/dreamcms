<?php
App::uses('DreamCmsAppController', 'DreamCms.Controller');
/**
 * CmsMenus Controller
 *
 * @property CmsMenu $CmsMenu
 * @property PaginatorComponent $Paginator
 */
class CmsMenusController extends DreamCmsAppController {

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
		$this->DataFinder->setupModel($this->CmsMenu);
		$this->DataFinder->setupConditions();

		$this->CmsMenu->recursive = 0;
		$this->set('cmsMenus', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CmsMenu->exists($id)) {
			throw new NotFoundException(__('Invalid cms menu'));
		}
		$options = array('conditions' => array('CmsMenu.' . $this->CmsMenu->primaryKey => $id));
		$this->set('cmsMenu', $this->CmsMenu->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CmsMenu->create();
			if ($this->CmsMenu->save($this->request->data)) {
				$this->Session->setFlash(__('The cms menu has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cms menu could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$parentCmsMenus = $this->CmsMenu->ParentCmsMenu->find('list');
		$this->set(compact('parentCmsMenus'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->CmsMenu->id = $id;
		if (!$this->CmsMenu->exists($id)) {
			throw new NotFoundException(__('Invalid cms menu'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CmsMenu->save($this->request->data)) {
				$this->Session->setFlash(__('The cms menu has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cms menu could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('CmsMenu.' . $this->CmsMenu->primaryKey => $id));
			$this->request->data = $this->CmsMenu->find('first', $options);
		}
		$parentCmsMenus = $this->CmsMenu->ParentCmsMenu->find('list');
		$this->set(compact('parentCmsMenus'));
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
		$this->CmsMenu->id = $id;
		if (!$this->CmsMenu->exists()) {
			throw new NotFoundException(__('Invalid cms menu'));
		}
		if ($this->CmsMenu->delete()) {
			$this->Session->setFlash(__('Cms menu deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Cms menu was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}}
