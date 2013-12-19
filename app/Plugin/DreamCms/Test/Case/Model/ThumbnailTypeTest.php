<?php
App::uses('ThumbnailType', 'DreamCms.Model');

/**
 * ThumbnailType Test Case
 *
 */
class ThumbnailTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dream_cms.thumbnail_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ThumbnailType = ClassRegistry::init('DreamCms.ThumbnailType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ThumbnailType);

		parent::tearDown();
	}

}
