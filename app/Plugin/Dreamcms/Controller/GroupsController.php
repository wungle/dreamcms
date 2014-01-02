<?php
App::uses('DreamcmsAppController', 'Dreamcms.Controller');
/**
 * Groups Controller
 *
 * @property Group $Group
 * @property PaginatorComponent $Paginator
 */
class GroupsController extends DreamcmsAppController {

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
		$this->DataFinder->setupModel($this->Group);
		$this->DataFinder->setupConditions();

		$this->Group->recursive = 0;
		$paginate = $this->paginate;
		$paginate['conditions'] = array('Group.deleted' => '0');
		$this->paginate = $paginate;
		$this->set('groups', $this->paginate());
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
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
		}
		$options = array('conditions' => array('Group.deleted' => '0', 'Group.' . $this->Group->primaryKey => $id));
		$group = $this->Group->find('first', $options);
		if (!$group)
			throw new NotFoundException(__('Invalid group'));
		$this->set('group', $group);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->DreamcmsAcl->authorize();
		if ($this->request->is('post')) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$this->DreamcmsAcl->saveAcl($this->request->data, array('Group' => array('id' => $this->Group->id)));
				$this->Session->setFlash(__('The group has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.'), 'flash/error');
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
        $this->Group->id = $id;
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Group->save($this->request->data)) {
				$this->DreamcmsAcl->saveAcl($this->request->data);
				$this->Session->setFlash(__('The group has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('Group.deleted' => '0', 'Group.' . $this->Group->primaryKey => $id));
			$data = $this->Group->find('first', $options);
			if (!$data)
				throw new NotFoundException(__('Invalid group'));
			$data = Set::merge($data, $this->DreamcmsAcl->getGroupAcl($data));

			$this->request->data = $data;
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
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}

		$group = $this->Group->find('first', array('fields' => array('Group.id', 'Group.deleted'), 'conditions' => array('Group.id' => $id, 'Group.deleted' => '0')));
		if (!$group)
			throw new NotFoundException(__('Invalid group'));


		if ((Configure::read('DreamCMS.permanent_delete') == 'Yes') && $this->Group->delete()) {
			$this->Session->setFlash(__('Group deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		elseif (Configure::read('DreamCMS.permanent_delete') == 'No') {
			$group['Group']['deleted'] = '1';
			$this->Group->create($group);
			$this->Group->save($group);
			$this->Session->setFlash(__('Group deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Group was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}}
