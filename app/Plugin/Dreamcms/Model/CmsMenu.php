<?php
App::uses('DreamcmsAppModel', 'Dreamcms.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
App::uses('LogableBehavior', 'Dreamcms.Model.Behavior');

/**
 * CmsMenu Model
 *
 * @property CmsMenu $ParentCmsMenu
 * @property CmsMenu $ChildCmsMenu
 */
class CmsMenu extends CacheableModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * actsAs / Model behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Tree',
		'Acl' => array(
			'type' => 'controlled'
		),
		'Dreamcms.Logable'
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'icon' => array(
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'Icon has to be at least 3 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'maxLength' => array(
				'rule' => array('maxLength', 64),
				'message' => 'Icon can not be exceeded 64 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Icon can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'Menu name has to be at least 3 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'maxLength' => array(
				'rule' => array('maxLength', 64),
				'message' => 'Menu name can not be exceeded 64 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Menu name can not be empty.',
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
				'message' => 'URL can not be exceeded 255 characters.',
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
		'ParentCmsMenu' => array(
			'className' => 'CmsMenu',
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
		'ChildCmsMenu' => array(
			'className' => 'CmsMenu',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => array('ChildCmsMenu.published' => 'Yes', 'ChildCmsMenu.deleted' => '0'),
			'fields' => '',
			'order' => 'ChildCmsMenu.name ASC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function parentNode()
	{
		if (!$this->id && empty($this->data)) {
			return null;
		}
		if (isset($this->data[$this->alias]['parent_id'])) {
			$parentId = $this->data[$this->alias]['parent_id'];
		} else {
			$parentId = $this->field('parent_id');
		}
		if (!$parentId) {
			return null;
		} else {
			return array($this->alias => array('id' => $parentId));
		}
	}

	public function getPublishedMenu()
	{
		return $this->find(
			'all',
			array(
				'conditions' => array($this->alias . '.parent_id' => '0', $this->alias . '.published' => 'Yes'),
				'order' => $this->alias . '.name ASC',
				'recursive' => 2
			)
		);
	}
}
