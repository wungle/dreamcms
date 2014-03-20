<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class MyTestController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array(
		//'Dreamcms.PageAttachmentThumbnail',
		'Dreamcms.PageAttachmentType',
		'Dreamcms.PageAttachment',
		'Dreamcms.PageType', 
		'Dreamcms.Page'
	);

	public function aduh($param = null)
	{
		//echo '<pre>'; print_r($this->PageAttachment); echo '</pre>';

		$this->Page->setLanguage(Configure::read('Config.language'));

		$this->PageType->unbindModel(array('hasMany' => array('Page')));
		$this->PageAttachmentType->unbindModel(array('hasMany' => array('PageAttachment')));
		//$this->PageAttachment->unbindModel(array('belongsTo' => array('Page')));
		//$this->Page->PageAttachment->bindModel(array('hasMany' => array('Thumbnails' => array('className' => 'PageAttachmentThumbnail', 'foreignKey' => 'foreign_key', 'conditions' => array('Thumbnails.model' => 'PageAttachment')))));

		$data = $this->Page->findRelated(1, true, 20);

		$this->Page->setLanguage(Configure::read('Config.language'));

		$this->PageType->unbindModel(array('hasMany' => array('Page')));
		$this->PageAttachmentType->unbindModel(array('hasMany' => array('PageAttachment')));
		//$this->PageAttachment->unbindModel(array('belongsTo' => array('Page')));
		//$this->Page->PageAttachment->bindModel(array('hasMany' => array('Thumbnails' => array('className' => 'PageAttachmentThumbnail', 'foreignKey' => 'foreign_key', 'conditions' => array('Thumbnails.model' => 'PageAttachment')))));
		$this->Page->PageAttachment->bindThumbnails();

		$data2 = $this->Page->find('first', array(
			'conditions' => array('Page.id' => 2),
			'recursive' => 2
		));

		echo '<pre>';
		print_r($data);
		//print_r($this->Page->PageAttachment);
		echo '</pre>';

		die();
	}
}
