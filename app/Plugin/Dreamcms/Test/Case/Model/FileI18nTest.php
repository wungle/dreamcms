<?php
App::uses('FileI18n', 'Dreamcms.Model');

/**
 * FileI18n Test Case
 *
 */
class FileI18nTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dreamcms.file_i18n'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->FileI18n = ClassRegistry::init('Dreamcms.FileI18n');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FileI18n);

		parent::tearDown();
	}

}
