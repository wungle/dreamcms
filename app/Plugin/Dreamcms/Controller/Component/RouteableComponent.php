<?php

App::uses('Component', 'Controller');

class RouteableComponent extends Component
{
	private $controller;
	private $parentModel;
	private $rootNode;

	public $currentController;
	public $currentPlugin;
	public $humanize;
	public $singularize;

	// Required in cake 2.0++
	public function __construct(ComponentCollection $collection, $settings = array())
	{
		parent::__construct($collection, $settings);
	}

	// called before Controller::beforeFilter()
	public function initialize(Controller $controller)
	{
		$this->controller = &$controller;
    }

	// called after Controller::beforeFilter(), but before the controller executes the current action handler.
	public function startup(Controller $controller)
	{
		if (isset($this->controller->params->params['root_node']) && $this->parentModel)
		{
			$this->rootNode = $this->parentModel->find(
				'first',
				array(
					'conditions' => array(
						$this->parentModel->alias . '.' . $this->parentModel->primaryKey => $this->controller->params->params['root_node'],
					)
				)
			);
		}
		$this->currentController = isset($this->controller->params->params['controllerAlias']) ? $this->controller->params->params['controllerAlias'] : $this->controller->params->params['controller'];
		$this->currentPlugin = isset($this->controller->params->params['controllerAlias']) ? 'dreamcms' : $this->controller->params->params['plugin'];
		$this->humanize = Inflector::humanize($this->currentController);
		$this->singularize = Inflector::singularize($this->humanize);

		Configure::write('DreamCMS.Routeable.current_controller', $this->currentController);
	}

	// called after the controller executes the requested action's logic but before the controller's renders views and layout.
	public function beforeRender(Controller $controller)
	{
	}

	// called after Controller::render() and before the output is printed to the browser
	public function shutdown(Controller $controller)
	{
	}

	public function setParentModel(Model $model)
	{
		$this->parentModel = &$model;
	}

	public function getFindConditions()
	{
		if (!$this->rootNode)
			return array();

		return array(
			$this->parentModel->alias . '.lft >' => $this->rootNode[$this->parentModel->alias]['lft'],
			$this->parentModel->alias . '.rght <' => $this->rootNode[$this->parentModel->alias]['rght'],
		);
	}

	public function getAssociatedFindConditions($index)
	{
		if (!$this->rootNode)
			return array();
		
		$result = $this->parentModel->find(
			'list',
			array(
				'fields' => array($this->parentModel->alias . '.' . $this->parentModel->primaryKey, $this->parentModel->alias . '.' . $this->parentModel->primaryKey),
				'conditions' => array(
					$this->parentModel->alias . '.lft >=' => $this->rootNode[$this->parentModel->alias]['lft'],
					$this->parentModel->alias . '.rght <=' => $this->rootNode[$this->parentModel->alias]['rght'],
				),
				'order' => $this->parentModel->alias . '.' . $this->parentModel->primaryKey
			)
		);
		sort($result);
		return array(
			$index => $result
		);
	}

	public function getTreeListConditions()
	{
		if (!$this->rootNode)
			return array();

		return array(
			$this->parentModel->alias . '.lft >=' => $this->rootNode[$this->parentModel->alias]['lft'],
			$this->parentModel->alias . '.rght <=' => $this->rootNode[$this->parentModel->alias]['rght'],
		);
	}
}

?>