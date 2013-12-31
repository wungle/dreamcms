<?php

App::uses('AclComponent', 'Controller/Component');

class DreamcmsAclComponent extends AclComponent
{
	private $action;
	private $admin;
	private $allMenu;
	private $controller;
	private $group;
	private $menu;
	private $node;
	private $url;

	// Required in cake 2.0++
	public function __construct(ComponentCollection $collection, $settings = array())
	{
		parent::__construct($collection, $settings);
	}

	// called before Controller::beforeFilter()
	public function initialize(&$controller)
	{
		$this->controller = &$controller;
		$this->action = $this->controller->params->params['action'];
		$this->url = $this->getUrlPredictions($this->controller->params->here);

		$this->controller->loadModel('Dreamcms.CmsMenu');
		$this->menu = $this->controller->CmsMenu->find(
			'first',
			array(
				'conditions' => array(
					'CmsMenu.published' => 'Yes',
					'CmsMenu.deleted' => 0,
					'CmsMenu.url' => $this->url
				),
				'order' => 'CmsMenu.lft DESC',
				'limit' => 1,
				'recursive' => 0
			)
		);

		$this->controller->loadModel('Dreamcms.Admin');
		$this->admin = array('Admin' => $this->controller->Session->read('Auth.User'));

		$this->controller->loadModel('Dreamcms.Group');
		$this->group = $this->controller->Group->find(
			'first',
			array(
				'conditions' => array(
					'Group.deleted' => 0,
					'Group.id' => $this->admin['Admin']['group_id']
				),
				'limit' => 1,
				'recursive' => 0
			)
		);

		if ($this->action == 'add')
			$this->action = 'create';
		if ($this->action == 'edit')
			$this->action = 'update';

		if (($this->action != 'create') && ($this->action != 'update') && ($this->action != 'delete'))
			$this->action = 'read';

		$this->allMenu = $this->controller->CmsMenu->getPublishedMenu();
		$this->publishCmsMenu('cms_menus', 'read');
		$this->publishCmsMenu('granted_cms_menus');
    }

	// called after Controller::beforeFilter(), but before the controller executes the current action handler.
	public function startup(&$controller)
	{
	}

	// called after the controller executes the requested action's logic but before the controller's renders views and layout.
	public function beforeRender(&$controller)
	{
		$this->controller->set('current_acl', $this->getCurrentAcl());
	}

	// called after Controller::render() and before the output is printed to the browser
	public function shutdown(&$controller)
	{
	}

	public function getCurrentAcl()
	{
		return array(
			'create' => $this->isAuthorized($this->admin, $this->group, $this->menu, 'create'),
			'read' => $this->isAuthorized($this->admin, $this->group, $this->menu, 'read'),
			'update' => $this->isAuthorized($this->admin, $this->group, $this->menu, 'update'),
			'delete' => $this->isAuthorized($this->admin, $this->group, $this->menu, 'delete')
		);
	}

	public function getGroupAcl($group, $menu = null)
	{
		if (!$menu)
			$menu = $this->allMenu;

		$data = array('Acl' => array());
		for ($i=0,$c=count($menu); $i<$c; $i++)
		{
			$id = $menu[$i]['CmsMenu']['id'];
			$data['Acl'][$id] = array(
				'create' => $this->check($group, $menu[$i], 'create'),
				'read' => $this->check($group, $menu[$i], 'read'),
				'update' => $this->check($group, $menu[$i], 'update'),
				'delete' => $this->check($group, $menu[$i], 'delete'),
			);

			if (isset($menu[$i]['ChildCmsMenu']) && (count($menu[$i]['ChildCmsMenu']) > 0))
			{
				$childs = array();
				foreach ($menu[$i]['ChildCmsMenu'] as $tmp)
					$childs[] = array('CmsMenu' => $tmp);

				$child_data = $this->getGroupAcl($group, $childs);

				$data = Set::merge($data, $child_data);
			}
		}
		return $data;
	}

	public function getAdminAcl($admin, $menu = null)
	{
		if (!$menu)
			$menu = $this->allMenu;

		$node = $this->controller->Admin->node($admin);

		$group = $this->controller->Group->find(
			'first',
			array(
				'conditions' => array('Group.id' => $node[1]['Aro']['foreign_key']),
				'limit' => 1
			)
		);

		$data = array('Acl' => array());
		for ($i=0,$c=count($menu); $i<$c; $i++)
		{
			$id = $menu[$i]['CmsMenu']['id'];
			$data['Acl'][$id] = array(
				'create' => $this->isAuthorized($admin, $group, $menu[$i], 'create'),
				'read' => $this->isAuthorized($admin, $group, $menu[$i], 'read'),
				'update' => $this->isAuthorized($admin, $group, $menu[$i], 'update'),
				'delete' => $this->isAuthorized($admin, $group, $menu[$i], 'delete'),
			);

			if (isset($menu[$i]['ChildCmsMenu']) && (count($menu[$i]['ChildCmsMenu']) > 0))
			{
				$childs = array();
				foreach ($menu[$i]['ChildCmsMenu'] as $tmp)
					$childs[] = array('CmsMenu' => $tmp);

				$child_data = $this->getAdminAcl($admin, $childs);

				$data = Set::merge($data, $child_data);
			}
		}

		return $data;
	}

	public function saveAcl($data, $aro = null)
	{
		if (!$aro)
		{
			$aro = (isset($data['Admin'])) ?
				array('Admin' => array('id' => $data['Admin']['id'])) :
				array('Group' => array('id' => $data['Group']['id']));
		}
		
		foreach ($data['Acl'] as $id => $access)
		{
			$aco = array('CmsMenu' => array('id' => $id));

			if ((intval($this->admin['Admin']['id']) !== 0) && (intval($this->admin['Admin']['group_id']) !== 0) && !$this->check($this->admin, $aco, '*'))
				continue;

			if (isset($access['create']))
			{
				if ($access['create'])
					$this->allow($aro, $aco, 'create');
				else
					$this->deny($aro, $aco, 'create');
			}
			else
				$this->allow($aro, $aco, 'create');

			if (isset($access['read']))
			{
				if ($access['read'])
					$this->allow($aro, $aco, 'read');
				else
					$this->deny($aro, $aco, 'read');
			}

			if (isset($access['update']))
			{
				if ($access['update'])
					$this->allow($aro, $aco, 'update');
				else
					$this->deny($aro, $aco, 'update');
			}
			else
				$this->allow($aro, $aco, 'update');

			if (isset($access['delete']))
			{
				if ($access['delete'])
					$this->allow($aro, $aco, 'delete');
				else
					$this->deny($aro, $aco, 'delete');
			}
			else
				$this->allow($aro, $aco, 'delete');
		}
	}

	public function denyNewAcoFromAllAro($aco)
	{
		$groups = $this->controller->Group->find(
			'all',
			array(
				'conditions' => array('Group.deleted' => 0),
				'recursive' => 0
			)
		);
		$admins = $this->controller->Admin->find(
			'all',
			array(
				'conditions' => array('Admin.deleted' => 0),
				'recursive' => 0
			)
		);
		foreach ($groups as $aro)
			$this->deny($aro, $aco, '*');
		foreach ($admins as $aro)
			$this->deny($aro, $aco, '*');
	}

	public function allowNewAcoFromAllAro($aco)
	{
		$groups = $this->controller->Group->find(
			'all',
			array(
				'conditions' => array('Group.deleted' => 0),
				'recursive' => 0
			)
		);
		$admins = $this->controller->Admin->find(
			'all',
			array(
				'conditions' => array('Admin.deleted' => 0),
				'recursive' => 0
			)
		);
		foreach ($groups as $aro)
			$this->allow($aro, $aco, '*');
		foreach ($admins as $aro)
			$this->allow($aro, $aco, '*');
	}

	public function authorize()
	{
		if (!$this->isAuthorized())
			throw new ForbiddenException("Access forbidden");
	}

	public function isAuthorized($admin = null, $group = null, $menu = null, $action = null)
	{
		if (!$admin)
			$admin = $this->admin;
		if (!$group)
			$group = $this->group;
		if (!$menu)
			$menu = $this->menu;
		if (!$action)
			$action = $this->action;

		return ((intval($admin['Admin']['id']) === 0) && (intval($admin['Admin']['group_id']) === 0)) ? 
			true : 
			($this->check($group, $menu, $action) || $this->check($admin, $menu, $action));
	}

	private function publishCmsMenu($var, $action = '*')
	{
		$cms_menus = $this->allMenu;

		if ((intval($this->admin['Admin']['id']) !== 0) && (intval($this->admin['Admin']['group_id']) !== 0))
		{
			for ($i=0,$c=count($cms_menus); $i<$c; $i++)
			{
				if (!$this->check($this->group, $cms_menus[$i], $action) && !$this->check($this->admin, $cms_menus[$i], $action))
					unset($cms_menus[$i]);

				if (isset($cms_menus[$i]['ChildCmsMenu']) && (count($cms_menus[$i]['ChildCmsMenu']) > 0))
				{
					for ($j=0,$d=count($cms_menus[$i]['ChildCmsMenu']); $j<$d; $j++)
						if (!$this->check($this->group, array('CmsMenu' => $cms_menus[$i]['ChildCmsMenu'][$j]), $action) && !$this->check($this->admin, array('CmsMenu' => $cms_menus[$i]['ChildCmsMenu'][$j]), $action))
							unset($cms_menus[$i]['ChildCmsMenu'][$j]);
				}
			}
		}

		$this->controller->set($var, $cms_menus);
	}

	private function getUrlPredictions($url)
	{
		$url = explode('/', str_replace('//', '/', $url));
		$result = array();

		for ($i=0; $i<3; $i++)
		{
			if (count($url) >= 3)
				$result[] = implode('/', $url);

			array_pop($url);
		}

		if (count($result) == 1)
			$result = $result[0];

		return $result;
	}
}

?>