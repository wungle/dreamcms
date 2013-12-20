<?php
App::uses('Icon', 'DreamCms.Model');

/**
 * Icon Test Case
 *
 */
class IconTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dream_cms.icon'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Icon = ClassRegistry::init('DreamCms.Icon');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Icon);

		parent::tearDown();
	}

}
