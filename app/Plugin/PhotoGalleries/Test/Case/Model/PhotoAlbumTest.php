<?php
App::uses('PhotoAlbum', 'PhotoGalleries.Model');

/**
 * PhotoAlbum Test Case
 *
 */
class PhotoAlbumTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.photo_galleries.photo_album',
		'plugin.photo_galleries.photo'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PhotoAlbum = ClassRegistry::init('PhotoGalleries.PhotoAlbum');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PhotoAlbum);

		parent::tearDown();
	}

}
