<?php
App::uses('DreamcmsAppModel', 'Dreamcms.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
/**
 * FileI18n Model
 *
 */
class FileI18n extends CacheableModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'file_i18n';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'field';

}
