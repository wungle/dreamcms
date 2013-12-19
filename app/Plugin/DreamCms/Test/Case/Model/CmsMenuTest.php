<?php
App::uses('CmsMenu', 'DreamCms.Model');

/**
 * CmsMenu Test Case
 *
 */
class CmsMenuTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dream_cms.cms_menu'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CmsMenu = ClassRegistry::init('DreamCms.CmsMenu');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CmsMenu);

		parent::tearDown();
	}

}
