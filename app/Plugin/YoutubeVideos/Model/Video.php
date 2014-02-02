<?php
App::uses('YoutubeVideosAppModel', 'YoutubeVideos.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
App::uses('ThumbnailableBehavior', 'Dreamcms.Model.Behavior');
App::uses('TranslateBehavior', 'Model.Behavior');
App::uses('LogableBehavior', 'Dreamcms.Model.Behavior');

/**
 * Video Model
 *
 * @property VideoAlbum $VideoAlbum
 */
class Video extends CacheableModel {

/**
 * Act as
 *
 * @var array
 */
	public $actsAs = array(
		//'Dreamcms.Logable',
		//'Dreamcms.Thumbnailable' => array(
		//	/**
		//		savePath have to be inside of the WWW_ROOT directory
		//		ex : /files/thumbnails/
		//		the exact savePath would be WWW_ROOT/files/thumbnails/
		//	**/
		//	//'savePath' => 'path-to-save-the-uploaded-files',
		//	'fields' => array(
		//		'screenshot' => 'Thumbnails'
		//	)
		//),
		'Translate' => array(
			'name' => 'videoNameTranslation',
			'description' => 'videoDescriptionTranslation'
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
	public $thumbnailModel = "YoutubeVideos.VideoThumbnail";

/**
 * Thumbnail table
 *
 * @var string
 */
	public $thumbnailTable = "video_thumbnails";

/**
 * Translate model
 *
 * @var string
 */
	public $translateModel = "YoutubeVideos.VideoI18n";

/**
 * Translate table
 *
 * @var string
 */
	public $translateTable = "video_i18n";

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
		'youtube_video_id' => array(
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'Youtube Video ID has to be at least 3 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'maxLength' => array(
				'rule' => array('maxLength', 32),
				'message' => 'Youtube Video ID can not be exceeded 255 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Youtube Video ID can not be empty.',
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
		'VideoAlbum' => array(
			'className' => 'VideoAlbum',
			'foreignKey' => 'video_album_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function setLanguage($locale)
	{
		$this->locale = $locale;
	}

	public function getFirstVideo($conditions = array())
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
