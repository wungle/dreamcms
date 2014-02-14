<?php
App::uses('PageI18n', 'Dreamcms.Model');

/**
 * PageI18n Test Case
 *
 */
class PageI18nTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dreamcms.page_i18n'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PageI18n = ClassRegistry::init('Dreamcms.PageI18n');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PageI18n);

		parent::tearDown();
	}

}
