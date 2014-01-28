<?php
App::uses('CmsLog', 'Dreamcms.Model');

/**
 * CmsLog Test Case
 *
 */
class CmsLogTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dreamcms.cms_log'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CmsLog = ClassRegistry::init('Dreamcms.CmsLog');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CmsLog);

		parent::tearDown();
	}

}
