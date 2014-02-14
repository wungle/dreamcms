<?php
App::uses('PageAttachmentThumbnail', 'Dreamcms.Model');

/**
 * PageAttachmentThumbnail Test Case
 *
 */
class PageAttachmentThumbnailTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dreamcms.page_attachment_thumbnail'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PageAttachmentThumbnail = ClassRegistry::init('Dreamcms.PageAttachmentThumbnail');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PageAttachmentThumbnail);

		parent::tearDown();
	}

}
