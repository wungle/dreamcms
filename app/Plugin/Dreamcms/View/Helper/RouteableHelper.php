<?php

App::uses('AppHelper', 'View/Helper');

class RouteableHelper extends AppHelper {

	// Required in cake 2.0++
	public function __construct(View $view, $settings = array())
	{
		parent::__construct($view, $settings);

		$params = $this->params->params;
		if (isset($params['controllerAlias']))
			$params['controller'] = $params['controllerAlias'];

		if (isset($params['controllerAlias']) && ($params['plugin'] != 'dreamcms'))
			$params['plugin'] = 'dreamcms';

		$this->params->params = $params;
	}

	public function humanizeController()
	{
		return Inflector::humanize($this->getCurrentController());
	}

	public function singularizeController()
	{
		return Inflector::singularize(Inflector::humanize($this->getCurrentController()));
	}

	public function fixUrlRequest($params = array())
	{
		return Set::merge(
			$params,
			array(
				'controller' => $this->getCurrentController()
			)
		);
	}

	protected function getCurrentController()
	{
		return isset($this->params->params['controllerAlias']) ? $this->params->params['controllerAlias'] : $this->params->params['controller'];
	}
}

?>