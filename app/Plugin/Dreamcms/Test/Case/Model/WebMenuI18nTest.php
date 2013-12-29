<?php
App::uses('WebMenuI18n', 'Dreamcms.Model');

/**
 * WebMenuI18n Test Case
 *
 */
class WebMenuI18nTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dreamcms.web_menu_i18n'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->WebMenuI18n = ClassRegistry::init('Dreamcms.WebMenuI18n');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->WebMenuI18n);

		parent::tearDown();
	}

}
