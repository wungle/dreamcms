<?php
App::uses('DreamcmsAppModel', 'Dreamcms.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
App::uses('LogableBehavior', 'Dreamcms.Model.Behavior');

/**
 * Setting Model
 *
 */
class Setting extends CacheableModel {

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
		foreach ($data[$this->alias] as $key => $value)
		{
			$setting = $this->find(
				'first',
				array(
					'conditions' => array($this->alias . '.name' => $key),
					'order' => $this->alias . '.id ASC',
					'limit' => 1
				)
			);
			$setting[$this->alias]['value'] = $value;
			$this->create();
			$this->save($setting);
		}
    }
    
    public function loadSettings()
    {
		$temp = $this->find('all', array('order' => $this->alias . '.name ASC'));
		return array(
			$this->alias => Set::combine(
				$temp,
				'{n}.' . $this->alias . '.name',
				'{n}.' . $this->alias . '.value'
			),
			'Permisions' => Set::combine(
				$temp,
				'{n}.' . $this->alias . '.name',
				'{n}.' . $this->alias . '.value'
			)
		);
    }
    
    public function publishSettings()
    {
		$temp = array(
			$this->alias => Set::combine(
				$this->find('all', array('order' => $this->alias . '.name ASC')),
				'{n}.' . $this->alias . '.name',
				'{n}.' . $this->alias . '.value'
			)
		);
		
		foreach ($temp[$this->alias] as  $key => $value)
			Configure::write('DreamCMS.' . $key, $value);
		
		Configure::write('Config.language', $temp[$this->alias]['default_language']);
		
		//if (Configure::read('DreamCMS.cache_status') == 'On')
		//	Configure::write('Cache.disable', false);
		//else
		//	Configure::write('Cache.disable', true);
    }
}
