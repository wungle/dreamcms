<?php
App::uses('DreamcmsAppModel', 'Dreamcms.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
/**
 * Thumbnail Model
 *
 */
class Thumbnail extends CacheableModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

}
