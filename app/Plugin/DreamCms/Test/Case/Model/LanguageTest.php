<?php
App::uses('Language', 'DreamCms.Model');

/**
 * Language Test Case
 *
 */
class LanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dream_cms.language'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Language = ClassRegistry::init('DreamCms.Language');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Language);

		parent::tearDown();
	}

}
