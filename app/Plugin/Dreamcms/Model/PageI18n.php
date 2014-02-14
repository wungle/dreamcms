<?php
App::uses('DreamcmsAppModel', 'Dreamcms.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
/**
 * PageI18n Model
 *
 */
class PageI18n extends CacheableModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'page_i18n';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'field';

}
