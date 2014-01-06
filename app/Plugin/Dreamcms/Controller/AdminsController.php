<?php
App::uses('DreamcmsAppController', 'Dreamcms.Controller');
App::uses("Sanitize", "Utility");
/**
 * Admins Controller
 *
 * @property Admin $Admin
 * @property PaginatorComponent $Paginator
 */
class AdminsController extends DreamcmsAppController {

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
		$this->DataFinder->setupModel($this->Admin);
		$this->DataFinder->setupConditions();

		$this->Admin->recursive = 0;
		$this->set('admins', $this->paginate());
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
		if (!$this->Admin->exists($id)) {
			throw new NotFoundException(__('Invalid admin'));
		}
		$options = array('conditions' => array('Admin.' . $this->Admin->primaryKey => $id));
		$admin = $this->Admin->find('first', $options);
		if (!$admin)
			throw new NotFoundException(__('Invalid admin'));
		$this->set('admin', $admin);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->DreamcmsAcl->authorize();
		if ($this->request->is('post')) {
			$this->Admin->create();
			if ($this->Admin->save($this->request->data)) {
				$this->DreamcmsAcl->saveAcl($this->request->data, array('Admin' => array('id' => $this->Admin->id)));
				$this->Session->setFlash(__('The admin has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The admin could not be saved. Please, try again.'), 'flash/error');
			}
		}
		else
		{
			$first_group = $this->Group->getFirstGroup();
			$this->request->data = $this->DreamcmsAcl->getGroupAcl($first_group);
		}
		$groups = $this->Admin->Group->find('list');
		$this->set(compact('groups'));
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
        $this->Admin->id = $id;
		if (!$this->Admin->exists($id)) {
			throw new NotFoundException(__('Invalid admin'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Admin->save($this->request->data)) {
				$this->DreamcmsAcl->saveAcl($this->request->data);
				$this->Session->setFlash(__('The admin has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The admin could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('Admin.' . $this->Admin->primaryKey => $id));
			$data = $this->Admin->find('first', $options);

			if (!$data)
				throw new NotFoundException(__('Invalid admin'));

			unset($data['Admin']['password']);
			$data = Set::merge($data, $this->DreamcmsAcl->getAdminAcl($data));
			$this->request->data = $data;
		}
		$groups = $this->Admin->Group->find('list');
		$this->set(compact('groups'));
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
		$this->Admin->id = $id;
		if (!$this->Admin->exists()) {
			throw new NotFoundException(__('Invalid admin'));
		}

		$admin = $this->Admin->find('first', array('fields' => array('Admin.id', 'Admin.deleted'), 'conditions' => array('Admin.id' => $id)));
		if (!$admin)
			throw new NotFoundException(__('Invalid admin'));

		if ((Configure::read('DreamCMS.permanent_delete') == 'Yes') && $this->Admin->delete()) {
			$this->Session->setFlash(__('Admin deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		elseif (Configure::read('DreamCMS.permanent_delete') == 'No') {
			$admin['Admin']['deleted'] = '1';
			$this->Admin->create($admin);
			$this->Admin->save($admin);
			$this->Session->setFlash(__('Admin deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Admin was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

/**
 * reset_acl method
 *
 * @throws NotFoundException, ForbiddenException
 * @param string $group_id
 * @return void
 */
	public function reset_acl($group_id)
	{
		$this->DreamcmsAcl->authorize();
		if (!$this->request->is("ajax"))
			throw new ForbiddenException("Access forbidden");

		if (!$this->Group->exists($group_id))
			throw new NotFoundException(__('Invalid group'));

		$this->layout = 'blank';
		$group = $this->Group->findOneById(intval($group_id));
		
		$this->request->data = $this->DreamcmsAcl->getGroupAcl($group);
	}

/**
 * login method
 *
 * @throws NotFoundException
 * @param string $login_param
 * @return void
 */
	public function login($login_param = '')
	{
		if ($this->DreamcmsAuth->user())
			$this->redirect('/dreamcms');

		$this->layout = 'login';

		if ($this->data)
		{
			$this->data = Sanitize::clean($this->data);

			if ($this->Session->read('DreamCMS.simple_captcha_value') == $this->data['Admin']['captcha'])
			{
				if ($this->DreamcmsAuth->login())
				{
					if ($this->DreamcmsAuth->user('id'))
					{
						$this->Admin->id = $this->DreamcmsAuth->user('id');
						$this->Admin->saveField('last_login', date(DATE_ATOM));
						$this->Admin->saveField('last_login_ip', $this->request->clientIp());
					}
					$this->redirect('/dreamcms');
				}
				else
					$this->Session->setFlash(__('Invalid username or password.'), 'flash/error');
			}
			else
				$this->Session->setFlash(__('Invalid captcha validation code.'), 'flash/error');
		}
	}

/**
 * login method
 *
 * @return void
 */
	public function logout()
	{
		$this->DreamcmsAuth->logout();
		$this->redirect('/');
	}
}
