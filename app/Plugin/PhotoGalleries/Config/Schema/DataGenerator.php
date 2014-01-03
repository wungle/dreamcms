<?php
App::uses('ClassRegistry', 'Utility');
App::uses('Set', 'Utility');
App::uses('AclComponent', 'Controller/Component');

App::uses('Admin', 'Dreamcms.Model');
App::uses('CmsMenu', 'Dreamcms.Model');
App::uses('Group', 'Dreamcms.Model');

class DataGenerator
{
	protected $createdTables;
	protected $initializedModels;

	public function __construct() {
		$this->createdTables = array();
		$this->initializedModels = array();
	}

	public function reportAfter($event = array()) {
		if (isset($event['create']))
		{
			$this->createdTables[] = $event['create'];
			$this->check();
		}
	}

	protected function check() {
		if (
			in_array('photo_albums', $this->createdTables) && in_array('photos', $this->createdTables) &&
			//in_array('photo_album_i18n', $this->createdTables) && in_array('photo_i18n', $this->createdTables) &&
			!in_array('CmsMenu', $this->initializedModels) && !in_array('ArosAcos', $this->initializedModels)
		)
		{
			$this->initCmsMenu();
			$this->initArosAcos();
		}
	}

	protected function initCmsMenu() {
		try {
			$cms_menu = ClassRegistry::init('Dreamcms.CmsMenu');
			$photos = $cms_menu->find(
				'first',
				array(
					'conditions' => array(
						'CmsMenu.url' => '/dreamcms/photo_galleries/photos',
						'CmsMenu.published' => 'Yes',
						'CmsMenu.deleted' => '0'
					)
				)
			);
			if (!$photos)
			{
				$cms_menu->create();
				$cms_menu->save(array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '1',
							'icon' => 'icon-picture',
							'name' => 'Photos',
							'url' => '/dreamcms/photo_galleries/photos',
						),
						$this->getDefaultValues()
					)
				));
			}

			$photo_albums = $cms_menu->find(
				'first',
				array(
					'conditions' => array(
						'CmsMenu.url' => '/dreamcms/photo_galleries/photo_albums',
						'CmsMenu.published' => 'Yes',
						'CmsMenu.deleted' => '0'
					)
				)
			);
			if (!$photo_albums)
			{
				$cms_menu->create();
				$cms_menu->save(array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '1',
							'icon' => 'icon-picture',
							'name' => 'Photo Albums',
							'url' => '/dreamcms/photo_galleries/photo_albums',
						),
						$this->getDefaultValues()
					)
				));
			}
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
		$this->initializedModels[] = 'CmsMenu';
	}

	protected function initArosAcos() {
		try {
			$cms_menu = ClassRegistry::init('Dreamcms.CmsMenu');
			$Aro = ClassRegistry::init('Aro');
			$Aco = ClassRegistry::init('Aco');
			$ArosAco = ClassRegistry::init('ArosAco');

			$cms_menus = $cms_menu->find(
				'list',
				array(
					'fields' => array('CmsMenu.id', 'CmsMenu.id'),
					'conditions' => array(
						'CmsMenu.published' => 'Yes',
						'CmsMenu.deleted' => '0',
						'CmsMenu.url' => array(
							'/dreamcms/photo_galleries/photo_albums',
							'/dreamcms/photo_galleries/photos',
						)
					)
				)
			);
			sort($cms_menus);

			$aros = $Aro->find('all');
			$acos = $Aco->find(
				'all',
				array(
					'conditions' => array(
						'model' => 'CmsMenu',
						'foreign_key' => $cms_menus
					)
				)
			);
			
			foreach ($aros as $aro)
			{
				foreach ($acos as $aco)
				{
					$ArosAco->create();
					$ArosAco->save(array(
						'ArosAco' => array(
							'aro_id' => $aro['Aro']['id'],
							'aco_id' => $aco['Aco']['id'],
							'_create' => '1',
							'_read' => '1',
							'_update' => '1',
							'_delete' => '1',
						)
					));
				}
			}
			
			unset($Aro, $Aco, $ArosAco, $aros, $acos, $aro, $aco);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
		$this->initializedModels[] = 'ArosAcos';
	}

	protected function getDefaultValues()
	{
		return array(
			'active' => 'Yes',
			'published' => 'Yes',
			'deleted' => '0',
			'created' => '2014-01-01 00:00:00',
			'modified' => '2014-01-01 00:00:00',
		);
	}
}

?>