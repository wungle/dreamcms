<?php
App::uses('PageAttachment', 'Dreamcms.Model');

/**
 * PageAttachment Test Case
 *
 */
class PageAttachmentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dreamcms.page_attachment',
		'plugin.dreamcms.page',
		'plugin.dreamcms.page_attachment_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PageAttachment = ClassRegistry::init('Dreamcms.PageAttachment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PageAttachment);

		parent::tearDown();
	}

}
