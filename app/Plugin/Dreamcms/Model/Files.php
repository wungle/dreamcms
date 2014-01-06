<?php
App::uses('DreamcmsAppModel', 'Dreamcms.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
App::uses('ThumbnailableBehavior', 'Dreamcms.Model.Behavior');
App::uses('TranslateBehavior', 'Model.Behavior');
App::uses('UploadableBehavior', 'Dreamcms.Model.Behavior');
/**
 * File Model
 *
 * @property FileType $FileType
 */
class Files extends CacheableModel {

/**
 * Use Table
 *
 * @var string
 */
	public $useTable = "files";

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

		// Uncomment the lines below to enable thumbnailable behavior in this model.
		//'Dreamcms.Thumbnailable' => array(
			/**
				savePath have to be inside of the WWW_ROOT directory
				ex : /files/thumbnails/
				the exact savePath would be WWW_ROOT/files/thumbnails/
			**/
			//'savePath' => 'path-to-save-the-uploaded-files',
		//	'fields' => array(
		//		'filename' => 'Thumbnails'
		//	)
		//),


		'Translate' => array(
			'name' => 'fileNameTranslation',
			'description' => 'fileDescriptionTranslation',
			'url' => 'fileUrlTranslation',
			'filename' => 'fileFilenameTranslation',
			'extension' => 'fileExtensionTranslation',
			'size' => 'fileSizeTranslation',
			'mime_type' => 'fileMimeTypeTranslation',
			'category' => 'fileCategoryTranslation',
			'width' => 'fileWidthTranslation',
			'height' => 'fileHeightTranslation'
		),
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
	public $translateModel = "Dreamcms.FileI18n";

/**
 * Translate table
 *
 * @var string
 */
	public $translateTable = "file_i18n";

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'minLength' => array(
				'rule' => array('minLength', 2),
				'message' => 'Name has to be at least 2 characters.',
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
				'rule' => array('minLength', 2),
				'message' => 'Description has to be at least 2 characters.',
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
		'url' => array(
			'minLength' => array(
				'rule' => array('minLength', 1),
				'message' => 'URL has to be at least 1 characters.',
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
				'message' => 'URL can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'priority' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Priority can contains only numeric characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Priority can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'filename' => array(
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
			'extension' => array(
				'rule' => array('extension', array(
					// Image format
					'bmp', 'gif', 'jpe', 'jpeg', 'jpg', 'png', 'svg', 'webp', 
					// Document format
					'doc', 'docx', 'epub', 'pdf', 'ppt', 'pptx', 'xls', 'xlsx', 
					// Archive format
					'tar', 'gz', 'bz2', 'rar', 'jar', 'tgz', 'zip', '7z', 
					// Video Format
					'3gp', 'asf', 'avi', 'divx', 'flv', 'mkv', 'mov', 'mp4', 'mpeg', 'mpg', 'ogv', 'rm', 'rmvb', 'swf', 'vid', 'webm', 'wmv', 'xvid',
					// Audio Format
					'aac', 'mid', 'midi', 'mogg', 'mp3', 'ogg', 'wav', 'wave', 'wma',
					// Other format
					'csv', 'torrent', 'txt', 'xml',
				)),
				'message' => 'The uploaded file type is not supported.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			/*
			'fileSize' => array(
				'rule' => array('fileSize', '<=', '5MB'),
				'message' => 'Filesize can not be exceeded 5MB.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			*/
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'File can not be empty.',
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
				'message' => 'Published value can not be empty.',
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
		'FileType' => array(
			'className' => 'Dreamcms.FileType',
			'foreignKey' => 'file_type_id',
			//'conditions' => '',
			//'fields' => '',
			//'order' => ''
		)
	);

	public function setLanguage($locale)
	{
		$this->locale = $locale;
	}

	public function getFirstFile($conditions = array())
	{
		return $this->find(
			'first',
			array(
				'conditions' => $conditions,
				'order' => 'Files.lft ASC',
				'limit' => 1
			)
		);
	}

	public function findOneById($id, $conditions = array())
	{
		$conditions = Set::merge($conditions, array('Files.id' => intval($id)));
		return $this->find(
			'first',
			array(
				'conditions' => $conditions,
				'order' => 'Files.id ASC',
				'limit' => 1
			)
		);
	}
}
