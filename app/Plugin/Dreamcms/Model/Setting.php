<?php
App::uses('DreamcmsAppModel', 'Dreamcms.Model');
/**
 * Setting Model
 *
 */
class Setting extends DreamcmsAppModel {

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
		'value' => array(
			'minLength' => array(
				'rule' => array('minLength', 1),
				'message' => 'Value has to be at least 1 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Value can not be empty.',
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

	public function saveSettings($data)
    {
		foreach ($data['Setting'] as $key => $value)
			$this->query('UPDATE `' . $this->useTable . '` SET `value`=\'' . addslashes($value) . '\', `modified`=NOW() WHERE `name`=\'' . $key . '\' LIMIT 1');
    }
    
    public function loadSettings()
    {
		$temp = $this->find('all', array('conditions' => array('Setting.deleted' => '0'), 'order' => 'Setting.name ASC'));
		return array(
			'Setting' => Set::combine(
				$temp,
				'{n}.Setting.name',
				'{n}.Setting.value'
			),
			'Permisions' => Set::combine(
				$temp,
				'{n}.Setting.name',
				'{n}.Setting.value'
			)
		);
    }
    
    public function publishSettings()
    {
		$temp = array(
			'Setting' => Set::combine(
				$this->find('all', array('conditions' => array('Setting.deleted' => '0'), 'order' => 'Setting.name ASC')),
				'{n}.Setting.name',
				'{n}.Setting.value'
			)
		);
		
		foreach ($temp['Setting'] as  $key => $value)
			Configure::write('DreamCMS.' . $key, $value);
		
		Configure::write('Config.language', $temp['Setting']['default_language']);
		
		//if (Configure::read('DreamCMS.cache_status') == 'On')
		//	Configure::write('Cache.disable', false);
		//else
		//	Configure::write('Cache.disable', true);
    }
}
