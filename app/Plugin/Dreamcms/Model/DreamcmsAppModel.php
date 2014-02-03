<?php

App::uses('AppModel', 'Model');

class DreamcmsAppModel extends AppModel {

	protected $modelSchema;

	protected $multiLanguageTransactionStarted = false;
	protected $multiLanguageTransactionEnded = false;

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

	public function resetMultiLanguageTransaction()
	{
		$this->multiLanguageTransactionStarted = false;
		$this->multiLanguageTransactionEnded = false;
	}

	public function multiLanguageTransaction($status = null)
	{
		if ($status == 'start')
			$this->multiLanguageTransactionStarted = true;
		elseif ($status == 'end')
			$this->multiLanguageTransactionEnded = true;

		if ($this->multiLanguageTransactionStarted && $this->multiLanguageTransactionEnded)
			return 2;
		elseif ($this->multiLanguageTransactionStarted && !$this->multiLanguageTransactionEnded)
			return 1;
		else
			return 0;
	}
}
