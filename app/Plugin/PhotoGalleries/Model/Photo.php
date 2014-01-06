<?php
App::uses('PhotoGalleriesAppModel', 'PhotoGalleries.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
App::uses('ThumbnailableBehavior', 'Dreamcms.Model.Behavior');
App::uses('TranslateBehavior', 'Model.Behavior');
App::uses('UploadableBehavior', 'Dreamcms.Model.Behavior');
/**
 * Photo Model
 *
 * @property PhotoAlbum $PhotoAlbum
 */
class Photo extends CacheableModel {

/**
 * Act as
 *
 * @var array
 */
	public $actsAs = array(
		'Dreamcms.Uploadable' => array(
			/**
				savePath have to be inside of the WWW_ROOT directory
				ex : /files/uploads/
				the exact savePath would be WWW_ROOT/files/uploads/
			**/
			//'savePath' => 'path-to-save-the-uploaded-files',
 			'fields' => array('filename')
		),
		'Dreamcms.Thumbnailable' => array(
			/**
				savePath have to be inside of the WWW_ROOT directory
				ex : /files/thumbnails/
				the exact savePath would be WWW_ROOT/files/thumbnails/
			**/
			//'savePath' => 'path-to-save-the-uploaded-files',
			'fields' => array(
				'filename' => 'Thumbnails'
			)
		),
		'Translate' => array(
			'name' => 'photoNameTranslation',
			'description' => 'photoDescriptionTranslation'
		)
	);

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Thumbnail model
 *
 * @var string
 */
	public $thumbnailModel = "PhotoGalleries.PhotoThumbnail";

/**
 * Thumbnail table
 *
 * @var string
 */
	public $thumbnailTable = "photo_thumbnails";

/**
 * Translate model
 *
 * @var string
 */
	public $translateModel = "PhotoGalleries.PhotoI18n";

/**
 * Translate table
 *
 * @var string
 */
	public $translateTable = "photo_i18n";

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
		'filename' => array(
			'extension' => array(
				'rule' => array('extension', array(
					'jpe', 'jpeg', 'jpg', 'png',
				)),
				'message' => 'The uploaded file type is not supported.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'fileSize' => array(
				'rule' => array('fileSize', '<=', '5MB'),
				'message' => 'Filesize can not be exceeded 5MB.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			/*
			'uploadError' => array(
				'rule' => array('uploadError'),
				'message' => 'Failed uploading the file.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			*/
			/*
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Photo can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			*/
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
		'PhotoAlbum' => array(
			'className' => 'PhotoAlbum',
			'foreignKey' => 'photo_album_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function setLanguage($locale)
	{
		$this->locale = $locale;
	}

	public function getFirstPhoto($conditions = array())
	{
		return $this->find(
			'first',
			array(
				'conditions' => $conditions,
				'order' => 'Photo.lft ASC',
				'limit' => 1
			)
		);
	}

	public function findOneById($id, $conditions = array())
	{
		$conditions = Set::merge($conditions, array('Photo.id' => intval($id)));
		return $this->find(
			'first',
			array(
				'conditions' => $conditions,
				'order' => 'Photo.id ASC',
				'limit' => 1
			)
		);
	}
}
