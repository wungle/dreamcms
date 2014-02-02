<?php
App::uses('VideoThumbnail', 'YoutubeVideos.Model');

/**
 * VideoThumbnail Test Case
 *
 */
class VideoThumbnailTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.youtube_videos.video_thumbnail'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->VideoThumbnail = ClassRegistry::init('YoutubeVideos.VideoThumbnail');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->VideoThumbnail);

		parent::tearDown();
	}

}
