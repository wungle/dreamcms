<?php
App::uses('PhotoThumbnail', 'PhotoGalleries.Model');

/**
 * PhotoThumbnail Test Case
 *
 */
class PhotoThumbnailTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.photo_galleries.photo_thumbnail'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PhotoThumbnail = ClassRegistry::init('PhotoGalleries.PhotoThumbnail');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PhotoThumbnail);

		parent::tearDown();
	}

}
