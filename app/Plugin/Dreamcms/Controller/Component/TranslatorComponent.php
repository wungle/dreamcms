<?php

App::uses('Component', 'Controller');

class TranslatorComponent extends Component
{
	private $controller;
	private $data;
	private $defaultLanguage;
	private $localeList;
	private $model;
	private $processedData;
	private $translateFields;
	private $validated;

	// Required in cake 2.0++
	public function __construct(ComponentCollection $collection, $settings = array())
	{
		parent::__construct($collection, $settings);
	}

	// called before Controller::beforeFilter()
	public function initialize(Controller $controller)
	{
		$this->controller = &$controller;
		$this->model = null;
    }

	// called after Controller::beforeFilter(), but before the controller executes the current action handler.
	public function startup(Controller $controller)
	{
		$this->defaultLanguage = Configure::read('Config.language');

		$this->controller->loadModel('Dreamcms.Language');
		$this->localeList = $this->controller->Language->find(
			'list',
			array(
				'fields' => array('Language.name', 'Language.locale'),
				'order' => 'Language.name ASC'
			)
		);
		$this->controller->set('localeList', $this->localeList);
	}

	// called after the controller executes the requested action's logic but before the controller's renders views and layout.
	public function beforeRender(Controller $controller)
	{
	}

	// called after Controller::render() and before the output is printed to the browser
	public function shutdown(Controller $controller)
	{
	}

	public function findFirst(Controller $model, $params = array())
	{
		$result = $model->find("first", $params);
		
		foreach ($model->actsAs["Translate"] as $field => $translate)
			if ( Set::check($result, "{$model->name}.{$field}") )
				$result[$model->name][$field] = Set::combine(
					$result[$translate],
					"{n}.locale",
					"{n}.content"
				);
		
		return $result;
	}

	public function init(Controller $model, $data)
	{
		$this->data = $data;
		$this->model = &$model;
		$this->processedData = $data;
		$this->translateFields = array();
		$this->validated = false;

		foreach ($this->model->actsAs['Translate'] as $field => $translate)
		{
			unset($this->processedData[$this->model->name][$field]); // is this necessary ??
			if (isset($this->data[$this->model->name][$field][$this->defaultLanguage]))
				$this->processedData[$this->model->name][$field] = $this->data[$this->model->name][$field][$this->defaultLanguage];
			$this->translateFields[] = $field;
		}
	}

	public function validate()
	{
		if (!$this->doValidate())
			return false;

		foreach ($this->translateFields as $field)
		{
			if (!isset($this->data[$this->model->name][$field]))
				continue;

			foreach ($this->data[$this->model->name][$field] as $locale => $value)
			{
				if (!$this->doValidate(
					array($this->model->name => array($field => $value)),
					array($field)
				))
					return false;
			}
		}

		$this->validated = true;
		return true;
	}

	public function save()
	{
		if (!$this->model)
		{
			$this->controller->Session->setFlash(__('Translator Component is not initialized.'), 'flash/error');
			return false;
		}

		if (!$this->validated && !$this->validate())
			return false;

		$this->model->setLanguage($this->defaultLanguage);
		$this->model->create($this->processedData);
		$this->model->save($this->processedData, false);

		if (!isset($this->processedData[$this->model->name][$this->model->primaryKey]))
			$this->processedData[$this->model->name][$this->model->primaryKey] = $this->model->id;

		$lastData = null;

		foreach ($this->localeList as $locale)
		{
			foreach ($this->translateFields as $field)
				if (isset($this->data[$this->model->name][$field][$locale]))
					$this->processedData[$this->model->name][$field] = $this->data[$this->model->name][$field][$locale];

			if ($locale == $this->defaultLanguage)
			{
				$lastData = $this->processedData;
				continue;
			}

			$this->model->create($this->processedData);
			$this->model->setLanguage($locale);
			$this->model->save($this->processedData, false);
		}

		// Save in default language for the last time - for a better associated data
		if ($lastData)
		{
			$this->model->setLanguage($this->defaultLanguage);
			$this->model->create($lastData);
			$this->model->save($lastData, false);
		}

		return true;
	}

	protected function doValidate($data = null, $fields = null)
	{
		if (!$this->model)
		{
			$this->controller->Session->setFlash(__('Translator Component is not initialized.'), 'flash/error');
			return false;
		}

		if (!$data)
			$data = $this->processedData;

		$this->model->create($data);
		
		if (
			( ($fields) && (!$this->model->validates( array('fieldList' => $fields))) ) ||
			( (!$fields) && (!$this->model->validates()) )
		)
		{
			$error = array_values($this->model->invalidFields());
			$this->controller->Session->setFlash(__($error[0][0]), 'flash/error');
			return false;
		}
		else
			return true;
	}
}

?>