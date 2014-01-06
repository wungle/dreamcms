<?php
App::uses('DreamcmsAppModel', 'Dreamcms.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
/**
 * WebMenuI18n Model
 *
 */
class WebMenuI18n extends CacheableModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'web_menu_i18n';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'field';

}
