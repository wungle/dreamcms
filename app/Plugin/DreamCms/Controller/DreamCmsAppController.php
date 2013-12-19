<?php

App::uses('AppController', 'Controller');

class DreamCmsAppController extends AppController {
	public $theme = 'AceAdmin';

	public $components = array(
		'Session',
		'DataFinder',
	);

	public $helpers = array(
		'Html',
		'Form',
		'Number',
		'Paginator',
		'Session',
		'Text',
		'Time',
	);
}

?>