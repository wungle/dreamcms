<?php
App::uses('WebMenu', 'Dreamcms.Model');

/**
 * WebMenu Test Case
 *
 */
class WebMenuTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dreamcms.web_menu'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->WebMenu = ClassRegistry::init('Dreamcms.WebMenu');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->WebMenu);

		parent::tearDown();
	}

}
