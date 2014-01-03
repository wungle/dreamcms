<?php
App::uses('Photo', 'PhotoGalleries.Model');

/**
 * Photo Test Case
 *
 */
class PhotoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.photo_galleries.photo',
		'plugin.photo_galleries.photo_album'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Photo = ClassRegistry::init('PhotoGalleries.Photo');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Photo);

		parent::tearDown();
	}

}
