<?php
App::uses('YoutubeVideosAppModel', 'YoutubeVideos.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
/**
 * VideoI18n Model
 *
 */
class VideoI18n extends CacheableModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'video_i18n';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'field';

}
