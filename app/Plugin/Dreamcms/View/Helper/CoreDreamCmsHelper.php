<?php

App::uses('AppHelper', 'View/Helper');

class CoreDreamCmsHelper extends AppHelper {

	// Required in cake 2.0++
	function __construct(View $view, $settings = array())
	{
		parent::__construct($view, $settings);
		//debug($options);
	}

	public function hasActiveChildMenu($childs, $params_here)
	{
		foreach ($childs as $child)
			if (strpos($params_here, $child['url']) === 0)
				return true;

		return false;
	}
}

?>