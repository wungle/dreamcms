<?php
App::uses('DreamcmsAppModel', 'Dreamcms.Model');
/**
 * Icon Model
 *
 */
class Icon extends DreamcmsAppModel {

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
				'message' => 'Name can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public function getIconList()
	{
		$data = $this->find(
			'list',
			array(
				'fields' => array('Icon.name', 'Icon.name'),
				'order' => 'Icon.name ASC'
			)
		);

		return $data;
	}
}
