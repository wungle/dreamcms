<?php
App::uses('PhotoGalleriesAppController', 'PhotoGalleries.Controller');
/**
 * Photos Controller
 *
 * @property Photo $Photo
 * @property PaginatorComponent $Paginator
 */
class PhotosController extends PhotoGalleriesAppController {

/**
 * Uses
 *
 * @var array
 */
	public $uses = array(
		'PhotoGalleries.PhotoAlbum',
		'PhotoGalleries.Photo',
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
	public $logableModel = 'Photo';

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->loadModel('PhotoGalleries.PhotoAlbum');
		$this->loadModel('PhotoGalleries.Photo');

		$this->Routeable->setParentModel($this->PhotoAlbum);
	}

/**
 * dreamcms_index method
 *
 * @return void
 */
	public function dreamcms_index() {
		$this->DreamcmsAcl->authorize();
		/******************************************
		 * Data Finder Setup
		 ******************************************/
		$this->DataFinder->setupModel($this->Photo);
		$this->DataFinder->setupConditions();

		$this->Photo->setLanguage(Configure::read('Config.language'));
		$this->Photo->recursive = 0;
		
		$paginate = $this->paginate;
		$paginate['fields'] = array(
			'Photo.id', 'Photo.photo_album_id', 'Photo.name', 'Photo.description', 'Photo.published', 
			'Photo.deleted', 'Photo.created', 'Photo.modified', 'PhotoAlbum.id', 'PhotoAlbum.parent_id', 'PhotoAlbum.name'
		);
		$paginate['conditions'] = $this->Routeable->getAssociatedFindConditions('Photo.photo_album_id');
		$this->paginate = $paginate;

		$this->Photo->bindModel(array('belongsTo' => array('PhotoAlbum')));
		$this->set('photos', $this->paginate($this->Photo));
	}

/**
 * dreamcms_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function dreamcms_view($id = null) {
		$this->DreamcmsAcl->authorize();
		if (!$this->Photo->exists($id)) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->Photo->setLanguage(Configure::read('Config.language'));

		$conditions = Set::merge(array('Photo.' . $this->Photo->primaryKey => $id), $this->Routeable->getAssociatedFindConditions('Photo.photo_album_id'));
		$options = array('conditions' => $conditions);
		$photo = $this->Photo->find('first', $options);
		if (!$photo) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		$this->set('photo', $photo);
	}

/**
 * dreamcms_add method
 *
 * @return void
 */
	public function dreamcms_add() {
		$this->DreamcmsAcl->authorize();
		if ($this->request->is('post')) {
			$this->Translator->init($this->Photo, $this->request->data);
			if ($this->Translator->validate()) {
				$this->Translator->save();
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' has been saved'), 'flash/success');
				$this->redirect(array('plugin' => $this->Routeable->currentPlugin, 'controller' => $this->Routeable->currentController, 'action' => 'index'));
			}
		}
		$photoAlbums = $this->PhotoAlbum->generateTreeList($this->Routeable->getTreeListConditions());
		$this->set('photoAlbums', $photoAlbums);
	}

/**
 * dreamcms_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function dreamcms_edit($id = null) {
		$this->DreamcmsAcl->authorize();
		$photoAlbums = $this->PhotoAlbum->generateTreeList($this->Routeable->getTreeListConditions());
		$this->set('photoAlbums', $photoAlbums);
        $this->Photo->id = $id;
		if (!$this->Photo->exists($id)) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Translator->init($this->Photo, $this->request->data);
			if ($this->Translator->validate()) {
				$this->Translator->save();
				$this->Session->setFlash(__('The '. strtolower($this->Routeable->singularize) .' has been saved'), 'flash/success');
				$this->redirect(array('plugin' => $this->Routeable->currentPlugin, 'controller' => $this->Routeable->currentController, 'action' => 'index'));
			}
		} else {
			$options = array('conditions' => Set::merge(array('Photo.' . $this->Photo->primaryKey => $id), $this->Routeable->getAssociatedFindConditions('Photo.photo_album_id')));
			$this->request->data = $this->Translator->findFirst($this->Photo, $options);
			if (!$this->request->data)
				throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}
	}

/**
 * dreamcms_delete method
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
		$this->Photo->id = $id;
		if (!$this->Photo->exists()) {
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));
		}

		$photo = $this->Photo->find('first', array('fields' => array('Photo.id', 'Photo.deleted'), 'conditions' => array('Photo.id' => $id)));
		if (!$photo)
			throw new NotFoundException(__('Invalid ' . strtolower($this->Routeable->singularize)));


		if ((Configure::read('DreamCMS.permanent_delete') == 'Yes') && $this->Photo->delete()) {
			$this->Session->setFlash(__($this->Routeable->singularize . ' deleted'), 'flash/success');
			$this->redirect(array('plugin' => $this->Routeable->currentPlugin, 'controller' => $this->Routeable->currentController, 'action' => 'index'));
		}
		elseif (Configure::read('DreamCMS.permanent_delete') == 'No') {
			$photo['Photo']['deleted'] = '1';
			$this->Photo->create($photo);
			$this->Photo->save($photo);
			$this->Session->setFlash(__($this->Routeable->singularize . ' deleted'), 'flash/success');
			$this->redirect(array('plugin' => $this->Routeable->currentPlugin, 'controller' => $this->Routeable->currentController, 'action' => 'index'));
		}
		$this->Session->setFlash(__($this->Routeable->singularize . ' was not deleted'), 'flash/error');
		$this->redirect(array('plugin' => $this->Routeable->currentPlugin, 'controller' => $this->Routeable->currentController, 'action' => 'index'));
	}}
