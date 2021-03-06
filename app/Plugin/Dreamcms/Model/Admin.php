<?php
App::uses('DreamcmsAppModel', 'Dreamcms.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
App::uses('AclBehavior', 'Model.Behavior');
App::uses('LogableBehavior', 'Dreamcms.Model.Behavior');
App::uses('Security', 'Utility');

/**
 * Admin Model
 *
 * @property Group $Group
 */
class Admin extends CacheableModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'username';

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
		'username' => array(
			'alphaNumeric' => array(
				'rule' => array('alphaNumeric'),
				'message' => 'Username can contains only alphanumeric characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'minLength' => array(
				'rule' => array('minLength', 5),
				'message' => 'Username has to be at least 5 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'maxLength' => array(
				'rule' => array('maxLength', 32),
				'message' => 'Username can not be exceeded 32 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Username can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Username already exists.'
			)
		),
		'old_password' => array(
			'minLength' => array(
				'rule' => array('minLength', 8),
				'message' => 'Old password has to be at least 8 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Old password can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'matchOldPassword' => array(
				'rule' => 'matchOldPassword',
				'message' => 'Your old password is invalid.'
			),
		),
		'password' => array(
			'minLength' => array(
				'rule' => array('minLength', 8),
				'message' => 'Password has to be at least 8 characters.',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password_confirm' => array(
			'minLength' => array(
				'rule' => array('minLength', 8),
				'message' => 'Password confirmation has to be at least 8 characters.',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'matchConfirmation' => array(
				'rule' => 'matchConfirmation',
				'message' => 'Password doesn\'t match with the password confirmation.'
			),
		),
		'real_name' => array(
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'Real name has to be at least 3 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'maxLength' => array(
				'rule' => array('maxLength', 128),
				'message' => 'Real name can not be exceeded 128 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Real name can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Please provide a valid email address',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Email can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Email already exists.'
			)
		),
		'active' => array(
			'inList' => array(
				'rule' => array('inList', array('Yes', 'No')),
				'message' => 'Please provide a valid active value.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Active value can not be empty.',
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
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function parentNode() {
		if (!$this->id && empty($this->data)) {
			return null;
		}
		if (isset($this->data[$this->alias]['group_id'])) {
			$groupId = $this->data[$this->alias]['group_id'];
		} else {
			$groupId = $this->field('group_id');
		}
		if (!$groupId) {
			return null;
		} else {
			return array('Group' => array('id' => $groupId));
		}
	}

	public function beforeSave($options = array())
	{
		if (isset($this->data[$this->alias]['password_confirm']))
			unset($this->data[$this->alias]['password_confirm']);
		
		if (isset($this->data[$this->alias]['old_password']))
			unset($this->data[$this->alias]['old_password']);
		
		if (isset($this->data[$this->alias]['password']) && !empty($this->data[$this->alias]['password']))
			$this->data[$this->alias]['password'] = Security::hash($this->data[$this->alias]['password'], 'blowfish');
		else
			unset($this->data[$this->alias]['password']);
		
		return true;
	}
	
	public function matchConfirmation($check)
	{
		if (
			isset($this->data[$this->alias]['password_confirm']) &&
			isset($this->data[$this->alias]['password']) &&
			($this->data[$this->alias]['password'] != $this->data[$this->alias]['password_confirm'])
		)
			return false;
		
		return true;
	}
	
	public function matchOldPassword($check)
	{
		if (
			isset($this->data[$this->alias]['old_password']) &&
			isset($this->data[$this->alias]['password']) &&
			isset($this->data[$this->alias]['admin_id'])
		)
		{
			$temp = $this->find(
				'first',
				array(
					'conditions' => array($this->alias . '.admin_id' => $this->data[$this->alias]['admin_id']),
					'limit' => '1'
				)
			);
			
			if ( $temp && ($temp[$this->alias]['password'] != Security::hash($this->data[$this->alias]['old_password'], 'blowfish')) )
				return false;
		}
		
		return true;
	}
}