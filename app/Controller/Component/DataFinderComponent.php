<?php

App::uses("Sanitize", "Utility");

class DataFinderComponent extends Component
{
	public $controller;
	public $model;
	public $components = array();
	public $session_key;
	public $conditions;

	public $fieldNames;
	public $displayNames;

	private $disabledFields = array(
		'id', 'parent_id', 'deleted', 'lft', 'rght', 'created', 'modified'
	);
	
	// Required in cake 2.0++
	function __construct(ComponentCollection $collection, $settings = array())
	{
		parent::__construct($collection, $settings);
	}
	
	// called before Controller::beforeFilter()
	public function initialize(Controller $controller)
	{
		$this->controller = &$controller;
		$this->session_key = 'DataFinder.' . $this->controller->name;
	}

	// called after Controller::beforeFilter(), but before the controller executes the current action handler.
	public function startup(Controller $controller)
	{
	}
	
	// called after the controller executes the requested action's logic but before the controller's renders views and layout.
	public function beforeRender(Controller $controller)
	{
		$this->controller->set('dataFinderConditions', $this->controller->Session->read($this->session_key));
	}
	
	// called after Controller::render() and before the output is printed to the browser
	public function shutdown(Controller $controller)
	{
	}

	public function setupConditions()
	{
		if (!$this->model)
			return false;

		if ($this->controller->data && isset($this->controller->data['DataFinder']))
			$this->controller->Session->write($this->session_key, $this->controller->data['DataFinder']);

		// ----------------------------------------
		// Generate conditions
		// ----------------------------------------
		$this->conditions = array();
		$data = $this->controller->Session->read($this->session_key);

		if (!is_array($data))
			return false;

		foreach ($data as $tmp)
		{
			if (
				!isset($tmp['field']) || empty($tmp['field']) ||
				!isset($tmp['op']) || empty($tmp['op']) ||
				!isset($tmp['value']) || empty($tmp['value'])
			)
				continue;
			
			if (strpos($tmp['field'], $this->model->alias . '.all_fields') !== false)
			{
				$grouped = array();

				foreach ($this->fieldNames as $field)
				{
					$field = str_replace('"', '', $field);
					
					if ($field == $this->model->alias . '.all_fields')
						continue;

					$key = $this->getConditionKey($field, $tmp['op']);
					$val = trim(Sanitize::clean($tmp['value']));

					if ($tmp['op'] == 'like')
						$val = '%' . $val . '%';

					$grouped[$key] = $val;
				}

				$this->conditions[] = array('OR' => $grouped);
			}
			else
			{
				$key = $this->getConditionKey($tmp['field'], $tmp['op']);
				$val = trim(Sanitize::clean($tmp['value']));

				if ($tmp['op'] == 'like')
					$val = '%' . $val . '%';

				$this->conditions[$key] = $val;
			}
		}

		// Setup conditions
		$paginate = $this->controller->paginate;
		$paginate['conditions'] = $this->conditions;
		$this->controller->paginate = $paginate;

		return $this->conditions;
	}

	public function setupModel(Model $model)
	{
		$this->model = &$model;

		$this->fieldNames = array('"' . $model->alias . '.' . 'all_fields"');
		$this->displayNames = array('"All Fields"');

		// Get associated models
		if (isset($model->belongsTo) && !empty($model->belongsTo))
			foreach($model->belongsTo as $associated => $opt)
			{
				$this->fieldNames[] = '"' . $associated . '.' . $model->$associated->displayField . '"';
				$this->displayNames[] = '"' . $associated . '"';
			}

		// Get model fields
		$fields = $model->getColumnTypes();
		foreach ($fields as $key => $val)
		{
			if (!in_array($key, $this->disabledFields))
			{
				$this->fieldNames[] = '"' . $model->alias . '.' . $key . '"';
				$this->displayNames[] = '"' . Inflector::humanize($key) . '"';
			}
		}

		//echo '<pre>'; print_r($this->fieldNames); echo '</pre>'; die();

		$this->controller->set('dataFinderFieldNames', $this->fieldNames);
		$this->controller->set('dataFinderDisplayNames', $this->displayNames);
	}

	private function getConditionKey($key, $op)
	{
		switch ($op)
		{
			case '<' :
				$key .= ' <';
				break;
			case '>' :
				$key .= ' >';
				break;
			case '<=' :
				$key .= ' <=';
				break;
			case '>=' :
				$key .= ' >=';
				break;
			case 'like' :
				$key .= ' LIKE ';
				break;
			default:
				break;
		}

		return $key;
	}
}

?>