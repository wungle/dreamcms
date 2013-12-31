<?php
App::uses('File', 'Dreamcms.Model');

/**
 * File Test Case
 *
 */
class FileTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->File = ClassRegistry::init('Dreamcms.File');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->File);

		parent::tearDown();
	}

}
