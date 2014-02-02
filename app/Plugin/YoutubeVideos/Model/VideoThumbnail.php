<?php
App::uses('YoutubeVideosAppModel', 'YoutubeVideos.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
/**
 * VideoThumbnail Model
 *
 */
class VideoThumbnail extends CacheableModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

}
