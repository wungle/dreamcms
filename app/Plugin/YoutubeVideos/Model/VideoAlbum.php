<?php
App::uses('YoutubeVideosAppModel', 'YoutubeVideos.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
App::uses('TreeBehavior', 'Model.Behavior');
App::uses('TranslateBehavior', 'Model.Behavior');
App::uses('LogableBehavior', 'Dreamcms.Model.Behavior');
/**
 * VideoAlbum Model
 *
 * @property VideoAlbum $ParentVideoAlbum
 * @property VideoAlbum $ChildVideoAlbum
 * @property Video $Video
 */
class VideoAlbum extends CacheableModel {

/**
 * Act as
 *
 * @var array
 */
	public $actsAs = array(
		'Tree',
		'Translate' => array(
			'name' => 'videoAlbumNameTranslation',
			'description' => 'videoAlbumDescriptionTranslation'
		),
		//'Dreamcms.Logable'
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
	public $translateModel = "YoutubeVideos.VideoAlbumI18n";

/**
 * Translate table
 *
 * @var string
 */
	public $translateTable = "video_album_i18n";

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
		'ParentVideoAlbum' => array(
			'className' => 'VideoAlbum',
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
		'ChildVideoAlbum' => array(
			'className' => 'VideoAlbum',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => array('ChildVideoAlbum.published' => 'Yes', 'ChildVideoAlbum.deleted' => '0'),
			'fields' => '',
			'order' => 'ChildVideoAlbum.id DESC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Video' => array(
			'className' => 'Video',
			'foreignKey' => 'video_album_id',
			'dependent' => false,
			'conditions' => array('Video.published' => 'Yes', 'Video.deleted' => 0),
			'fields' => '',
			'order' => 'Video.id DESC',
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

	public function getFirstVideoAlbum($conditions = array())
	{
		return $this->find(
			'first',
			array(
				'conditions' => $conditions,
				'order' => $this->alias . '.lft ASC',
				'limit' => 1
			)
		);
	}

	public function findOneById($id, $conditions = array())
	{
		$conditions = Set::merge($conditions, array($this->alias . '.id' => intval($id)));
		return $this->find(
			'first',
			array(
				'conditions' => $conditions,
				'order' => $this->alias . '.id ASC',
				'limit' => 1
			)
		);
	}

}
