<?php
/**
 * FileFixture
 *
 */
class FileFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
		'file_type_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'url' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'priority' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'filename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'extension' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'size' => array('type' => 'biginteger', 'null' => false, 'default' => null),
		'mime_type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'category' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'width' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'height' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'published' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 3, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => null, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'file_type_id_idx' => array('column' => 'file_type_id', 'unique' => 0),
			'priority' => array('column' => 'priority', 'unique' => 0),
			'category' => array('column' => 'category', 'unique' => 0),
			'published' => array('column' => 'published', 'unique' => 0),
			'deleted' => array('column' => 'deleted', 'unique' => 0)
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
			'file_type_id' => '',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'url' => 'Lorem ipsum dolor sit amet',
			'priority' => 1,
			'filename' => 'Lorem ipsum dolor sit amet',
			'extension' => 'Lorem ip',
			'size' => '',
			'mime_type' => 'Lorem ipsum dolor sit amet',
			'category' => 'Lorem ipsum dolor sit amet',
			'width' => 1,
			'height' => 1,
			'published' => 'L',
			'deleted' => 1,
			'created' => '2013-12-30 16:41:30',
			'modified' => '2013-12-30 16:41:30'
		),
	);

}
