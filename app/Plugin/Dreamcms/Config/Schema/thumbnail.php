<?php 
class ThumbnailSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $thumbnails = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
		'thumbnail_type_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'model' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'foreign_key' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'index'),
		'field' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'locale' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 12, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'filename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'width' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'height' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'thumbnail_type_id' => array('column' => 'thumbnail_type_id', 'unique' => 0),
			'name' => array('column' => 'name', 'unique' => 0),
			'model' => array('column' => 'model', 'unique' => 0),
			'foreign_key' => array('column' => 'foreign_key', 'unique' => 0),
			'field' => array('column' => 'field', 'unique' => 0),
			'locale' => array('column' => 'locale', 'unique' => 0),
			'common_query1' => array('column' => array('model', 'foreign_key', 'field', 'locale'), 'unique' => 0),
			'common_query2' => array('column' => array('thumbnail_type_id', 'model', 'foreign_key', 'field', 'locale'), 'unique' => 0),
			'common_query3' => array('column' => array('model', 'foreign_key', 'field'), 'unique' => 0),
			'common_query4' => array('column' => array('thumbnail_type_id', 'model', 'foreign_key', 'field'), 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

}
