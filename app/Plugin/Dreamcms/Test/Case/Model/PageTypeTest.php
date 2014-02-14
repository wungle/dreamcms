<?php
App::uses('PageType', 'Dreamcms.Model');

/**
 * PageType Test Case
 *
 */
class PageTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dreamcms.page_type',
		'plugin.dreamcms.page'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PageType = ClassRegistry::init('Dreamcms.PageType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PageType);

		parent::tearDown();
	}

}
