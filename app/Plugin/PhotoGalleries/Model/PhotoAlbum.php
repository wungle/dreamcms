<?php
App::uses('PhotoGalleriesAppModel', 'PhotoGalleries.Model');
App::uses('TreeBehavior', 'Model.Behavior');
App::uses('TranslateBehavior', 'Model.Behavior');
/**
 * PhotoAlbum Model
 *
 * @property PhotoAlbum $ParentPhotoAlbum
 * @property PhotoAlbum $ChildPhotoAlbum
 * @property Photo $Photo
 */
class PhotoAlbum extends PhotoGalleriesAppModel {

/**
 * Act as
 *
 * @var array
 */
	public $actsAs = array(
		'Tree',
		'Translate' => array(
			'name' => 'photoAlbumNameTranslation',
			'description' => 'photoAlbumDescriptionTranslation'
		)
	);

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Translate model
 *
 * @var string
 */
	public $translateModel = "PhotoGalleries.PhotoAlbumI18n";

/**
 * Translate table
 *
 * @var string
 */
	public $translateTable = "photo_album_i18n";

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'Name has to be at least 3 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'maxLength' => array(
				'rule' => array('maxLength', 64),
				'message' => 'Name can not be exceeded 64 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Name can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'description' => array(
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'Description has to be at least 3 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'maxLength' => array(
				'rule' => array('maxLength', 255),
				'message' => 'Description can not be exceeded 255 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Description can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'published' => array(
			'inList' => array(
				'rule' => array('inList', array('Yes', 'No')),
				'message' => 'Please provide a valid published value.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Published can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'deleted' => array(
			'inList' => array(
				'rule' => array('inList', array('0', '1')),
				'message' => 'Please provide a valid deleted value.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ParentPhotoAlbum' => array(
			'className' => 'PhotoAlbum',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ChildPhotoAlbum' => array(
			'className' => 'PhotoAlbum',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => array('ChildPhotoAlbum.published' => 'Yes', 'ChildPhotoAlbum.deleted' => '0'),
			'fields' => '',
			'order' => 'ChildPhotoAlbum.id DESC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Photo' => array(
			'className' => 'Photo',
			'foreignKey' => 'photo_album_id',
			'dependent' => false,
			'conditions' => array('Photo.published' => 'Yes', 'Photo.deleted' => 0),
			'fields' => '',
			'order' => 'Photo.id DESC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function setLanguage($locale)
	{
		$this->locale = $locale;
	}

	public function getFirstPhotoAlbum($conditions = array())
	{
		$conditions = Set::merge($conditions, array('PhotoAlbum.deleted' => '0'));
		return $this->find(
			'first',
			array(
				'conditions' => $conditions,
				'order' => 'PhotoAlbum.lft ASC',
				'limit' => 1
			)
		);
	}

	public function findOneById($id, $conditions = array())
	{
		$conditions = Set::merge($conditions, array('PhotoAlbum.deleted' => '0', 'PhotoAlbum.id' => intval($id)));
		return $this->find(
			'first',
			array(
				'conditions' => $conditions,
				'order' => 'PhotoAlbum.id ASC',
				'limit' => 1
			)
		);
	}

}
