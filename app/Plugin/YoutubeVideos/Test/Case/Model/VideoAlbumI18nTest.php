<?php
App::uses('VideoAlbumI18n', 'YoutubeVideos.Model');

/**
 * VideoAlbumI18n Test Case
 *
 */
class VideoAlbumI18nTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.youtube_videos.video_album_i18n'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->VideoAlbumI18n = ClassRegistry::init('YoutubeVideos.VideoAlbumI18n');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->VideoAlbumI18n);

		parent::tearDown();
	}

}
