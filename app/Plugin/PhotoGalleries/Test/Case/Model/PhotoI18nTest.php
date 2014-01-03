<?php
App::uses('PhotoI18n', 'PhotoGalleries.Model');

/**
 * PhotoI18n Test Case
 *
 */
class PhotoI18nTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.photo_galleries.photo_i18n'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PhotoI18n = ClassRegistry::init('PhotoGalleries.PhotoI18n');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PhotoI18n);

		parent::tearDown();
	}

}
