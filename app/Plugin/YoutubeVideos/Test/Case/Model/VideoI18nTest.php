<?php
App::uses('VideoI18n', 'YoutubeVideos.Model');

/**
 * VideoI18n Test Case
 *
 */
class VideoI18nTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.youtube_videos.video_i18n'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->VideoI18n = ClassRegistry::init('YoutubeVideos.VideoI18n');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->VideoI18n);

		parent::tearDown();
	}

}
