<?php
App::uses('DreamCmsAppModel', 'DreamCms.Model');
App::uses('Security', 'Component');
/**
 * Admin Model
 *
 * @property Group $Group
 */
class Admin extends DreamCmsAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'username';

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
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Password can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password_confirm' => array(
			'minLength' => array(
				'rule' => array('minLength', 8),
				'message' => 'Password confirmation has to be at least 8 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Password confirmation can not be empty.',
				//'allowEmpty' => false,
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

	public function beforeSave($options = array())
	{
		if (isset($this->data['Admin']['password_confirm']))
			unset($this->data['Admin']['password_confirm']);
		
		if (isset($this->data['Admin']['old_password']))
			unset($this->data['Admin']['old_password']);
		
		if (isset($this->data['Admin']['password']))
			$this->data['Admin']['password'] = Security::hash($this->data['Admin']['password'], 'blowfish');
		
		return true;
	}
	
	public function matchConfirmation($check)
	{
		if (
			isset($this->data['Admin']['password_confirm']) &&
			isset($this->data['Admin']['password']) &&
			($this->data['Admin']['password'] != $this->data['Admin']['password_confirm'])
		)
			return false;
		
		return true;
	}
	
	public function matchOldPassword($check)
	{
		if (
			isset($this->data['Admin']['old_password']) &&
			isset($this->data['Admin']['password']) &&
			isset($this->data['Admin']['admin_id'])
		)
		{
			$temp = $this->find(
				'first',
				array(
					'conditions' => array('Admin.admin_id' => $this->data['Admin']['admin_id']),
					'limit' => '1'
				)
			);
			
			if ( $temp && ($temp['Admin']['password'] != Security::hash($this->data['Admin']['old_password'], 'blowfish')) )
				return false;
		}
		
		return true;
	}
}
