<?php
App::uses('YoutubeVideosAppModel', 'YoutubeVideos.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
/**
 * VideoAlbumI18n Model
 *
 */
class VideoAlbumI18n extends CacheableModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'video_album_i18n';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'field';

}
