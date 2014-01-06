<?php
App::uses('PhotoGalleriesAppModel', 'PhotoGalleries.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
/**
 * PhotoAlbumI18n Model
 *
 */
class PhotoAlbumI18n extends CacheableModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'photo_album_i18n';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'field';

}
