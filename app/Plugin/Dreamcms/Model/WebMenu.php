<?php
App::uses('DreamcmsAppModel', 'Dreamcms.Model');
App::uses('TreeBehavior', 'Model.Behavior');
App::uses('TranslateBehavior', 'Model.Behavior');
/**
 * WebMenu Model
 *
 * @property WebMenu $ParentWebMenu
 * @property WebMenu $ChildWebMenu
 */
class WebMenu extends DreamcmsAppModel {

/**
 * Act as
 *
 * @var array
 */
	public $actsAs = array(
		'Tree',
		'Translate' => array(
			'name' => 'webMenuNameTranslation',
			'url' => 'webMenuUrlTranslation'
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
	public $translateModel = "Dreamcms.WebMenuI18n";

/**
 * Translate table
 *
 * @var string
 */
	public $translateTable = "web_menu_i18n";

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
		'ParentWebMenu' => array(
			'className' => 'WebMenu',
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
		'ChildWebMenu' => array(
			'className' => 'WebMenu',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => array('ChildWebMenu.published' => 'Yes', 'ChildWebMenu.deleted' => '0'),
			'fields' => '',
			'order' => 'ChildWebMenu.name ASC',
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

	public function getFirstWebMenu($conditions = array())
	{
		$conditions = Set::merge($conditions, array('WebMenu.deleted' => '0'));
		return $this->find(
			'first',
			array(
				'conditions' => $conditions,
				'order' => 'WebMenu.lft ASC',
				'limit' => 1
			)
		);
	}

	public function findOneById($id, $conditions = array())
	{
		$conditions = Set::merge($conditions, array('WebMenu.deleted' => '0', 'WebMenu.id' => intval($id)));
		return $this->find(
			'first',
			array(
				'conditions' => $conditions,
				'order' => 'WebMenu.id ASC',
				'limit' => 1
			)
		);
	}
}
