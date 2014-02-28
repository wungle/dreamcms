<?php
App::uses('Tagged', 'Dreamcms.Model');

/**
 * Tagged Test Case
 *
 */
class TaggedTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dreamcms.tagged'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Tagged = ClassRegistry::init('Dreamcms.Tagged');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Tagged);

		parent::tearDown();
	}

}
