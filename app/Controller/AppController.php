<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public function beforeFilter()
	{
		// Load the website settings..
		$this->loadModel('Dreamcms.Setting');
		$this->Setting->publishSettings();

		if (Configure::read('DreamCMS.debug_status') == 'On')
		{
			Configure::write('debug', 2);
			$this->Toolbar = $this->Components->load('DebugKit.Toolbar');
		}
		else
			Configure::write('debug', 0);
		
		// Multi languages feature
		$locale = $this->Session->read('Config.language') ? $this->Session->read('Config.language') : 'en-US';
		Configure::write('Config.language', $locale);

		$this->loadModel('Dreamcms.Language');
		$languages = $this->Language->find(
			'list',
			array(
				'fields' => array('Language.id', 'Language.locale'),
				'conditions' => array('Language.deleted' => '0'),
				'order' => 'Language.id ASC'
			)
		);
		
		if (isset($this->params->query['setLocale']) && (in_array($this->params->query['setLocale'], $languages)))
		{
			Configure::write('Config.language', $this->params->query['setLocale']);
			$this->Session->write('Config.language', $this->params->query['setLocale']);
			$locale = $this->params->query['setLocale'];
		}
		
		// Pass default variables to the view
		$this->set('params_url', $this->params->url);
		$this->set('params_here', $this->params->here);
		$this->set('current_locale', $locale);
	}

	public function beforeRender()
	{
		// nothing
	}

	public function afterFilter()
	{
		// nothing
	}
}
