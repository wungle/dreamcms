<?php
App::uses('PhotoGalleriesAppController', 'PhotoGalleries.Controller');
/**
 * PhotoAlbums Controller
 *
 * @property PhotoAlbum $PhotoAlbum
 * @property PaginatorComponent $Paginator
 */
class PhotoAlbumsController extends PhotoGalleriesAppController {

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
	public $logableModel = 'PhotoAlbum';

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Routeable->setParentModel($this->PhotoAlbum);
	}

/**
 * index method
 *
 * @return void
 */
	public function dreamcms_index() {
		$this->DreamcmsAcl->authorize();
		/******************************************
		 * Data Finder Setup
		 ******************************************/
		$this->DataFinder->setupModel($this->PhotoAlbum);
		$this->DataFinder->setupConditions();

		$this->PhotoAlbum->setLanguage(Configure::read('Config.language'));
		$this->PhotoAlbum->recursive = 0;
		$paginate = $this->paginate;
		$paginate['conditions'] = $this->Routeable->getFindConditions();
		$this->paginate = $paginate;
		$this->set('photoAlbums', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function dreamcms_view($id = null) {
		$this->DreamcmsAcl->authorize();
		if (!$this->PhotoAlbum->exists($id)) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->PhotoAlbum->setLanguage(Configure::read('Config.language'));
		$conditions = Set::merge(array('PhotoAlbum.' . $this->PhotoAlbum->primaryKey => $id), $this->Routeable->getFindConditions());
		$options = array('conditions' => $conditions);
		$photoAlbum = $this->PhotoAlbum->find('first', $options);
		if (!$photoAlbum) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->set('photoAlbum', $photoAlbum);
	}

/**
 * add method
 *
 * @return void
 */
	public function dreamcms_add() {
		$this->DreamcmsAcl->authorize();
		$this->PhotoAlbum->setLanguage(Configure::read('Config.language'));
		if ($this->request->is('post')) {
			$this->Translator->init($this->PhotoAlbum, $this->request->data);
			if ($this->Translator->validate()) {
				$this->Translator->save();
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' has been saved'), 'flash/success');
				$this->redirect(array('plugin' => $this->Routeable->currentPlugin, 'controller' => $this->Routeable->currentController, 'action' => 'index'));
			}
		}
		$parentPhotoAlbums = $this->PhotoAlbum->generateTreeList($this->Routeable->getTreeListConditions());
		$this->set('parentPhotoAlbums', $parentPhotoAlbums);
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function dreamcms_edit($id = null) {
		$this->DreamcmsAcl->authorize();
        $this->PhotoAlbum->id = $id;
		if (!$this->PhotoAlbum->exists($id)) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->PhotoAlbum->setLanguage(Configure::read('Config.language'));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Translator->init($this->PhotoAlbum, $this->request->data);
			if ($this->Translator->validate()) {
				$this->Translator->save();
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' has been saved'), 'flash/success');
				$this->redirect(array('plugin' => $this->Routeable->currentPlugin, 'controller' => $this->Routeable->currentController, 'action' => 'index'));
			}
		} else {
			$options = array('conditions' => Set::merge(array('PhotoAlbum.' . $this->PhotoAlbum->primaryKey => $id), $this->Routeable->getFindConditions()));
			$this->request->data = $this->Translator->findFirst($this->PhotoAlbum, $options);
			if (!$this->request->data)
				throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$parentPhotoAlbums = $this->PhotoAlbum->generateTreeList($this->Routeable->getTreeListConditions());
		$this->set('parentPhotoAlbums', $parentPhotoAlbums);
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function dreamcms_delete($id = null) {
		$this->DreamcmsAcl->authorize();
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->PhotoAlbum->id = $id;
		if (!$this->PhotoAlbum->exists()) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}

		$photoAlbum = $this->PhotoAlbum->find('first', array('fields' => array('PhotoAlbum.id', 'PhotoAlbum.deleted'), 'conditions' => array('PhotoAlbum.id' => $id)));
		if (!$photoAlbum)
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));

		if ((Configure::read('DreamCMS.permanent_delete') == 'Yes') && $this->PhotoAlbum->delete()) {
			$this->Session->setFlash(__($this->Routeable->singularize . ' deleted'), 'flash/success');
			$this->redirect(array('plugin' => $this->Routeable->currentPlugin, 'controller' => $this->Routeable->currentController, 'action' => 'index'));
		}
		elseif (Configure::read('DreamCMS.permanent_delete') == 'No') {
			$photoAlbum['PhotoAlbum']['deleted'] = '1';
			$this->PhotoAlbum->create($photoAlbum);
			$this->PhotoAlbum->save($photoAlbum);
			$this->Session->setFlash(__($this->Routeable->singularize . ' deleted'), 'flash/success');
			$this->redirect(array('plugin' => $this->Routeable->currentPlugin, 'controller' => $this->Routeable->currentController, 'action' => 'index'));
		}
		$this->Session->setFlash(__($this->Routeable->singularize . ' was not deleted'), 'flash/error');
		$this->redirect(array('plugin' => $this->Routeable->currentPlugin, 'controller' => $this->Routeable->currentController, 'action' => 'index'));
	}

/**
 * trace method
 *
 * @throws NotFoundException
 * @param string $record_id
 * @param string $log_id
 * @return void
 */
	public function dreamcms_trace($record_id, $log_id)
	{
		parent::dreamcms_trace($record_id, $log_id);

		$parentPhotoAlbums = $this->PhotoAlbum->generateTreeList($this->Routeable->getTreeListConditions());
		$this->set('parentPhotoAlbums', $parentPhotoAlbums);
	}
}
