<?php
App::uses('PhotoGalleriesAppModel', 'PhotoGalleries.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
/**
 * PhotoThumbnail Model
 *
 */
class PhotoThumbnail extends CacheableModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

}
