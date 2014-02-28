<?php
App::uses('DreamcmsAppModel', 'Dreamcms.Model');
App::uses('CacheableModel', 'Dreamcms.Model');

/**
 * Tag Model
 *
 */
class Tag extends CacheableModel {

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
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Tag name can not be empty.',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'Tag name has already been taken.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'slug' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Tag slug can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'update', // Limit validation to 'create' or 'update' operations
			),
		),
	);


/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Tagged' => array(
			'className' => 'Tagged',
			'foreignKey' => 'tag_id',
			'dependent' => true,
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

/**
 * Returns tags matching first letters
 *
 * @param string $first_letters
 * @param int $limit Max number of results, defaults to 10
 * @return array Matching tag names as a simple associative array
 */
	function suggest($first_letters = '', $limit = 10)
	{
		if(empty($first_letters))
		{
			return;
		}
		
		$first_letters = trim($first_letters);
		
		if(empty($first_letters)) return;
		
		$fields     = array('name');
		$conditions = array('name LIKE' => "{$first_letters}%");
		$order      = 'name ASC';
		$recursive  = -1;
		
		return array_values($this->find('list', compact(
			'fields', 'conditions', 'order', 'limit', 'recursive'
		)));
	}
	
/**
 * Save a tag and the association with the tagged model
 *
 * @param string $tag Tag name
 * @param array $tagged Tagged model parameters array : tagged model name and tagged model primary key
 */
	function saveTag($tag = '', $tagged = array())
	{
		if(empty($tag) or empty($tagged))
		{
			return;
		}
		
		// Tag exists ?
		$this->recursive = -1;
		
		//if(!$this->data = $this->find(array('name' => $tag)))
		if(!$this->data = $this->find('first', array('conditions' => array('Tag.name' => $tag), 'limit' => 1)))
		{
			$this->data = array('Tag' => array('name' => $tag, 'slug' => strtolower(Inflector::slug($tag, '_'))));
		}
		
		// Related model
		$this->data['Tagged'] = array($tagged);
		
		return $this->saveAll($this->data);
	}

/**
 * Find used tags, all models
 *
 * @param array $options Options (same as classic find options)
 * Two new keys available :
 * - min_count : minimum number of times a tag is used
 * - max_count : maximum number of times a tag is used
 * @return array
 */
	function tagCloud($options = array())
	{
		// Counting bounds:
		// 'min_count' and/or 'max_count' in $options ?
		$conditions = array();
		
		if(isset($options['min_count']))
		{
			$conditions[] = 'Tag.count >= ' . $options['min_count'];
			unset($options['min_count']);
		} else {
			$conditions[] = 'Tag.count > 0';
		}
		
		if(isset($options['max_count']))
		{
			$conditions[] = 'Tag.count <= ' . $options['max_count'];
			unset($options['max_count']);
		}
				
		$options = Set::merge(compact('conditions'), $options);
		
		// ORDER BY default
		if(empty($options['order']))
		{
			$options['order'] = 'name ASC';
		}
		
		// Recursive level imposed
		$options['recursive'] = -1;
		
		return $this->find('all', $options);
	}

}
