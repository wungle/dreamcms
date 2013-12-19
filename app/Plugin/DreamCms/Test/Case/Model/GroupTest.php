<?php
App::uses('Group', 'DreamCms.Model');

/**
 * Group Test Case
 *
 */
class GroupTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dream_cms.group',
		'plugin.dream_cms.admin'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Group = ClassRegistry::init('DreamCms.Group');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Group);

		parent::tearDown();
	}

}
