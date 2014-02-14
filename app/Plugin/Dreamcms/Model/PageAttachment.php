<?php
App::uses('DreamcmsAppModel', 'Dreamcms.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
/**
 * PageAttachment Model
 *
 * @property Page $Page
 * @property PageAttachmentType $PageAttachmentType
 */
class PageAttachment extends CacheableModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

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
		'Page' => array(
			'className' => 'Page',
			'foreignKey' => 'page_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PageAttachmentType' => array(
			'className' => 'PageAttachmentType',
			'foreignKey' => 'page_attachment_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
