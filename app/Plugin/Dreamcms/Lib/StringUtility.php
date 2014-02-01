<?php
/**
 * Static Class StringUtility
 * 	-> You don't need to create any object of this class.
 */

App::uses("Security", 'Utility');
App::uses("String", 'Utility');

class StringUtility
{
	public function __construct($config = array()) {
	}

	public static function getControllerUrl($params_here, $controller_name)
	{
		if (substr($params_here, 0, 1) != '/')
			$params_here = '/' . $params_here;

		$test = explode('/', $params_here);
		$x = count($test) - 1;
		while ($test[$x] != $controller_name)
		{
			array_pop($test);
			$x = count($test) - 1;

			if ($x < 0)
				break;
		}

		return implode('/', $test);
	}
}

?>