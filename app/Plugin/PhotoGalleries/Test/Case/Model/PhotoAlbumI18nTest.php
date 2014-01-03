<?php
App::uses('PhotoAlbumI18n', 'PhotoGalleries.Model');

/**
 * PhotoAlbumI18n Test Case
 *
 */
class PhotoAlbumI18nTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.photo_galleries.photo_album_i18n'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PhotoAlbumI18n = ClassRegistry::init('PhotoGalleries.PhotoAlbumI18n');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PhotoAlbumI18n);

		parent::tearDown();
	}

}
