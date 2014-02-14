<?php
App::uses('PageAttachmentType', 'Dreamcms.Model');

/**
 * PageAttachmentType Test Case
 *
 */
class PageAttachmentTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dreamcms.page_attachment_type',
		'plugin.dreamcms.page_attachment'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PageAttachmentType = ClassRegistry::init('Dreamcms.PageAttachmentType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PageAttachmentType);

		parent::tearDown();
	}

}
