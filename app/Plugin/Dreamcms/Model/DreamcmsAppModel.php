<?php

App::uses('AppModel', 'Model');

class DreamcmsAppModel extends AppModel {

	protected $modelSchema;

	public function beforeFind($query)
	{
		if (!$this->modelSchema)
			$this->modelSchema = $this->schema();

		$parentResult = parent::beforeFind($query);
		if (is_array($parentResult))
			$query = $parentResult;
		elseif (!$parentResult)
			return false;

		if (isset($this->modelSchema['deleted']) && !isset($query['conditions'][$this->alias . '.deleted']) && !isset($query['conditions']['deleted']))
		{
			if (!isset($query['conditions']))
				$query['conditions'] = array();
			$query['conditions'][$this->alias . '.deleted'] = '0';

			return $query;
		}

		return true;
	}
}
