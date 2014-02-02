<?php
App::uses('VideoAlbum', 'YoutubeVideos.Model');

/**
 * VideoAlbum Test Case
 *
 */
class VideoAlbumTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.youtube_videos.video_album',
		'plugin.youtube_videos.video'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->VideoAlbum = ClassRegistry::init('YoutubeVideos.VideoAlbum');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->VideoAlbum);

		parent::tearDown();
	}

}
