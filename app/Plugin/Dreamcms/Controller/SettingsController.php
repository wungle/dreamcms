<?php
App::uses('DreamcmsAppController', 'Dreamcms.Controller');
/**
 * Settings Controller
 *
 * @property Setting $Setting
 * @property PaginatorComponent $Paginator
 */
class SettingsController extends DreamcmsAppController {

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
	public $logableModel = 'Setting';

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
		$this->DataFinder->setupModel($this->Setting);
		$this->DataFinder->setupConditions();

		$this->Setting->recursive = 0;
		$this->set('settings', $this->paginate());
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
		if (!$this->Setting->exists($id)) {
			throw new NotFoundException(__('Invalid setting'));
		}
		$options = array('conditions' => array('Setting.' . $this->Setting->primaryKey => $id));
		$setting = $this->Setting->find('first', $options);
		if (!$setting)
			throw new NotFoundException(__('Invalid setting'));
		$this->set('setting', $setting);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->DreamcmsAcl->authorize();
		if ($this->request->is('post')) {
			$this->Setting->create();
			if ($this->Setting->save($this->request->data)) {
				$this->Session->setFlash(__('The setting has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The setting could not be saved. Please, try again.'), 'flash/error');
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
		$this->DreamcmsAcl->authorize();
        $this->Setting->id = $id;
		if (!$this->Setting->exists($id)) {
			throw new NotFoundException(__('Invalid setting'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Setting->save($this->request->data)) {
				$this->Session->setFlash(__('The setting has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The setting could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('Setting.' . $this->Setting->primaryKey => $id));
			$this->request->data = $this->Setting->find('first', $options);

			if (!$this->request->data)
				throw new NotFoundException(__('Invalid language'));
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
		$this->Setting->id = $id;
		if (!$this->Setting->exists()) {
			throw new NotFoundException(__('Invalid setting'));
		}

		$setting = $this->Setting->find('first', array('fields' => array('Setting.id', 'Setting.deleted'), 'conditions' => array('Setting.id' => $id)));
		if (!$setting)
			throw new NotFoundException(__('Invalid setting'));

		if ((Configure::read('DreamCMS.permanent_delete') == 'Yes') && $this->Setting->delete()) {
			$this->Session->setFlash(__('Setting deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		elseif (Configure::read('DreamCMS.permanent_delete') == 'No') {
			$setting['Setting']['deleted'] = '1';
			$this->Setting->create($setting);
			$this->Setting->save($setting);
			$this->Session->setFlash(__('Setting deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Setting was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}}
