<?php
/**
 * WebMenuFixture
 *
 */
class WebMenuFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
		'parent_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'url' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'published' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 3, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => null, 'key' => 'index'),
		'lft' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'index'),
		'rght' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'parent_id' => array('column' => 'parent_id', 'unique' => 0),
			'published' => array('column' => 'published', 'unique' => 0),
			'deleted' => array('column' => 'deleted', 'unique' => 0),
			'rght' => array('column' => 'rght', 'unique' => 0),
			'tree' => array('column' => array('lft', 'rght'), 'unique' => 0),
			'lft' => array('column' => 'lft', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '',
			'parent_id' => '',
			'name' => 'Lorem ipsum dolor sit amet',
			'url' => 'Lorem ipsum dolor sit amet',
			'published' => 'L',
			'deleted' => 1,
			'lft' => '',
			'rght' => '',
			'created' => '2013-12-26 21:55:58',
			'modified' => '2013-12-26 21:55:58'
		),
	);

}
