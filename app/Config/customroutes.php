<?php

App::uses('ClassRegistry', 'Utility');
App::uses('CakeRequest', 'Network');


class DreamcmsCustomRoutes
{
	protected $DreamcmsPage;
	protected $request;

	public function __construct()
	{
		$this->DreamcmsPage = ClassRegistry::init(array('class' => 'AppModel', 'alias' => 'DreamcmsPage'), true);
		$this->DreamcmsPage->setSource('pages');
		$this->request = new CakeRequest();
	}

	public function route()
	{
		$here = str_replace('//', '/', $this->request->here);

		$page = $this->DreamcmsPage->find(
			'first',
			array(
				'fields' => array('DreamcmsPage.id', 'DreamcmsPage.path', 'DreamcmsPage.deleted', 'DreamcmsPage.published', 'DreamcmsPage.published_at'),
				'conditions' => array(
					'DreamcmsPage.path' => $here,
					'DreamcmsPage.deleted' => '0',
					'DreamcmsPage.published' => 'Yes',
					'DreamcmsPage.published_at <=' => date('Y-m-d H:i:s', time()),
				),
				'limit' => 1,
				'recursive' => 0
			)
		);

		if ($page)
		{
			//Router::connect($here, array('controller' => 'pages', 'action' => 'display', $page['DreamcmsPage']['id']));
			Router::connect($here, array('controller' => 'my_test', 'action' => 'aduh', $page['DreamcmsPage']['id']));
		}
	}

	public function cleanup()
	{
		unset($this->DreamcmsPage);
		unset($this->request);
	}
}

$customRoutes = new DreamcmsCustomRoutes();
$customRoutes->route();
$customRoutes->cleanup();

unset($customRoutes);

?>