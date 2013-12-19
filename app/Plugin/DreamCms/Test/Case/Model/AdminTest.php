<?php
App::uses('Admin', 'DreamCms.Model');

/**
 * Admin Test Case
 *
 */
class AdminTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dream_cms.admin',
		'plugin.dream_cms.group'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Admin = ClassRegistry::init('DreamCms.Admin');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Admin);

		parent::tearDown();
	}

}
