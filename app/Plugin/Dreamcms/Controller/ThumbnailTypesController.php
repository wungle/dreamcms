<?php
App::uses('DreamcmsAppController', 'Dreamcms.Controller');
/**
 * ThumbnailTypes Controller
 *
 * @property ThumbnailType $ThumbnailType
 * @property PaginatorComponent $Paginator
 */
class ThumbnailTypesController extends DreamcmsAppController {

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
	public $logableModel = 'ThumbnailType';

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
		$this->DataFinder->setupModel($this->ThumbnailType);
		$this->DataFinder->setupConditions();

		$this->ThumbnailType->recursive = 0;
		$this->set('thumbnailTypes', $this->paginate());
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
		if (!$this->ThumbnailType->exists($id)) {
			throw new NotFoundException(__('Invalid thumbnail type'));
		}
		$options = array('conditions' => array('ThumbnailType.' . $this->ThumbnailType->primaryKey => $id));
		$thumbnailType = $this->ThumbnailType->find('first', $options);
		if (!$thumbnailType)
			throw new NotFoundException(__('Invalid thumbnail type'));
		$this->set('thumbnailType', $thumbnailType);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->DreamcmsAcl->authorize();
		if ($this->request->is('post')) {
			$this->ThumbnailType->create();
			if ($this->ThumbnailType->save($this->request->data)) {
				$this->Session->setFlash(__('The thumbnail type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The thumbnail type could not be saved. Please, try again.'), 'flash/error');
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
        $this->ThumbnailType->id = $id;
		if (!$this->ThumbnailType->exists($id)) {
			throw new NotFoundException(__('Invalid thumbnail type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ThumbnailType->save($this->request->data)) {
				$this->Session->setFlash(__('The thumbnail type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The thumbnail type could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('ThumbnailType.' . $this->ThumbnailType->primaryKey => $id));
			$this->request->data = $this->ThumbnailType->find('first', $options);

			if (!$this->request->data)
				throw new NotFoundException(__('Invalid thumbnail type'));
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
		$this->ThumbnailType->id = $id;
		if (!$this->ThumbnailType->exists()) {
			throw new NotFoundException(__('Invalid thumbnail type'));
		}

		$thumbnailType = $this->ThumbnailType->find('first', array('fields' => array('ThumbnailType.id', 'ThumbnailType.deleted'), 'conditions' => array('ThumbnailType.id' => $id)));
		if (!$thumbnailType)
			throw new NotFoundException(__('Invalid thumbnail type'));

		if ((Configure::read('DreamCMS.permanent_delete') == 'Yes') && $this->ThumbnailType->delete()) {
			$this->Session->setFlash(__('Thumbnail type deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		elseif (Configure::read('DreamCMS.permanent_delete') == 'No') {
			$thumbnailType['ThumbnailType']['deleted'] = '1';
			$this->ThumbnailType->create($thumbnailType);
			$this->ThumbnailType->save($thumbnailType);
			$this->Session->setFlash(__('Thumbnail type deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Thumbnail type was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}}
