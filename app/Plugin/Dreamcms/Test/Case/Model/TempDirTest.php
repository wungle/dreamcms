<?php
App::uses('TempDir', 'Dreamcms.Model');

/**
 * TempDir Test Case
 *
 */
class TempDirTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dream_cms.temp_dir'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TempDir = ClassRegistry::init('Dreamcms.TempDir');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TempDir);

		parent::tearDown();
	}

}
