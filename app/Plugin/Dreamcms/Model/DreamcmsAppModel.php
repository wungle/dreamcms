<?php

App::uses('AppModel', 'Model');

class DreamcmsAppModel extends AppModel {

	protected $multiLanguageTransactionStarted = false;
	protected $multiLanguageTransactionEnded = false;

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
