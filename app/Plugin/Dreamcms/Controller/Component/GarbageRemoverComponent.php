<?php

App::uses('Component', 'Controller');

class GarbageRemoverComponent extends Component
{
	private $controller;
	private $tempDirs;

	// Required in cake 2.0++
	public function __construct(ComponentCollection $collection, $settings = array())
	{
		parent::__construct($collection, $settings);
	}

	// called before Controller::beforeFilter()
	public function initialize(&$controller)
	{
		$this->controller = &$controller;
    }

	// called after Controller::beforeFilter(), but before the controller executes the current action handler.
	public function startup(&$controller)
	{
		$this->controller->loadModel('Dreamcms.TempDir');
		$this->tempDirs = $this->controller->TempDir->find(
			'all',
			array(
				'conditions' => array('TempDir.deleted' => '0')
			)
		);
	}

	// called after the controller executes the requested action's logic but before the controller's renders views and layout.
	public function beforeRender(&$controller)
	{
		$this->cleanGarbage();
	}

	// called after Controller::render() and before the output is printed to the browser
	public function shutdown(&$controller)
	{
	}

	public function cleanGarbage()
	{
		foreach ($this->tempDirs as $dir)
			$this->doClean($dir);
	}

	private function doClean($dir)
	{
		$path = WWW_ROOT . $dir['TempDir']['path'];
		$lifespan = $dir['TempDir']['lifespan'];

		$handle = opendir($path);
		$cur_time = time();

		if ($handle)
		{
			while ( ($file = readdir($handle)) !== false )
			{
				if ( ($file != '.') && ($file != '..') && ($file != 'empty') && !is_dir($path . DS . $file) )
				{
					$mtime = filemtime($path . DS . $file);
					if (($cur_time - $mtime) > $lifespan)
						@unlink($path . DS . $file);
				}
			}
			closedir($handle);
		}
	}
}

?>