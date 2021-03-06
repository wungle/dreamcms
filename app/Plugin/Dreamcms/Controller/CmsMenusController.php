<?php
App::uses('DreamcmsAppController', 'Dreamcms.Controller');
/**
 * CmsMenus Controller
 *
 * @property CmsMenu $CmsMenu
 * @property PaginatorComponent $Paginator
 */
class CmsMenusController extends DreamcmsAppController {

/**
 * Uses
 *
 * @var array
 */
	public $uses = array(
		'Dreamcms.CmsMenu',
		'Dreamcms.Icon'
	);

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
	public $logableModel = 'CmsMenu';

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
		$this->DreamcmsAcl->authorize();
		if (!$this->CmsMenu->exists($id)) {
			throw new NotFoundException(__('Invalid cms menu'));
		}
		$options = array('conditions' => array('CmsMenu.' . $this->CmsMenu->primaryKey => $id));
		$cmsMenu = $this->CmsMenu->find('first', $options);
		if (!$cmsMenu)
			throw new NotFoundException(__('Invalid cms menu'));
		$this->set('cmsMenu', $cmsMenu);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->DreamcmsAcl->authorize();
		if ($this->request->is('post')) {
			$this->CmsMenu->create();
			if ($this->CmsMenu->save($this->request->data)) {
				$this->Session->setFlash(__('The cms menu has been saved'), 'flash/success');
				$this->DreamcmsAcl->allowNewAcoFromAllAro(array('CmsMenu' => array('id' => $this->CmsMenu->id)));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cms menu could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$parentCmsMenus = $this->CmsMenu->find(
			'list',
			array(
				'fields' => array('CmsMenu.id', 'CmsMenu.name'),
				'conditions' => array(
					'CmsMenu.parent_id' => '0',
					'CmsMenu.published' => 'Yes'
				),
				'order' => 'CmsMenu.name ASC'
			)
		);
		$parentCmsMenus = Set::merge(array('0' => 'No Parent'), $parentCmsMenus);
		$this->set(compact('parentCmsMenus'));
		$this->set('iconList', $this->Icon->getIconList());
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
			if (!$this->request->data)
				throw new NotFoundException(__('Invalid cms menu'));
		}
		$parentCmsMenus = $this->CmsMenu->find(
			'list',
			array(
				'fields' => array('CmsMenu.id', 'CmsMenu.name'),
				'conditions' => array(
					'CmsMenu.parent_id' => '0',
					'CmsMenu.published' => 'Yes',
					'CmsMenu.id !=' => $this->request->data['CmsMenu']['id']
				),
				'order' => 'CmsMenu.name ASC'
			)
		);
		$parentCmsMenus = Set::merge(array(0 => 'No Parent'), $parentCmsMenus);
		$this->set(compact('parentCmsMenus'));
		$this->set('iconList', $this->Icon->getIconList());
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
		$this->CmsMenu->id = $id;
		if (!$this->CmsMenu->exists()) {
			throw new NotFoundException(__('Invalid cms menu'));
		}

		$cmsMenu = $this->CmsMenu->find('first', array('fields' => array('CmsMenu.id', 'CmsMenu.deleted'), 'conditions' => array('CmsMenu.id' => $id)));
		if (!$cmsMenu)
			throw new NotFoundException(__('Invalid cms menu'));

		if ((Configure::read('DreamCMS.permanent_delete') == 'Yes') && $this->CmsMenu->delete()) {
			$this->Session->setFlash(__('Cms menu deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		elseif (Configure::read('DreamCMS.permanent_delete') == 'No') {
			$cmsMenu['CmsMenu']['deleted'] = '1';
			$this->CmsMenu->create($cmsMenu);
			$this->CmsMenu->save($cmsMenu);
			$this->Session->setFlash(__('Cms menu deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Cms menu was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
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

		$parentCmsMenus = $this->CmsMenu->find(
			'list',
			array(
				'fields' => array('CmsMenu.id', 'CmsMenu.name'),
				'conditions' => array(
					'CmsMenu.parent_id' => '0',
					'CmsMenu.published' => 'Yes'
				),
				'order' => 'CmsMenu.name ASC'
			)
		);
		$parentCmsMenus = Set::merge(array('0' => 'No Parent'), $parentCmsMenus);
		$this->set(compact('parentCmsMenus'));
		$this->set('iconList', $this->Icon->getIconList());
	}

}
