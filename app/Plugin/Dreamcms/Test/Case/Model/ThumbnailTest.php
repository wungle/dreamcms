<?php
App::uses('Thumbnail', 'Dreamcms.Model');

/**
 * Thumbnail Test Case
 *
 */
class ThumbnailTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dreamcms.thumbnail'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Thumbnail = ClassRegistry::init('Dreamcms.Thumbnail');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Thumbnail);

		parent::tearDown();
	}

}
