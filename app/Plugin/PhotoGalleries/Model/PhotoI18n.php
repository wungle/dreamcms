<?php
App::uses('PhotoGalleriesAppModel', 'PhotoGalleries.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
/**
 * PhotoI18n Model
 *
 */
class PhotoI18n extends CacheableModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'photo_i18n';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'field';

}
