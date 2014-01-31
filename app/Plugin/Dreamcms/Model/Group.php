<?php
App::uses('DreamcmsAppModel', 'Dreamcms.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
App::uses('AclBehavior', 'Model.Behavior');
App::uses('LogableBehavior', 'Dreamcms.Model.Behavior');

/**
 * Group Model
 *
 * @property Admin $Admin
 */
class Group extends CacheableModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Act as - Model's behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Acl' => array(
			'type' => 'requester'
		),
		'Dreamcms.Logable'
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'Group name has to be at least 3 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'maxLength' => array(
				'rule' => array('maxLength', 64),
				'message' => 'Group name can not be exceeded 64 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Group name can not be empty.',
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
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Admin' => array(
			'className' => 'Admin',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function parentNode() {
		return null;
	}

	public function getFirstGroup($conditions = array())
	{
		return $this->find(
			'first',
			array(
				'conditions' => $conditions,
				'order' => $this->alias . '.name ASC',
				'limit' => 1
			)
		);
	}

	public function findOneById($id)
	{
		return $this->find(
			'first',
			array(
				'conditions' => array($this->alias . '.id' => intval($id)),
				'order' => $this->alias . '.id ASC',
				'limit' => 1
			)
		);
	}

}
